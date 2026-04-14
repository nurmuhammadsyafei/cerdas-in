<?php

namespace App\View\Composers;

use App\Models\Menu;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class SidebarComposer
{
    public function compose(View $view): void
    {
        $user = Auth::user();

        if (!$user) {
            $view->with('sidebarMenus', collect());
            return;
        }

        // Superadmin gets everything; others get only their role's menus
        if ($user->role?->name === 'superadmin') {
            $allowedNames = null; // null = all
        } else {
            $allowedNames = $user->role
                ? $user->role->menus()
                    ->where('menus.is_active', true)
                    ->whereNotNull('menus.parent_id')
                    ->pluck('menus.name')
                    ->flip()
                : collect()->flip();
        }

        // Build the tree: only top-level menus that have at least one allowed child
        $parents = Menu::with(['children' => fn ($q) => $q->where('is_active', true)->orderBy('sort_order')])
            ->whereNull('parent_id')
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get()
            ->map(function ($parent) use ($allowedNames) {
                // Filter children based on access
                $parent->visibleChildren = $parent->children->filter(function ($child) use ($allowedNames) {
                    return $allowedNames === null || $allowedNames->has($child->name);
                })->values();

                return $parent;
            })
            ->filter(fn ($parent) => $parent->visibleChildren->isNotEmpty())
            ->values();

        $view->with('sidebarMenus', $parents);
    }
}
