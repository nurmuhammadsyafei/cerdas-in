<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $roles = Role::pluck('id', 'name');

        $users = [
            [
                'name'      => 'Super Admin',
                'email'     => 'superadmin@cerdas-in.id',
                'password'  => Hash::make('password'),
                'role_id'   => $roles['superadmin'] ?? null,
                'is_active' => true,
            ],
            [
                'name'      => 'Ahmad Administrator',
                'email'     => 'admin@cerdas-in.id',
                'password'  => Hash::make('password'),
                'role_id'   => $roles['admin'] ?? null,
                'is_active' => true,
            ],
            [
                'name'      => 'Drs. Bambang Kusuma, M.Pd',
                'email'     => 'kepsek@cerdas-in.id',
                'password'  => Hash::make('password'),
                'role_id'   => $roles['kepala_sekolah'] ?? null,
                'is_active' => true,
            ],
            [
                'name'      => 'Ibu Sri Wahyuni, S.Pd',
                'email'     => 'guru1@cerdas-in.id',
                'password'  => Hash::make('password'),
                'role_id'   => $roles['guru'] ?? null,
                'is_active' => true,
            ],
            [
                'name'      => 'Bapak Hendra Saputra, S.Pd',
                'email'     => 'guru2@cerdas-in.id',
                'password'  => Hash::make('password'),
                'role_id'   => $roles['guru'] ?? null,
                'is_active' => true,
            ],
            [
                'name'      => 'Ibu Rina Marlina, S.Pd',
                'email'     => 'guru3@cerdas-in.id',
                'password'  => Hash::make('password'),
                'role_id'   => $roles['guru'] ?? null,
                'is_active' => true,
            ],
            [
                'name'      => 'Dedi Setiawan, A.Md',
                'email'     => 'stafftu1@cerdas-in.id',
                'password'  => Hash::make('password'),
                'role_id'   => $roles['staff_tu'] ?? null,
                'is_active' => true,
            ],
            [
                'name'      => 'Nurul Hidayati',
                'email'     => 'stafftu2@cerdas-in.id',
                'password'  => Hash::make('password'),
                'role_id'   => $roles['staff_tu'] ?? null,
                'is_active' => true,
            ],
            [
                'name'      => 'Fajar Operator',
                'email'     => 'operator@cerdas-in.id',
                'password'  => Hash::make('password'),
                'role_id'   => $roles['operator'] ?? null,
                'is_active' => true,
            ],
            [
                'name'      => 'Siti Nonaktif',
                'email'     => 'nonaktif@cerdas-in.id',
                'password'  => Hash::make('password'),
                'role_id'   => $roles['operator'] ?? null,
                'is_active' => false,
            ],
        ];

        foreach ($users as $data) {
            User::firstOrCreate(
                ['email' => $data['email']],
                array_merge($data, ['user_code' => Str::uuid()->toString()])
            );
        }
    }
}
