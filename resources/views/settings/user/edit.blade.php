@extends('layouts.app')

@section('title', 'Edit Pengguna')
@section('page-title', 'Edit Pengguna')

@section('content')
<div class="container-fluid">

    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="bi bi-house-door"></i></a></li>
            <li class="breadcrumb-item">Pengaturan</li>
            <li class="breadcrumb-item"><a href="{{ route('settings.users.index') }}">Pengguna</a></li>
            <li class="breadcrumb-item active">Edit — {{ $user->name }}</li>
        </ol>
    </nav>

    <form id="siswa-form"
          action="{{ route('api.settings.users.update', $user) }}"
          method="POST">
        @csrf
        <input type="hidden" name="_method" value="PUT">
        @include('settings.user._form', ['user' => $user])
    </form>

</div>
@endsection
