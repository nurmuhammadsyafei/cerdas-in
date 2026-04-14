@extends('layouts.app')

@section('title', 'Tambah Pengguna')
@section('page-title', 'Tambah Pengguna')

@section('content')
<div class="container-fluid">

    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="bi bi-house-door"></i></a></li>
            <li class="breadcrumb-item">Pengaturan</li>
            <li class="breadcrumb-item"><a href="{{ route('settings.users.index') }}">Pengguna</a></li>
            <li class="breadcrumb-item active">Tambah</li>
        </ol>
    </nav>

    <form id="siswa-form"
          action="{{ route('api.settings.users.store') }}"
          method="POST">
        @csrf
        @include('settings.user._form', ['user' => null])
    </form>

</div>
@endsection
