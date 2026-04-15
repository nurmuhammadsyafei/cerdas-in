<?php

namespace App\Http\Controllers\API\Master;

use App\Http\Controllers\Controller;
use App\Models\Sekolah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SekolahController extends Controller
{
    public function index(Request $request)
    {
        $query = Sekolah::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_sekolah', 'like', "%{$search}%")
                  ->orWhere('npsn', 'like', "%{$search}%")
                  ->orWhere('kab_kota', 'like', "%{$search}%");
            });
        }

        if ($request->boolean('all')) {
            return response()->json(['data' => $query->orderBy('nama_sekolah')->get()]);
        }

        return response()->json($query->orderBy('nama_sekolah')->paginate(15));
    }

    public function show(Sekolah $sekolah)
    {
        return response()->json($sekolah);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_sekolah'  => 'required|string|max:150',
            'npsn'          => 'nullable|string|max:20|unique:app_sekolah,npsn',
            'alamat_sekolah'=> 'nullable|string',
            'nama_jalan'    => 'nullable|string|max:150',
            'kode_pos'      => 'nullable|string|max:10',
            'kecamatan'     => 'nullable|string|max:100',
            'kab_kota'      => 'nullable|string|max:100',
            'provinsi'      => 'nullable|string|max:100',
            'telepon'       => 'nullable|string|max:30',
            'website'       => 'nullable|string|max:150',
            'email'         => 'nullable|email|max:100',
            'logo'               => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'kepala_sekolah_id'  => 'nullable|exists:users,id',
        ]);

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('sekolah', 'public');
        }

        $sekolah = Sekolah::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Data sekolah berhasil ditambahkan.',
            'data'    => $sekolah,
        ], 201);
    }

    public function update(Request $request, Sekolah $sekolah)
    {
        $data = $request->validate([
            'nama_sekolah'  => 'required|string|max:150',
            'npsn'          => 'nullable|string|max:20|unique:app_sekolah,npsn,' . $sekolah->id,
            'alamat_sekolah'=> 'nullable|string',
            'nama_jalan'    => 'nullable|string|max:150',
            'kode_pos'      => 'nullable|string|max:10',
            'kecamatan'     => 'nullable|string|max:100',
            'kab_kota'      => 'nullable|string|max:100',
            'provinsi'      => 'nullable|string|max:100',
            'telepon'       => 'nullable|string|max:30',
            'website'       => 'nullable|string|max:150',
            'email'         => 'nullable|email|max:100',
            'logo'               => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'kepala_sekolah_id'  => 'nullable|exists:users,id',
        ]);

        if ($request->hasFile('logo')) {
            if ($sekolah->logo) {
                Storage::disk('public')->delete($sekolah->logo);
            }
            $data['logo'] = $request->file('logo')->store('sekolah', 'public');
        }

        $sekolah->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Data sekolah berhasil diperbarui.',
            'data'    => $sekolah->fresh(),
        ]);
    }

    public function destroy(Sekolah $sekolah)
    {
        if ($sekolah->logo) {
            Storage::disk('public')->delete($sekolah->logo);
        }

        $sekolah->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data sekolah berhasil dihapus.',
        ]);
    }
}
