@extends('layouts.app')

@section('title', 'Data Sekolah')
@section('page-title', 'Data Sekolah')

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css">
@endpush

@section('content')
<div class="container-fluid">

    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="bi bi-house-door"></i></a></li>
            <li class="breadcrumb-item">Data Master</li>
            <li class="breadcrumb-item active">Sekolah</li>
        </ol>
    </nav>

    <div id="toast-wrap" class="position-fixed top-0 end-0 p-3" style="z-index:1100"></div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="mb-0 fw-bold"><i class="bi bi-building me-2"></i>Daftar Sekolah</h6>
                <a href="{{ route('master.sekolah.create') }}" class="btn btn-primary btn-sm">
                    <i class="bi bi-plus-lg me-1"></i>Tambah Sekolah
                </a>
            </div>

            <div class="table-responsive">
                <table id="tbl-sekolah" class="table table-hover align-middle w-100">
                    <thead class="table-light">
                        <tr>
                            <th width="50">No</th>
                            <th width="70">Logo</th>
                            <th width="90" class="text-center">Aksi</th>
                            <th>Nama Sekolah</th>
                            <th>NPSN</th>
                            <th>Kecamatan</th>
                            <th>Kab / Kota</th>
                            <th>Telepon</th>
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
const API_URL   = '{{ url("api/master/sekolah") }}';
const EDIT_BASE = '{{ url("master/sekolah") }}';
const CSRF      = document.querySelector('meta[name="csrf-token"]').content;

const esc      = (v) => String(v ?? '').replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;');
const escAttr  = (v) => String(v ?? '').replace(/"/g,'&quot;').replace(/'/g,'&#39;');

const table = $('#tbl-sekolah').DataTable({
    ajax: { url: API_URL + '?all=1', dataSrc: 'data' },
    columns: [
        { data: null, orderable: false, searchable: false,
          render: (d, t, r, meta) => meta.row + 1 },
        {
            data: 'logo_url', orderable: false, searchable: false,
            render: (src) => src
                ? `<img src="${src}" class="rounded border" style="width:44px;height:44px;object-fit:cover;">`
                : `<div class="rounded border bg-light d-flex align-items-center justify-content-center" style="width:44px;height:44px;"><i class="bi bi-building text-secondary"></i></div>`
        },
        {
            data: 'user_code', orderable: false, searchable: false,
            render: (code, t, row) => `
                <div class="d-flex gap-1 justify-content-center">
                    <a href="${EDIT_BASE}/${code}/edit" class="btn btn-sm btn-warning" title="Edit">
                        <i class="bi bi-pencil"></i>
                    </a>
                    <button class="btn btn-sm btn-danger" title="Hapus"
                        onclick="deleteSekolah('${code}', '${escAttr(row.nama_sekolah)}')">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>`
        },
        {
            data: 'nama_sekolah',
            render: (val, t, row) => {
                let html = `<div class="fw-semibold">${esc(val)}</div>`;
                if (row.email) html += `<small class="text-muted">${esc(row.email)}</small>`;
                return html;
            }
        },
        { data: 'npsn', defaultContent: '-' },
        { data: 'kecamatan', defaultContent: '-' },
        { data: 'kab_kota', defaultContent: '-' },
        { data: 'telepon', defaultContent: '-', render: (v) => `<span class="small">${v || '-'}</span>` },
    ],
    language: { url: '//cdn.datatables.net/plug-ins/1.13.8/i18n/id.json' },
    pageLength: 15,
    order: [[3, 'asc']],
    dom: "<'row mb-2'<'col-sm-6'l><'col-sm-6'f>>" +
         "<'row'<'col-12'tr>>" +
         "<'row mt-2'<'col-sm-5'i><'col-sm-7'p>>"
});

function deleteSekolah(code, nama) {
    if (!confirm(`Hapus data sekolah "${nama}"?\nSemua data penempatan guru terkait akan ikut terhapus.`)) return;

    fetch(`${API_URL}/${code}`, {
        method: 'DELETE',
        headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF }
    })
    .then(r => r.json())
    .then(res => {
        if (res.success) {
            showToast(res.message, 'success');
            table.ajax.reload(null, false);
        } else {
            showToast('Gagal menghapus data.', 'danger');
        }
    })
    .catch(() => showToast('Terjadi kesalahan koneksi.', 'danger'));
}

function showToast(msg, type = 'success') {
    const id   = 'toast-' + Date.now();
    const html = `<div id="${id}" class="toast align-items-center text-bg-${type} border-0 mb-2" role="alert">
        <div class="d-flex"><div class="toast-body">${msg}</div>
        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button></div>
    </div>`;
    document.getElementById('toast-wrap').insertAdjacentHTML('beforeend', html);
    const el = document.getElementById(id);
    new bootstrap.Toast(el, { delay: 3500 }).show();
    el.addEventListener('hidden.bs.toast', () => el.remove());
}
</script>
@endpush
