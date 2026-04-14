@extends('layouts.app')

@section('title', 'Edit Menu')
@section('page-title', 'Edit Menu')

@section('content')
<div class="container-fluid">

    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="bi bi-house-door"></i></a></li>
            <li class="breadcrumb-item">Pengaturan</li>
            <li class="breadcrumb-item"><a href="{{ route('settings.menus.index') }}">Menu</a></li>
            <li class="breadcrumb-item active">Edit — {{ $menu->label }}</li>
        </ol>
    </nav>

    <form id="menu-form"
          action="{{ route('api.settings.menus.update', $menu) }}"
          method="POST">
        @csrf
        <input type="hidden" name="_method" value="PUT">
        @include('settings.menu._form', ['menu' => $menu])
    </form>

</div>
@endsection
