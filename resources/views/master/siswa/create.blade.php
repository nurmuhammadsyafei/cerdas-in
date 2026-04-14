@extends('layouts.app')

@section('title', 'Tambah Siswa')
@section('page-title', 'Tambah Siswa')

@section('content')
<div class="container-fluid">

    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="bi bi-house-door"></i></a></li>
            <li class="breadcrumb-item"><a href="{{ route('master.siswa.index') }}">Data Siswa</a></li>
            <li class="breadcrumb-item active">Tambah</li>
        </ol>
    </nav>

    <form id="siswa-form"
          action="{{ route('api.master.siswa.store') }}"
          method="POST"
          enctype="multipart/form-data">
        @csrf
        @include('master.siswa._form', ['siswa' => null])
    </form>

</div>
@endsection
