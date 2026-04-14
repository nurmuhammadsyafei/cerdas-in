<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    protected $table = 'app_siswa';

    protected $appends = ['foto_url'];

    protected $fillable = [
        'foto', 'nisn', 'nis', 'nama_lengkap', 'nama_panggilan',
        'bb', 'tb', 'jenis_kelamin', 'tempat_lahir', 'tanggal_lahir',
        'agama', 'anak_ke', 'alamat_peserta_didik',
        'nama_ayah', 'nama_ibu', 'no_hp_ortu',
        'pekerjaan_ayah', 'pekerjaan_ibu',
        'alamat', 'kode_pos', 'kecamatan', 'kab_kota', 'provinsi',
    ];

    public function getFotoUrlAttribute(): ?string
    {
        return $this->foto ? asset('storage/' . $this->foto) : null;
    }
}
