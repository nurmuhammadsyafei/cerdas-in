<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('app_siswa', function (Blueprint $table) {
            $table->string('user_code', 36)->nullable()->unique()->after('id');
        });

        // Backfill existing rows with a unique UUID each
        DB::table('app_siswa')->whereNull('user_code')->orderBy('id')->each(function ($row) {
            DB::table('app_siswa')->where('id', $row->id)->update([
                'user_code' => Str::uuid()->toString(),
            ]);
        });

        // Make the column non-nullable now that every row has a value
        Schema::table('app_siswa', function (Blueprint $table) {
            $table->string('user_code', 36)->nullable(false)->change();
        });
    }

    public function down(): void
    {
        Schema::table('app_siswa', function (Blueprint $table) {
            $table->dropUnique(['user_code']);
            $table->dropColumn('user_code');
        });
    }
};
