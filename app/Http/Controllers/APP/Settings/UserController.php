<?php

namespace App\Http\Controllers\APP\Settings;

use App\Http\Controllers\Controller;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        return view('settings.user.index');
    }

    public function create()
    {
        return view('settings.user.create');
    }

    public function edit(User $user)
    {
        return view('settings.user.edit', compact('user'));
    }
}
