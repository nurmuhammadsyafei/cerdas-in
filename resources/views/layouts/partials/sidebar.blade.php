<div id="sidebar">
    <div class="sidebar-brand">
        <i class="bi bi-mortarboard-fill me-2"></i>{{ config('app.name', 'Cerdas-In') }}
    </div>

    <nav class="sidebar-nav">

        {{-- Home --}}
        <a href="{{ route('dashboard') }}" class="nav-item-label {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="bi bi-house-door"></i> Home
        </a>

        {{-- Data Master --}}
        <div class="nav-item-label" data-bs-toggle="collapse" data-bs-target="#menu-master" aria-expanded="false">
            <i class="bi bi-database"></i> Data Master
            <i class="bi bi-chevron-down chevron"></i>
        </div>
        <div class="collapse sidebar-submenu {{ request()->routeIs('master.siswa.*') ? 'show' : '' }}" id="menu-master">
            <a href="{{ route('master.siswa.index') }}"
                class="nav-item-label {{ request()->routeIs('master.siswa.*') ? 'active' : '' }}">
                <i class="bi bi-dot"></i> Siswa
            </a>
            <a href="#" class="nav-item-label"><i class="bi bi-dot"></i> Guru</a>
            <a href="#" class="nav-item-label"><i class="bi bi-dot"></i> Kelas</a>
        </div>

        {{-- Akademik --}}
        <div class="nav-item-label" data-bs-toggle="collapse" data-bs-target="#menu-akademik" aria-expanded="false">
            <i class="bi bi-journal-bookmark"></i> Akademik
            <i class="bi bi-chevron-down chevron"></i>
        </div>
        <div class="collapse sidebar-submenu" id="menu-akademik">
            <a href="#" class="nav-item-label"><i class="bi bi-dot"></i> Mata Pelajaran</a>
            <a href="#" class="nav-item-label"><i class="bi bi-dot"></i> Jadwal</a>
            <a href="#" class="nav-item-label"><i class="bi bi-dot"></i> Nilai</a>
        </div>

        {{-- Absensi --}}
        <div class="nav-item-label" data-bs-toggle="collapse" data-bs-target="#menu-absensi" aria-expanded="false">
            <i class="bi bi-calendar-check"></i> Absensi
            <i class="bi bi-chevron-down chevron"></i>
        </div>
        <div class="collapse sidebar-submenu" id="menu-absensi">
            <a href="#" class="nav-item-label"><i class="bi bi-dot"></i> Rekap Harian</a>
            <a href="#" class="nav-item-label"><i class="bi bi-dot"></i> Laporan</a>
        </div>

        {{-- Laporan --}}
        <div class="nav-item-label" data-bs-toggle="collapse" data-bs-target="#menu-laporan" aria-expanded="false">
            <i class="bi bi-bar-chart-line"></i> Laporan
            <i class="bi bi-chevron-down chevron"></i>
        </div>
        <div class="collapse sidebar-submenu" id="menu-laporan">
            <a href="#" class="nav-item-label"><i class="bi bi-dot"></i> Laporan Nilai</a>
            <a href="#" class="nav-item-label"><i class="bi bi-dot"></i> Laporan Absensi</a>
        </div>

        {{-- Pengaturan --}}
        <div class="nav-item-label" data-bs-toggle="collapse" data-bs-target="#menu-settings" aria-expanded="false">
            <i class="bi bi-gear"></i> Pengaturan
            <i class="bi bi-chevron-down chevron"></i>
        </div>
        <div class="collapse sidebar-submenu" id="menu-settings">
            <a href="#" class="nav-item-label"><i class="bi bi-dot"></i> Pengguna</a>
            <a href="#" class="nav-item-label"><i class="bi bi-dot"></i> Hak Akses</a>
        </div>

    </nav>
</div>
