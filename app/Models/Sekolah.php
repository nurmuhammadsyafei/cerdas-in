<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Sekolah extends Model
{
    protected $table = 'app_sekolah';

    protected $appends = ['logo_url'];

    protected $fillable = [
        'user_code', 'logo', 'nama_sekolah', 'npsn',
        'alamat_sekolah', 'nama_jalan', 'kode_pos',
        'kecamatan', 'kab_kota', 'provinsi',
        'telepon', 'website', 'email',
        'kepala_sekolah_id',
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

    public function getLogoUrlAttribute(): ?string
    {
        return $this->logo ? asset('storage/' . $this->logo) : null;
    }

    public function guruSekolah(): HasMany
    {
        return $this->hasMany(GuruSekolah::class, 'sekolah_id');
    }

    public function kepalaSekolah(): BelongsTo
    {
        return $this->belongsTo(User::class, 'kepala_sekolah_id');
    }
}
