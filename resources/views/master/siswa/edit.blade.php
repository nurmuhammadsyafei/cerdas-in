@extends('layouts.app')

@section('title', 'Edit Siswa')
@section('page-title', 'Edit Siswa')

@section('content')
<div class="container-fluid">

    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="bi bi-house-door"></i></a></li>
            <li class="breadcrumb-item"><a href="{{ route('master.siswa.index') }}">Data Siswa</a></li>
            <li class="breadcrumb-item active">Edit — {{ $siswa->nama_lengkap }}</li>
        </ol>
    </nav>

    <form id="siswa-form"
          action="{{ route('api.master.siswa.update', $siswa) }}"
          method="POST"
          enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="_method" value="PUT">
        @include('master.siswa._form', ['siswa' => $siswa])
    </form>

</div>
@endsection
