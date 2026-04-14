<div id="topbar">
    <button class="topbar-toggle" id="sidebarToggle">
        <i class="bi bi-list"></i>
    </button>
    <span class="topbar-title">@yield('page-title', config('app.name', 'Cerdas-In'))</span>
    <div class="ms-auto d-flex align-items-center gap-3">
        <span class="text-muted small">{{ auth()->user()->name }}</span>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-sm btn-outline-danger">
                <i class="bi bi-box-arrow-right"></i> Keluar
            </button>
        </form>
    </div>
</div>
