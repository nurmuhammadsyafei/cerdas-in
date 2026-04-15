<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('app_sekolah', function (Blueprint $table) {
            $table->id();
            $table->string('user_code', 36)->unique();
            $table->string('logo')->nullable();
            $table->string('nama_sekolah', 150);
            $table->string('npsn', 20)->nullable()->unique();
            $table->text('alamat_sekolah')->nullable();
            $table->string('nama_jalan', 150)->nullable();
            $table->string('kode_pos', 10)->nullable();
            $table->string('kecamatan', 100)->nullable();
            $table->string('kab_kota', 100)->nullable();
            $table->string('provinsi', 100)->nullable();
            $table->string('telepon', 30)->nullable();
            $table->string('website', 150)->nullable();
            $table->string('email', 100)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('app_sekolah');
    }
};
