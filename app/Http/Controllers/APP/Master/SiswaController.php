<?php

namespace App\Http\Controllers\APP\Master;

use App\Http\Controllers\Controller;
use App\Models\Siswa;

class SiswaController extends Controller
{
    public function index()
    {
        return view('master.siswa.index');
    }

    public function create()
    {
        return view('master.siswa.create');
    }

    public function edit(Siswa $siswa)
    {
        return view('master.siswa.edit', compact('siswa'));
    }
}
