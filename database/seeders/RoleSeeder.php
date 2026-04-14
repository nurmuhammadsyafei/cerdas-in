<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            ['name' => 'superadmin',  'label' => 'Super Admin'],
            ['name' => 'admin',       'label' => 'Administrator'],
            ['name' => 'kepala_sekolah', 'label' => 'Kepala Sekolah'],
            ['name' => 'guru',        'label' => 'Guru'],
            ['name' => 'staff_tu',    'label' => 'Staff TU'],
            ['name' => 'operator',    'label' => 'Operator'],
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role['name']], $role);
        }
    }
}
