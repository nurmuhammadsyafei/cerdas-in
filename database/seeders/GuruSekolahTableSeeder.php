<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class GuruSekolahTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('guru_sekolah')->delete();
        
        \DB::table('guru_sekolah')->insert(array (
            0 => 
            array (
                'id' => 1,
                'user_id' => 11,
                'sekolah_id' => 1,
                'foto' => NULL,
                'created_at' => '2026-04-15 02:04:01',
                'updated_at' => '2026-04-15 02:04:01',
            ),
            1 => 
            array (
                'id' => 2,
                'user_id' => 5,
                'sekolah_id' => 1,
                'foto' => NULL,
                'created_at' => '2026-04-15 02:17:52',
                'updated_at' => '2026-04-15 02:17:52',
            ),
            2 => 
            array (
                'id' => 3,
                'user_id' => 4,
                'sekolah_id' => 2,
                'foto' => NULL,
                'created_at' => '2026-04-15 02:20:25',
                'updated_at' => '2026-04-15 02:20:25',
            ),
            3 => 
            array (
                'id' => 4,
                'user_id' => 6,
                'sekolah_id' => 2,
                'foto' => NULL,
                'created_at' => '2026-04-15 02:20:28',
                'updated_at' => '2026-04-15 02:20:28',
            ),
            4 => 
            array (
                'id' => 5,
                'user_id' => 12,
                'sekolah_id' => 2,
                'foto' => NULL,
                'created_at' => '2026-04-15 02:21:42',
                'updated_at' => '2026-04-15 02:21:42',
            ),
        ));
        
        
    }
}