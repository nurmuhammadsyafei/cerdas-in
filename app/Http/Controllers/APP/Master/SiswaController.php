<?php

namespace App\Http\Controllers\APP\Master;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use Barryvdh\DomPDF\Facade\Pdf;

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

    public function pdf(Siswa $siswa)
    {
        $pdf = Pdf::loadView('master.siswa.pdf', compact('siswa'))
            ->setPaper('a4', 'portrait');

        return $pdf->stream("identitas-{$siswa->nisn}.pdf");
    }
}
