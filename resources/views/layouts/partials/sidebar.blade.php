<div id="sidebar">
    <div class="sidebar-brand">
        <i class="bi bi-mortarboard-fill me-2"></i>{{ config('app.name', 'Cerdas-In') }}
    </div>

    <nav class="sidebar-nav">

        {{-- Home --}}
        <a href="{{ route('dashboard') }}" class="nav-item-label {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="bi bi-house-door"></i> Home
        </a>

        {{-- Dynamic menus from DB --}}
        @foreach ($sidebarMenus as $parent)
            @php
                $collapseId   = 'menu-' . preg_replace('/[^a-z0-9]+/', '-', strtolower($parent->name));
                $isParentOpen = $parent->visibleChildren->contains(fn ($c) =>
                    $c->route_name && request()->routeIs($c->route_name . '*')
                );
            @endphp

            <div class="nav-item-label"
                 data-bs-toggle="collapse"
                 data-bs-target="#{{ $collapseId }}"
                 aria-expanded="{{ $isParentOpen ? 'true' : 'false' }}">
                <i class="{{ $parent->icon ?? 'bi bi-circle' }}"></i> {{ $parent->label }}
                <i class="bi bi-chevron-down chevron"></i>
            </div>

            <div class="collapse sidebar-submenu {{ $isParentOpen ? 'show' : '' }}" id="{{ $collapseId }}">
                @foreach ($parent->visibleChildren as $child)
                    @php
                        $isActive = $child->route_name && request()->routeIs($child->route_name . '*');
                        $url      = ($child->route_name && \Route::has($child->route_name))
                                        ? route($child->route_name)
                                        : '#';
                    @endphp
                    <a href="{{ $url }}" class="nav-item-label {{ $isActive ? 'active' : '' }}">
                        <i class="{{ $child->icon ?? 'bi bi-dot' }}"></i> {{ $child->label }}
                    </a>
                @endforeach
            </div>
        @endforeach

    </nav>
</div>
