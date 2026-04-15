<?php

namespace App\Http\Controllers\APP\Master;

use App\Http\Controllers\Controller;
use App\Models\GuruSekolah;
use App\Models\Sekolah;
use App\Models\User;

class SekolahController extends Controller
{
    public function index()
    {
        return view('master.sekolah.index');
    }

    public function create()
    {
        $guruList = collect();
        return view('master.sekolah.create', compact('guruList'));
    }

    public function edit(Sekolah $sekolah)
    {
        // Hanya guru yang sudah di-assign ke sekolah ini
        $guruList = User::whereHas('guruSekolah', fn ($q) => $q->where('sekolah_id', $sekolah->id))
            ->where('is_active', true)
            ->orderBy('name')
            ->get(['id', 'name', 'email']);

        return view('master.sekolah.edit', compact('sekolah', 'guruList'));
    }
}
