<?php

namespace App\Http\Controllers\API\Master;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SiswaController extends Controller
{
    public function index(Request $request)
    {
        $query = Siswa::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                  ->orWhere('nisn', 'like', "%{$search}%")
                  ->orWhere('nis', 'like', "%{$search}%");
            });
        }

        $siswa = $query->orderBy('nama_lengkap')->paginate(15);

        return response()->json($siswa);
    }

    public function show(Siswa $siswa)
    {
        return response()->json($siswa);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nisn'                 => 'nullable|string|max:20|unique:app_siswa,nisn',
            'nis'                  => 'nullable|string|max:20|unique:app_siswa,nis',
            'nama_lengkap'         => 'required|string|max:100',
            'nama_panggilan'       => 'nullable|string|max:50',
            'bb'                   => 'nullable|numeric',
            'tb'                   => 'nullable|numeric',
            'jenis_kelamin'        => 'required|in:L,P',
            'tempat_lahir'         => 'nullable|string|max:100',
            'tanggal_lahir'        => 'nullable|date',
            'agama'                => 'nullable|string|max:20',
            'anak_ke'              => 'nullable|integer|min:1',
            'alamat_peserta_didik' => 'nullable|string',
            'nama_ayah'            => 'nullable|string|max:100',
            'nama_ibu'             => 'nullable|string|max:100',
            'no_hp_ortu'           => 'nullable|string|max:20',
            'pekerjaan_ayah'       => 'nullable|string|max:100',
            'pekerjaan_ibu'        => 'nullable|string|max:100',
            'alamat'               => 'nullable|string',
            'kode_pos'             => 'nullable|string|max:10',
            'kecamatan'            => 'nullable|string|max:100',
            'kab_kota'             => 'nullable|string|max:100',
            'provinsi'             => 'nullable|string|max:100',
            'foto'                 => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('siswa', 'public');
        }

        $siswa = Siswa::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Data siswa berhasil ditambahkan.',
            'data'    => $siswa,
        ], 201);
    }

    public function update(Request $request, Siswa $siswa)
    {
        $data = $request->validate([
            'nisn'                 => 'nullable|string|max:20|unique:app_siswa,nisn,' . $siswa->id,
            'nis'                  => 'nullable|string|max:20|unique:app_siswa,nis,' . $siswa->id,
            'nama_lengkap'         => 'required|string|max:100',
            'nama_panggilan'       => 'nullable|string|max:50',
            'bb'                   => 'nullable|numeric',
            'tb'                   => 'nullable|numeric',
            'jenis_kelamin'        => 'required|in:L,P',
            'tempat_lahir'         => 'nullable|string|max:100',
            'tanggal_lahir'        => 'nullable|date',
            'agama'                => 'nullable|string|max:20',
            'anak_ke'              => 'nullable|integer|min:1',
            'alamat_peserta_didik' => 'nullable|string',
            'nama_ayah'            => 'nullable|string|max:100',
            'nama_ibu'             => 'nullable|string|max:100',
            'no_hp_ortu'           => 'nullable|string|max:20',
            'pekerjaan_ayah'       => 'nullable|string|max:100',
            'pekerjaan_ibu'        => 'nullable|string|max:100',
            'alamat'               => 'nullable|string',
            'kode_pos'             => 'nullable|string|max:10',
            'kecamatan'            => 'nullable|string|max:100',
            'kab_kota'             => 'nullable|string|max:100',
            'provinsi'             => 'nullable|string|max:100',
            'foto'                 => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            if ($siswa->foto) {
                Storage::disk('public')->delete($siswa->foto);
            }
            $data['foto'] = $request->file('foto')->store('siswa', 'public');
        }

        $siswa->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Data siswa berhasil diperbarui.',
            'data'    => $siswa->fresh(),
        ]);
    }

    public function destroy(Siswa $siswa)
    {
        if ($siswa->foto) {
            Storage::disk('public')->delete($siswa->foto);
        }
        $siswa->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data siswa berhasil dihapus.',
        ]);
    }
}
