<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('user_code', 36)->nullable()->unique()->after('id');
            $table->foreignId('role_id')->nullable()->constrained('roles')->nullOnDelete()->after('user_code');
            $table->timestamp('last_login')->nullable()->after('remember_token');
            $table->boolean('is_active')->default(true)->after('last_login');
        });

        // Backfill user_code for existing rows
        \DB::table('users')->whereNull('user_code')->orderBy('id')->each(function ($row) {
            \DB::table('users')->where('id', $row->id)->update([
                'user_code' => \Illuminate\Support\Str::uuid()->toString(),
            ]);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->string('user_code', 36)->nullable(false)->change();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['role_id']);
            $table->dropUnique(['user_code']);
            $table->dropColumn(['user_code', 'role_id', 'last_login', 'is_active']);
        });
    }
};
