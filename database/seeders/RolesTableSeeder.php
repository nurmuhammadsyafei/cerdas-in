<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('roles')->delete();
        
        \DB::table('roles')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'superadmin',
                'label' => 'Super Admin',
                'created_at' => '2026-04-15 00:58:31',
                'updated_at' => '2026-04-15 00:58:31',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'admin',
                'label' => 'Administrator',
                'created_at' => '2026-04-15 00:58:31',
                'updated_at' => '2026-04-15 00:58:31',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'kepala_sekolah',
                'label' => 'Kepala Sekolah',
                'created_at' => '2026-04-15 00:58:31',
                'updated_at' => '2026-04-15 00:58:31',
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'guru',
                'label' => 'Guru',
                'created_at' => '2026-04-15 00:58:31',
                'updated_at' => '2026-04-15 00:58:31',
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'staff_tu',
                'label' => 'Staff TU',
                'created_at' => '2026-04-15 00:58:31',
                'updated_at' => '2026-04-15 00:58:31',
            ),
            5 => 
            array (
                'id' => 6,
                'name' => 'operator',
                'label' => 'Operator',
                'created_at' => '2026-04-15 00:58:31',
                'updated_at' => '2026-04-15 00:58:31',
            ),
        ));
        
        
    }
}