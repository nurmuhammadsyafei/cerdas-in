<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class MenusTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('menus')->delete();
        
        \DB::table('menus')->insert(array (
            0 => 
            array (
                'id' => 1,
                'parent_id' => NULL,
                'name' => 'master',
                'label' => 'Data Master',
                'icon' => 'bi bi-database',
                'route_name' => NULL,
                'sort_order' => 10,
                'is_active' => 1,
                'created_at' => '2026-04-15 00:58:35',
                'updated_at' => '2026-04-15 00:58:35',
            ),
            1 => 
            array (
                'id' => 2,
                'parent_id' => NULL,
                'name' => 'akademik',
                'label' => 'Akademik',
                'icon' => 'bi bi-journal-bookmark',
                'route_name' => NULL,
                'sort_order' => 20,
                'is_active' => 1,
                'created_at' => '2026-04-15 00:58:35',
                'updated_at' => '2026-04-15 00:58:35',
            ),
            2 => 
            array (
                'id' => 3,
                'parent_id' => NULL,
                'name' => 'absensi',
                'label' => 'Absensi',
                'icon' => 'bi bi-calendar-check',
                'route_name' => NULL,
                'sort_order' => 30,
                'is_active' => 1,
                'created_at' => '2026-04-15 00:58:35',
                'updated_at' => '2026-04-15 00:58:35',
            ),
            3 => 
            array (
                'id' => 4,
                'parent_id' => NULL,
                'name' => 'laporan',
                'label' => 'Laporan',
                'icon' => 'bi bi-bar-chart-line',
                'route_name' => NULL,
                'sort_order' => 40,
                'is_active' => 1,
                'created_at' => '2026-04-15 00:58:35',
                'updated_at' => '2026-04-15 00:58:35',
            ),
            4 => 
            array (
                'id' => 5,
                'parent_id' => NULL,
                'name' => 'settings',
                'label' => 'Pengaturan',
                'icon' => 'bi bi-gear',
                'route_name' => NULL,
                'sort_order' => 50,
                'is_active' => 1,
                'created_at' => '2026-04-15 00:58:35',
                'updated_at' => '2026-04-15 00:58:35',
            ),
            5 => 
            array (
                'id' => 6,
                'parent_id' => 1,
                'name' => 'master.siswa',
                'label' => 'Siswa',
                'icon' => 'bi bi-people',
                'route_name' => 'master.siswa.index',
                'sort_order' => 1,
                'is_active' => 1,
                'created_at' => '2026-04-15 00:58:35',
                'updated_at' => '2026-04-15 00:58:35',
            ),
            6 => 
            array (
                'id' => 7,
                'parent_id' => 1,
                'name' => 'master.guru',
                'label' => 'Guru',
                'icon' => 'bi bi-person-badge',
                'route_name' => 'master.guru.index',
                'sort_order' => 2,
                'is_active' => 1,
                'created_at' => '2026-04-15 00:58:35',
                'updated_at' => '2026-04-15 02:01:26',
            ),
            7 => 
            array (
                'id' => 8,
                'parent_id' => 1,
                'name' => 'master.kelas',
                'label' => 'Kelas',
                'icon' => 'bi bi-building',
                'route_name' => NULL,
                'sort_order' => 4,
                'is_active' => 1,
                'created_at' => '2026-04-15 00:58:35',
                'updated_at' => '2026-04-15 02:01:26',
            ),
            8 => 
            array (
                'id' => 9,
                'parent_id' => 2,
                'name' => 'akademik.mapel',
                'label' => 'Mata Pelajaran',
                'icon' => 'bi bi-book',
                'route_name' => NULL,
                'sort_order' => 1,
                'is_active' => 1,
                'created_at' => '2026-04-15 00:58:35',
                'updated_at' => '2026-04-15 00:58:35',
            ),
            9 => 
            array (
                'id' => 10,
                'parent_id' => 2,
                'name' => 'akademik.jadwal',
                'label' => 'Jadwal',
                'icon' => 'bi bi-calendar3',
                'route_name' => NULL,
                'sort_order' => 2,
                'is_active' => 1,
                'created_at' => '2026-04-15 00:58:35',
                'updated_at' => '2026-04-15 00:58:35',
            ),
            10 => 
            array (
                'id' => 11,
                'parent_id' => 2,
                'name' => 'akademik.nilai',
                'label' => 'Nilai',
                'icon' => 'bi bi-card-checklist',
                'route_name' => NULL,
                'sort_order' => 3,
                'is_active' => 1,
                'created_at' => '2026-04-15 00:58:35',
                'updated_at' => '2026-04-15 00:58:35',
            ),
            11 => 
            array (
                'id' => 12,
                'parent_id' => 3,
                'name' => 'absensi.rekap',
                'label' => 'Rekap Harian',
                'icon' => 'bi bi-clipboard-check',
                'route_name' => NULL,
                'sort_order' => 1,
                'is_active' => 1,
                'created_at' => '2026-04-15 00:58:35',
                'updated_at' => '2026-04-15 00:58:35',
            ),
            12 => 
            array (
                'id' => 13,
                'parent_id' => 3,
                'name' => 'absensi.laporan',
                'label' => 'Laporan',
                'icon' => 'bi bi-file-earmark-text',
                'route_name' => NULL,
                'sort_order' => 2,
                'is_active' => 1,
                'created_at' => '2026-04-15 00:58:35',
                'updated_at' => '2026-04-15 00:58:35',
            ),
            13 => 
            array (
                'id' => 14,
                'parent_id' => 4,
                'name' => 'laporan.nilai',
                'label' => 'Laporan Nilai',
                'icon' => 'bi bi-file-earmark-bar-graph',
                'route_name' => NULL,
                'sort_order' => 1,
                'is_active' => 1,
                'created_at' => '2026-04-15 00:58:35',
                'updated_at' => '2026-04-15 00:58:35',
            ),
            14 => 
            array (
                'id' => 15,
                'parent_id' => 4,
                'name' => 'laporan.absensi',
                'label' => 'Laporan Absensi',
                'icon' => 'bi bi-file-earmark-check',
                'route_name' => NULL,
                'sort_order' => 2,
                'is_active' => 1,
                'created_at' => '2026-04-15 00:58:35',
                'updated_at' => '2026-04-15 00:58:35',
            ),
            15 => 
            array (
                'id' => 16,
                'parent_id' => 5,
                'name' => 'settings.users',
                'label' => 'Pengguna',
                'icon' => 'bi bi-person-gear',
                'route_name' => 'settings.users.index',
                'sort_order' => 1,
                'is_active' => 1,
                'created_at' => '2026-04-15 00:58:35',
                'updated_at' => '2026-04-15 00:58:35',
            ),
            16 => 
            array (
                'id' => 17,
                'parent_id' => 5,
                'name' => 'settings.menus',
                'label' => 'Menu',
                'icon' => 'bi bi-layout-sidebar',
                'route_name' => 'settings.menus.index',
                'sort_order' => 2,
                'is_active' => 1,
                'created_at' => '2026-04-15 00:58:35',
                'updated_at' => '2026-04-15 00:58:35',
            ),
            17 => 
            array (
                'id' => 18,
                'parent_id' => 5,
                'name' => 'settings.hak_akses',
                'label' => 'Hak Akses',
                'icon' => 'bi bi-shield-check',
                'route_name' => 'settings.hak_akses.index',
                'sort_order' => 3,
                'is_active' => 1,
                'created_at' => '2026-04-15 00:58:35',
                'updated_at' => '2026-04-15 00:58:35',
            ),
            18 => 
            array (
                'id' => 19,
                'parent_id' => 1,
                'name' => 'master.sekolah',
                'label' => 'Sekolah',
                'icon' => 'bi bi-building',
                'route_name' => 'master.sekolah.index',
                'sort_order' => 3,
                'is_active' => 1,
                'created_at' => '2026-04-15 01:48:06',
                'updated_at' => '2026-04-15 02:01:26',
            ),
        ));
        
        
    }
}