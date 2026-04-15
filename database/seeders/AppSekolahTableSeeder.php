<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AppSekolahTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('app_sekolah')->delete();
        
        \DB::table('app_sekolah')->insert(array (
            0 => 
            array (
                'id' => 1,
                'user_code' => '979528a3-8281-4017-80f2-d3390adf67c7',
                'logo' => 'sekolah/GNDMh0CHEBAwCvSHgEPXYY7q24iCoHP8PfEjcrHa.jpg',
                'nama_sekolah' => 'TK Yaspen Hindoli 01',
                'npsn' => '10646466',
                'alamat_sekolah' => 'Housing PT Hindoli',
                'nama_jalan' => 'Jalan PT Hindoli',
                'kode_pos' => '30755',
                'kecamatan' => 'Sungai Lilin',
                'kab_kota' => 'Musi Banyuasin',
                'provinsi' => 'Sumatera Selatan',
                'telepon' => '-',
                'website' => '-',
                'email' => 'tkyaspen01@gmail.com',
                'kepala_sekolah_id' => 11,
                'created_at' => '2026-04-15 01:51:46',
                'updated_at' => '2026-04-15 02:18:04',
            ),
            1 => 
            array (
                'id' => 2,
                'user_code' => '95fa066b-e0f6-4f4d-a2f1-60b6abf67788',
                'logo' => 'sekolah/6UL02VrMdd1V4I3Z5tuQ9P9hVZmw2BUxVHgkEbdt.jpg',
                'nama_sekolah' => 'SMK Dinamika Pembangunan 1 Jakarta',
                'npsn' => '92921092',
                'alamat_sekolah' => 'Jl Penggilingan Kp Pedaengan RT 06/08',
                'nama_jalan' => 'Jl Penggilingan',
                'kode_pos' => '13940',
                'kecamatan' => 'Cakung',
                'kab_kota' => 'Jakarta Timur',
                'provinsi' => 'DKI Jakarta',
                'telepon' => '-',
                'website' => '-',
                'email' => 'dp1@gmail.com',
                'kepala_sekolah_id' => 12,
                'created_at' => '2026-04-15 02:19:27',
                'updated_at' => '2026-04-15 02:21:56',
            ),
        ));
        
        
    }
}