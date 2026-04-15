@extends('layouts.app')

@section('title', 'Data Guru')
@section('page-title', 'Data Guru')

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css">
@endpush

@section('content')
<div class="container-fluid">

    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="bi bi-house-door"></i></a></li>
            <li class="breadcrumb-item">Data Master</li>
            <li class="breadcrumb-item active">Guru</li>
        </ol>
    </nav>

    <div id="toast-wrap" class="position-fixed top-0 end-0 p-3" style="z-index:1100"></div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="mb-0 fw-bold"><i class="bi bi-person-workspace me-2"></i>Daftar Guru</h6>
                <span class="badge bg-secondary">Data diambil dari pengguna ber-role Guru</span>
            </div>

            <div class="table-responsive">
                <table id="tbl-guru" class="table table-hover align-middle w-100">
                    <thead class="table-light">
                        <tr>
                            <th width="50">No</th>
                            <th width="70">Foto</th>
                            <th width="70" class="text-center">Aksi</th>
                            <th>Nama Guru</th>
                            <th>Email</th>
                            <th>Penempatan Sekolah</th>
                            <th width="80" class="text-center">Status</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>
<script>
const API_URL   = '{{ url("api/master/guru") }}';
const EDIT_BASE = '{{ url("master/guru") }}';

const esc = (v) => String(v ?? '').replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;');

const table = $('#tbl-guru').DataTable({
    ajax: { url: API_URL + '?all=1', dataSrc: 'data' },
    columns: [
        { data: null, orderable: false, searchable: false,
          render: (d, t, r, meta) => meta.row + 1 },
        {
            data: 'foto_url', orderable: false, searchable: false,
            render: (src) => src
                ? `<img src="${src}" class="rounded border" style="width:44px;height:54px;object-fit:cover;">`
                : `<div class="rounded border bg-light d-flex align-items-center justify-content-center" style="width:44px;height:54px;"><i class="bi bi-person text-secondary fs-5"></i></div>`
        },
        {
            data: 'user_code', orderable: false, searchable: false,
            render: (code) => `
                <div class="d-flex justify-content-center">
                    <a href="${EDIT_BASE}/${code}/edit" class="btn btn-sm btn-warning" title="Edit Penempatan & Foto">
                        <i class="bi bi-pencil"></i>
                    </a>
                </div>`
        },
        {
            data: 'name',
            render: (val, t, row) => {
                let html = `<div class="fw-semibold">${esc(val)}</div>`;
                return html;
            }
        },
        { data: 'email', render: (v) => `<span class="small">${esc(v)}</span>` },
        {
            data: 'nama_sekolah',
            defaultContent: '-',
            render: (val) => val
                ? `<span class="badge bg-primary bg-opacity-10 text-primary">${esc(val)}</span>`
                : `<span class="text-muted small">Belum ditempatkan</span>`
        },
        {
            data: 'is_active',
            render: (v) => v
                ? `<span class="badge bg-success bg-opacity-10 text-success">Aktif</span>`
                : `<span class="badge bg-secondary bg-opacity-10 text-secondary">Nonaktif</span>`
        },
    ],
    language: { url: '//cdn.datatables.net/plug-ins/1.13.8/i18n/id.json' },
    pageLength: 15,
    order: [[3, 'asc']],
    dom: "<'row mb-2'<'col-sm-6'l><'col-sm-6'f>>" +
         "<'row'<'col-12'tr>>" +
         "<'row mt-2'<'col-sm-5'i><'col-sm-7'p>>"
});
</script>
@endpush
