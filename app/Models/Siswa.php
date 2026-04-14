<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Siswa extends Model
{
    protected $table = 'app_siswa';

    protected $appends = ['foto_url'];

    protected $fillable = [
        'user_code', 'foto', 'nisn', 'nis', 'nama_lengkap', 'nama_panggilan',
        'bb', 'tb', 'jenis_kelamin', 'tempat_lahir', 'tanggal_lahir',
        'agama', 'anak_ke', 'alamat_peserta_didik',
        'nama_ayah', 'nama_ibu', 'no_hp_ortu',
        'pekerjaan_ayah', 'pekerjaan_ibu',
        'alamat', 'kode_pos', 'kecamatan', 'kab_kota', 'provinsi',
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (self $model): void {
            if (empty($model->user_code)) {
                $model->user_code = Str::uuid()->toString();
            }
        });
    }

    public function getRouteKeyName(): string
    {
        return 'user_code';
    }

    public function getFotoUrlAttribute(): ?string
    {
        return $this->foto ? asset('storage/' . $this->foto) : null;
    }
}
