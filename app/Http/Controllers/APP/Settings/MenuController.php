<?php

namespace App\Http\Controllers\APP\Settings;

use App\Http\Controllers\Controller;
use App\Models\Menu;

class MenuController extends Controller
{
    public function index()
    {
        return view('settings.menu.index');
    }

    public function create()
    {
        return view('settings.menu.create');
    }

    public function edit(Menu $menu)
    {
        return view('settings.menu.edit', compact('menu'));
    }
}
