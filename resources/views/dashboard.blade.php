@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<div class="container-fluid">

    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><i class="bi bi-house-door"></i></li>
            <li class="breadcrumb-item active">Home</li>
        </ol>
    </nav>

    <h5 class="fw-bold mb-4">Selamat Datang, {{ auth()->user()->name }}!</h5>

    {{-- Stats cards --}}
    <div class="row g-3 mb-4">
        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="rounded-3 p-3 bg-primary bg-opacity-10 text-primary fs-3">
                        <i class="bi bi-people"></i>
                    </div>
                    <div>
                        <div class="text-muted small">Total Siswa</div>
                        <div class="fw-bold fs-5">0</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="rounded-3 p-3 bg-success bg-opacity-10 text-success fs-3">
                        <i class="bi bi-person-badge"></i>
                    </div>
                    <div>
                        <div class="text-muted small">Total Guru</div>
                        <div class="fw-bold fs-5">0</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="rounded-3 p-3 bg-warning bg-opacity-10 text-warning fs-3">
                        <i class="bi bi-journal-text"></i>
                    </div>
                    <div>
                        <div class="text-muted small">Mata Pelajaran</div>
                        <div class="fw-bold fs-5">0</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="rounded-3 p-3 bg-info bg-opacity-10 text-info fs-3">
                        <i class="bi bi-calendar2-check"></i>
                    </div>
                    <div>
                        <div class="text-muted small">Kehadiran Hari Ini</div>
                        <div class="fw-bold fs-5">0</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
