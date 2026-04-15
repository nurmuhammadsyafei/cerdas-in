<?php

namespace App\Http\Controllers\APP\Master;

use App\Http\Controllers\Controller;
use App\Models\Sekolah;
use App\Models\User;

class GuruController extends Controller
{
    public function index()
    {
        return view('master.guru.index');
    }

    public function edit(User $user)
    {
        $user->load('guruSekolah.sekolah');
        $sekolahList = Sekolah::orderBy('nama_sekolah')->get(['id', 'nama_sekolah', 'kab_kota']);

        return view('master.guru.edit', compact('user', 'sekolahList'));
    }
}
