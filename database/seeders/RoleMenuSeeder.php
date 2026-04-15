<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleMenuSeeder extends Seeder
{
    public function run(): void
    {
        $roles = Role::pluck('id', 'name');
        $menus = Menu::pluck('id', 'name');

        // Semua submenu yang ada
        $allSubmenus = Menu::whereNotNull('parent_id')->pluck('name')->toArray();

        // Hak akses per role
        $permissions = [

            // Superadmin & Admin → akses semua
            'superadmin' => $allSubmenus,
            'admin'      => $allSubmenus,

            // Kepala Sekolah → semua kecuali Pengaturan
            'kepala_sekolah' => array_values(array_filter($allSubmenus, fn ($m) => !str_starts_with($m, 'settings.'))),

            // Guru → Master (lihat), Akademik, Absensi, Laporan
            'guru' => [
                'master.siswa', 'master.kelas',
                'akademik.mapel', 'akademik.jadwal', 'akademik.nilai',
                'absensi.rekap', 'absensi.laporan',
                'laporan.nilai', 'laporan.absensi',
            ],

            // Staff TU → Master, Laporan
            'staff_tu' => [
                'master.siswa', 'master.guru', 'master.sekolah', 'master.kelas',
                'laporan.nilai', 'laporan.absensi',
            ],

            // Operator → Master Siswa & Absensi saja
            'operator' => [
                'master.siswa',
                'absensi.rekap',
            ],
        ];

        foreach ($permissions as $roleName => $menuNames) {
            $roleId = $roles[$roleName] ?? null;
            if (!$roleId) continue;

            $role = Role::find($roleId);

            $menuIds = collect($menuNames)
                ->filter(fn ($n) => isset($menus[$n]))
                ->map(fn ($n) => $menus[$n])
                ->values()
                ->toArray();

            $role->menus()->syncWithoutDetaching($menuIds);
        }
    }
}
