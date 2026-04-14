@extends('layouts.app')

@section('title', 'Tambah Menu')
@section('page-title', 'Tambah Menu')

@section('content')
<div class="container-fluid">

    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="bi bi-house-door"></i></a></li>
            <li class="breadcrumb-item">Pengaturan</li>
            <li class="breadcrumb-item"><a href="{{ route('settings.menus.index') }}">Menu</a></li>
            <li class="breadcrumb-item active">Tambah</li>
        </ol>
    </nav>

    <form id="menu-form"
          action="{{ route('api.settings.menus.store') }}"
          method="POST">
        @csrf
        @include('settings.menu._form', ['menu' => null])
    </form>

</div>
@endsection
