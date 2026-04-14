<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('app_siswa', function (Blueprint $table) {
            $table->id();
            $table->string('foto')->nullable();
            $table->string('nisn', 20)->nullable();
            $table->string('nis', 20)->nullable();
            $table->string('nama_lengkap', 100);
            $table->string('nama_panggilan', 50)->nullable();
            $table->decimal('bb', 5, 2)->nullable()->comment('Berat Badan (Kg)');
            $table->decimal('tb', 5, 2)->nullable()->comment('Tinggi Badan (cm)');
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->string('tempat_lahir', 100)->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('agama', 20)->nullable();
            $table->tinyInteger('anak_ke')->nullable()->unsigned();
            $table->text('alamat_peserta_didik')->nullable();
            $table->string('nama_ayah', 100)->nullable();
            $table->string('nama_ibu', 100)->nullable();
            $table->string('no_hp_ortu', 20)->nullable();
            $table->string('pekerjaan_ayah', 100)->nullable();
            $table->string('pekerjaan_ibu', 100)->nullable();
            $table->text('alamat')->nullable();
            $table->string('kode_pos', 10)->nullable();
            $table->string('kecamatan', 100)->nullable();
            $table->string('kab_kota', 100)->nullable();
            $table->string('provinsi', 100)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('app_siswa');
    }
};
