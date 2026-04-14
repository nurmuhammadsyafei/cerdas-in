<?php

namespace App\Http\Controllers\API\Settings;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    /**
     * Return full tree (parents with children), paginated by parent.
     */
    public function index(Request $request)
    {
        $query = Menu::with(['children' => fn ($q) => $q->orderBy('sort_order')])
            ->whereNull('parent_id')
            ->orderBy('sort_order');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('label', 'like', "%{$search}%")
                  ->orWhere('name', 'like', "%{$search}%")
                  ->orWhereHas('children', fn ($c) => $c->where('label', 'like', "%{$search}%"));
            });
        }

        $parents = $query->paginate(20);

        return response()->json($parents);
    }

    /**
     * All parent menus for dropdown (no pagination).
     */
    public function parents()
    {
        return response()->json(
            Menu::whereNull('parent_id')->orderBy('sort_order')->get(['id', 'label'])
        );
    }

    public function show(Menu $menu)
    {
        return response()->json($menu->load('parent'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'parent_id'  => 'nullable|exists:menus,id',
            'name'       => 'required|string|max:100|unique:menus,name',
            'label'      => 'required|string|max:100',
            'icon'       => 'nullable|string|max:100',
            'route_name' => 'nullable|string|max:150',
            'sort_order' => 'integer|min:0',
            'is_active'  => 'boolean',
        ]);

        // Parent menu tidak boleh menjadi child dari parent lain
        if (!empty($data['parent_id'])) {
            $parent = Menu::findOrFail($data['parent_id']);
            if ($parent->parent_id !== null) {
                return response()->json([
                    'message' => 'Hanya mendukung 2 level (parent → child).',
                    'errors'  => ['parent_id' => ['Menu parent tidak boleh berupa submenu.']],
                ], 422);
            }
        }

        $menu = Menu::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Menu berhasil ditambahkan.',
            'data'    => $menu->load('parent'),
        ], 201);
    }

    public function update(Request $request, Menu $menu)
    {
        $data = $request->validate([
            'parent_id'  => 'nullable|exists:menus,id',
            'name'       => 'required|string|max:100|unique:menus,name,' . $menu->id,
            'label'      => 'required|string|max:100',
            'icon'       => 'nullable|string|max:100',
            'route_name' => 'nullable|string|max:150',
            'sort_order' => 'integer|min:0',
            'is_active'  => 'boolean',
        ]);

        // Cegah parent menu dipindah menjadi child jika sudah punya children
        if (!empty($data['parent_id'])) {
            $parent = Menu::findOrFail($data['parent_id']);
            if ($parent->parent_id !== null) {
                return response()->json([
                    'message' => 'Hanya mendukung 2 level (parent → child).',
                    'errors'  => ['parent_id' => ['Menu parent tidak boleh berupa submenu.']],
                ], 422);
            }
            // Cegah menu punya children dijadikan submenu
            if ($menu->children()->exists()) {
                return response()->json([
                    'message' => 'Menu ini memiliki submenu. Hapus atau pindahkan submenu-nya terlebih dahulu.',
                    'errors'  => ['parent_id' => ['Menu yang memiliki submenu tidak bisa dijadikan submenu.']],
                ], 422);
            }
        }

        $menu->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Menu berhasil diperbarui.',
            'data'    => $menu->fresh()->load('parent'),
        ]);
    }

    public function destroy(Menu $menu)
    {
        if ($menu->children()->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Hapus semua submenu terlebih dahulu sebelum menghapus menu ini.',
            ], 422);
        }

        $menu->delete();

        return response()->json([
            'success' => true,
            'message' => 'Menu berhasil dihapus.',
        ]);
    }
}
