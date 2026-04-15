@extends('layouts.app')

@section('title', 'Tambah Sekolah')
@section('page-title', 'Tambah Sekolah')

@section('content')
<div class="container-fluid">

    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="bi bi-house-door"></i></a></li>
            <li class="breadcrumb-item"><a href="{{ route('master.sekolah.index') }}">Data Sekolah</a></li>
            <li class="breadcrumb-item active">Tambah</li>
        </ol>
    </nav>

    <div id="toast-wrap" class="position-fixed top-0 end-0 p-3" style="z-index:1100"></div>

    <form id="sekolah-form"
          action="{{ route('api.master.sekolah.store') }}"
          method="POST"
          enctype="multipart/form-data">
        @csrf
        @include('master.sekolah._form')
    </form>

</div>
@endsection
