<?php

namespace App\Http\Controllers\APP\Settings;

use App\Http\Controllers\Controller;

class HakAksesController extends Controller
{
    public function index()
    {
        return view('settings.hak_akses.index');
    }
}
