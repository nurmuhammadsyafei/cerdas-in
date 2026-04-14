<?php

namespace App\Http\Controllers\API\Settings;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Role;
use Illuminate\Http\Request;

class HakAksesController extends Controller
{
    /**
     * Return the full menu tree with per-role access flags.
     * GET /api/settings/hak-akses?role_id=1
     */
    public function index(Request $request)
    {
        $request->validate(['role_id' => 'required|exists:roles,id']);

        $role            = Role::findOrFail($request->role_id);
        $grantedMenuIds  = $role->menus()->pluck('menus.id')->flip();

        $parents = Menu::with(['children' => fn ($q) => $q->orderBy('sort_order')])
            ->whereNull('parent_id')
            ->orderBy('sort_order')
            ->get()
            ->map(function ($parent) use ($grantedMenuIds) {
                $parent->children->transform(function ($child) use ($grantedMenuIds) {
                    $child->has_access = $grantedMenuIds->has($child->id);
                    return $child;
                });
                return $parent;
            });

        return response()->json($parents);
    }

    /**
     * Return all roles for the role selector.
     * GET /api/settings/hak-akses/roles
     */
    public function roles()
    {
        return response()->json(Role::orderBy('label')->get());
    }

    /**
     * Sync menu access for a role (replace all).
     * POST /api/settings/hak-akses
     * body: { role_id: 1, menu_ids: [2, 3, 5] }
     */
    public function sync(Request $request)
    {
        $data = $request->validate([
            'role_id'    => 'required|exists:roles,id',
            'menu_ids'   => 'present|array',
            'menu_ids.*' => 'exists:menus,id',
        ]);

        $role = Role::findOrFail($data['role_id']);

        // Only sync child (submenu) ids — never touch parent menus directly
        $childIds = Menu::whereNotNull('parent_id')
            ->whereIn('id', $data['menu_ids'])
            ->pluck('id')
            ->toArray();

        $role->menus()->sync($childIds);

        return response()->json([
            'success' => true,
            'message' => 'Hak akses berhasil disimpan.',
            'total'   => count($childIds),
        ]);
    }
}
