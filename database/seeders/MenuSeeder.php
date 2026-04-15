<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        // ── Parent menus (parent_id = null) ─────────────────────────────
        $parents = [
            ['name' => 'master',     'label' => 'Data Master',  'icon' => 'bi bi-database',          'route_name' => null, 'sort_order' => 10],
            ['name' => 'akademik',   'label' => 'Akademik',     'icon' => 'bi bi-journal-bookmark',   'route_name' => null, 'sort_order' => 20],
            ['name' => 'absensi',    'label' => 'Absensi',      'icon' => 'bi bi-calendar-check',     'route_name' => null, 'sort_order' => 30],
            ['name' => 'laporan',    'label' => 'Laporan',      'icon' => 'bi bi-bar-chart-line',     'route_name' => null, 'sort_order' => 40],
            ['name' => 'settings',   'label' => 'Pengaturan',   'icon' => 'bi bi-gear',               'route_name' => null, 'sort_order' => 50],
        ];

        foreach ($parents as $p) {
            Menu::firstOrCreate(['name' => $p['name']], array_merge($p, ['parent_id' => null]));
        }

        // ── Child menus (submenu) ────────────────────────────────────────
        $children = [
            // Data Master
            ['parent' => 'master',   'name' => 'master.siswa',           'label' => 'Siswa',           'icon' => 'bi bi-people',              'route_name' => 'master.siswa.index',       'sort_order' => 1],
            ['parent' => 'master',   'name' => 'master.guru',            'label' => 'Guru',            'icon' => 'bi bi-person-badge',        'route_name' => 'master.guru.index',        'sort_order' => 2],
            ['parent' => 'master',   'name' => 'master.sekolah',         'label' => 'Sekolah',         'icon' => 'bi bi-building',            'route_name' => 'master.sekolah.index',     'sort_order' => 3],
            ['parent' => 'master',   'name' => 'master.kelas',           'label' => 'Kelas',           'icon' => 'bi bi-grid',                'route_name' => null,                       'sort_order' => 4],
            // Akademik
            ['parent' => 'akademik', 'name' => 'akademik.mapel',         'label' => 'Mata Pelajaran',  'icon' => 'bi bi-book',                'route_name' => null,                       'sort_order' => 1],
            ['parent' => 'akademik', 'name' => 'akademik.jadwal',        'label' => 'Jadwal',          'icon' => 'bi bi-calendar3',           'route_name' => null,                       'sort_order' => 2],
            ['parent' => 'akademik', 'name' => 'akademik.nilai',         'label' => 'Nilai',           'icon' => 'bi bi-card-checklist',      'route_name' => null,                       'sort_order' => 3],
            // Absensi
            ['parent' => 'absensi',  'name' => 'absensi.rekap',          'label' => 'Rekap Harian',    'icon' => 'bi bi-clipboard-check',     'route_name' => null,                       'sort_order' => 1],
            ['parent' => 'absensi',  'name' => 'absensi.laporan',        'label' => 'Laporan',         'icon' => 'bi bi-file-earmark-text',   'route_name' => null,                       'sort_order' => 2],
            // Laporan
            ['parent' => 'laporan',  'name' => 'laporan.nilai',          'label' => 'Laporan Nilai',   'icon' => 'bi bi-file-earmark-bar-graph', 'route_name' => null,                    'sort_order' => 1],
            ['parent' => 'laporan',  'name' => 'laporan.absensi',        'label' => 'Laporan Absensi', 'icon' => 'bi bi-file-earmark-check', 'route_name' => null,                        'sort_order' => 2],
            // Pengaturan
            ['parent' => 'settings', 'name' => 'settings.users',         'label' => 'Pengguna',        'icon' => 'bi bi-person-gear',         'route_name' => 'settings.users.index',     'sort_order' => 1],
            ['parent' => 'settings', 'name' => 'settings.menus',         'label' => 'Menu',            'icon' => 'bi bi-layout-sidebar',      'route_name' => 'settings.menus.index',     'sort_order' => 2],
            ['parent' => 'settings', 'name' => 'settings.hak_akses',     'label' => 'Hak Akses',       'icon' => 'bi bi-shield-check',        'route_name' => 'settings.hak_akses.index', 'sort_order' => 3],
        ];

        $parentIds = Menu::whereNull('parent_id')->pluck('id', 'name');

        foreach ($children as $c) {
            Menu::updateOrCreate(
                ['name' => $c['name']],
                [
                    'parent_id'  => $parentIds[$c['parent']] ?? null,
                    'label'      => $c['label'],
                    'icon'       => $c['icon'],
                    'route_name' => $c['route_name'],
                    'sort_order' => $c['sort_order'],
                    'is_active'  => true,
                ]
            );
        }
    }
}
