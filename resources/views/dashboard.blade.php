@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container py-5">
    <h4 class="fw-bold">Dashboard</h4>
    <p class="text-muted">Selamat datang, {{ auth()->user()->name }}!</p>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="btn btn-sm btn-outline-danger">Keluar</button>
    </form>
</div>
@endsection
