<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Menu extends Model
{
    protected $fillable = [
        'parent_id', 'name', 'label', 'icon', 'route_name', 'sort_order', 'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Menu::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Menu::class, 'parent_id')->orderBy('sort_order');
    }

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'role_menus');
    }

    /**
     * Returns only top-level (parent) menus with their active children, eager-loaded.
     */
    public static function topLevel(): Collection
    {
        return static::with(['children' => fn ($q) => $q->where('is_active', true)])
            ->whereNull('parent_id')
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();
    }

    /**
     * Returns menus accessible by a given role (with parent info).
     */
    public static function forRole(int $roleId): Collection
    {
        return static::with('parent')
            ->whereHas('roles', fn ($q) => $q->where('roles.id', $roleId))
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();
    }
}
