<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Cerdas-In') }} — @yield('title')</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        :root {
            --sidebar-bg: #1a237e;
            --sidebar-hover: #283593;
            --sidebar-active: #ffc107;
            --sidebar-width: 240px;
        }

        body {
            min-height: 100vh;
            background: #f4f6f9;
        }

        /* Sidebar */
        #sidebar {
            width: var(--sidebar-width);
            min-height: 100vh;
            background: var(--sidebar-bg);
            position: fixed;
            top: 0; left: 0;
            display: flex;
            flex-direction: column;
            z-index: 1000;
            transition: transform 0.3s ease;
        }

        #sidebar.collapsed {
            transform: translateX(-100%);
        }

        .sidebar-brand {
            padding: 1.25rem 1rem;
            color: #fff;
            font-size: 1.3rem;
            font-weight: 800;
            letter-spacing: 2px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .sidebar-nav {
            flex: 1;
            overflow-y: auto;
            padding: 0.5rem 0;
        }

        .sidebar-nav::-webkit-scrollbar { width: 4px; }
        .sidebar-nav::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.2); border-radius: 4px; }

        /* Nav item */
        .nav-item-label {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            padding: 0.65rem 1rem;
            color: rgba(255,255,255,0.85);
            cursor: pointer;
            font-size: 0.875rem;
            font-weight: 500;
            border-radius: 6px;
            margin: 1px 6px;
            text-decoration: none;
            transition: background 0.15s;
        }

        .nav-item-label:hover {
            background: var(--sidebar-hover);
            color: #fff;
        }

        .nav-item-label.active {
            background: var(--sidebar-active);
            color: #1a237e;
            font-weight: 700;
        }

        .nav-item-label .chevron {
            margin-left: auto;
            transition: transform 0.2s;
            font-size: 0.75rem;
        }

        .nav-item-label[aria-expanded="true"] .chevron {
            transform: rotate(180deg);
        }

        /* Sub-menu */
        .sidebar-submenu {
            padding-left: 2.4rem;
        }

        .sidebar-submenu .nav-item-label {
            font-size: 0.82rem;
            font-weight: 400;
            padding: 0.5rem 0.75rem;
        }

        /* Topbar */
        #topbar {
            margin-left: var(--sidebar-width);
            height: 56px;
            background: #fff;
            box-shadow: 0 1px 4px rgba(0,0,0,0.08);
            display: flex;
            align-items: center;
            padding: 0 1.25rem;
            gap: 1rem;
            position: sticky;
            top: 0;
            z-index: 999;
            transition: margin-left 0.3s ease;
        }

        #topbar.expanded {
            margin-left: 0;
        }

        .topbar-title {
            font-weight: 600;
            font-size: 1rem;
            color: #1a237e;
        }

        .topbar-toggle {
            background: none;border: none; cursor: pointer; color: #1a237e; font-size: 1.25rem; padding: 0;
        }

        /* Main content */
        #main-content {
            margin-left: var(--sidebar-width);
            padding: 1.5rem;
            transition: margin-left 0.3s ease;
        }

        #main-content.expanded {
            margin-left: 0;
        }

        @media (max-width: 768px) {
            #sidebar { transform: translateX(-100%); }
            #sidebar.show { transform: translateX(0); }
            #topbar, #main-content { margin-left: 0 !important; }
        }
    </style>
</head>
<body>

@auth
{{-- ===== SIDEBAR ===== --}}
@include('layouts.partials.sidebar')

{{-- ===== TOPBAR ===== --}}
@include('layouts.partials.topbar')
@endauth

{{-- ===== MAIN CONTENT ===== --}}
<div id="main-content" @guest class="p-0" @endguest>
    @yield('content')
</div>

<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
<script>
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebar = document.getElementById('sidebar');
    const topbar = document.getElementById('topbar');
    const mainContent = document.getElementById('main-content');

    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', () => {
            if (window.innerWidth <= 768) {
                sidebar.classList.toggle('show');
            } else {
                sidebar.classList.toggle('collapsed');
                topbar.classList.toggle('expanded');
                mainContent.classList.toggle('expanded');
            }
        });
    }
</script>
@stack('scripts')
</body>
</html>
