@extends('layouts.app')

@section('title', 'Data Siswa')
@section('page-title', 'Data Siswa')

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css">
<style>
    /* Custom checkbox */
    .row-check, #check-all {
        width: 18px;
        height: 18px;
        cursor: pointer;
        accent-color: #083053;
        border-radius: 4px;
    }
    #tbl-siswa td:nth-child(2),
    #tbl-siswa th:nth-child(2) {
        text-align: center;
        vertical-align: middle;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">

    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="bi bi-house-door"></i></a></li>
            <li class="breadcrumb-item">Data Master</li>
            <li class="breadcrumb-item active">Siswa</li>
        </ol>
    </nav>

    {{-- Toast notifikasi --}}
    <div id="toast-wrap" class="position-fixed top-0 end-0 p-3" style="z-index:1100"></div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="mb-0 fw-bold"><i class="bi bi-people me-2"></i>Daftar Siswa</h6>
                <div class="d-flex gap-2">
                    <button onclick="printSiswa()" class="btn btn-sm btn-outline-secondary">
                        <i class="bi bi-printer me-1"></i> Print
                    </button>
                    <a href="{{ route('master.siswa.create') }}" class="btn btn-primary btn-sm">
                        <i class="bi bi-plus-lg me-1"></i> Tambah Siswa
                    </a>
                </div>
            </div>

            <div class="table-responsive">
                <table id="tbl-siswa" class="table table-hover align-middle w-100">
                    <thead class="table-light">
                        <tr>
                            <th width="50">No</th>
                            <th width="50"><input type="checkbox" id="check-all" title="Pilih Semua"></th>
                            <th width="100" class="text-center"></th>
                            <th width="60">Foto</th>
                            <th>Nama Lengkap</th>
                            <th>NISN</th>
                            <th>NIS</th>
                            <th>JK</th>
                            <th>TTL</th>
                            <th>No. HP Ortu</th>
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
const API_URL   = '{{ url("api/master/siswa") }}';
const EDIT_BASE = '{{ url("master/siswa") }}';
const CSRF      = document.querySelector('meta[name="csrf-token"]').content;

const table = $('#tbl-siswa').DataTable({
    ajax: {
        url: API_URL + '?all=1',
        dataSrc: 'data'
    },
    columns: [
        {
            data: null,
            orderable: false,
            searchable: false,
            render: (d, t, r, meta) => meta.row + 1
        },
        {
            data: null,
            orderable: false,
            searchable: false,
            render: (d, t, r) => `
                <div class="d-flex justify-content-center align-items-center">
                    <input type="checkbox" class="row-check form-check-input" data-code="${r.user_code}" data-nama="${escAttr(r.nama_lengkap)}" style="width:18px;height:18px;cursor:pointer;">
                </div>`
        },
        {
            data: 'user_code',
            orderable: false,
            searchable: false,
            render: (code, type, row) => `
                <div class="d-flex gap-1 justify-content-center">
                    <a href="${EDIT_BASE}/${code}/edit" class="btn btn-sm btn-warning" title="Edit">
                        <i class="bi bi-pencil"></i>
                    </a>
                    <button class="btn btn-sm btn-danger" title="Hapus"
                        onclick="deleteSiswa('${code}', '${escAttr(row.nama_lengkap)}')">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>`
        },
        {
            data: 'foto_url',
            orderable: false,
            searchable: false,
            render: (src) => src
                ? `<img src="${src}" class="rounded" style="width:40px;height:50px;object-fit:cover;">`
                : `<div class="rounded bg-secondary bg-opacity-10 d-flex align-items-center justify-content-center" style="width:40px;height:50px;"><i class="bi bi-person text-secondary"></i></div>`
        },
        {
            data: 'nama_lengkap',
            render: (val, type, row) => {
                let html = `<div class="fw-semibold">${esc(val)}</div>`;
                if (row.nama_panggilan) html += `<small class="text-muted">${esc(row.nama_panggilan)}</small>`;
                return html;
            }
        },
        { data: 'nisn', defaultContent: '-' },
        { data: 'nis',  defaultContent: '-' },
        {
            data: 'jenis_kelamin',
            render: (jk) => jk === 'L'
                ? '<span class="badge bg-primary bg-opacity-10 text-primary">Laki-laki</span>'
                : '<span class="badge bg-danger bg-opacity-10 text-danger">Perempuan</span>'
        },
        {
            data: null,
            render: (d, t, row) => {
                const parts = [];
                if (row.tempat_lahir) parts.push(esc(row.tempat_lahir));
                if (row.tanggal_lahir) {
                    const dt = new Date(row.tanggal_lahir);
                    parts.push(dt.toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric' }));
                }
                return `<span class="small">${parts.join(', ') || '-'}</span>`;
            }
        },
        {
            data: 'no_hp_ortu',
            defaultContent: '-',
            render: (val) => `<span class="small">${val || '-'}</span>`
        },
    ],
    language: {
        url: '//cdn.datatables.net/plug-ins/1.13.8/i18n/id.json'
    },
    pageLength: 15,
    lengthMenu: [10, 15, 25, 50, 100],
    order: [[2, 'asc']],
    dom: "<'row mb-2'<'col-sm-6'l><'col-sm-6'f>>" +
         "<'row'<'col-12'tr>>" +
         "<'row mt-2'<'col-sm-5'i><'col-sm-7'p>>"
});

/* ── Delete ── */
function deleteSiswa(code, nama) {
    if (!confirm(`Hapus data siswa "${nama}"?\nData tidak dapat dikembalikan.`)) return;

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

/* ── Select All ── */
$('#tbl-siswa').on('draw.dt', function () {
    $('#check-all').prop('checked', false);
});

$(document).on('change', '#check-all', function () {
    const checked = $(this).is(':checked');
    $('#tbl-siswa .row-check').prop('checked', checked);
});

$(document).on('change', '.row-check', function () {
    const total   = $('#tbl-siswa .row-check').length;
    const checked = $('#tbl-siswa .row-check:checked').length;
    $('#check-all').prop('indeterminate', checked > 0 && checked < total)
                   .prop('checked', checked === total && total > 0);
});

/* ── Print ── */
function printSiswa() {
    const checked = [];
    $('#tbl-siswa .row-check:checked').each(function () {
        checked.push({
            code : $(this).data('code'),
            nama : $(this).data('nama')
        });
    });

    if (checked.length === 0) {
        alert('Pilih minimal 1 siswa terlebih dahulu sebelum print.');
        return;
    }

    const list = checked.map((s, i) => `${i + 1}. ${s.nama} (${s.code})`).join('\n');
    alert(`Siswa yang dipilih (${checked.length}):\n\n${list}`);
}

/* ── Toast ── */
function showToast(msg, type = 'success') {
    const id = 'toast-' + Date.now();
    document.getElementById('toast-wrap').insertAdjacentHTML('beforeend', `
        <div id="${id}" class="toast align-items-center text-bg-${type} border-0 show" role="alert">
            <div class="d-flex">
                <div class="toast-body">${msg}</div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto"
                    onclick="this.closest('.toast').remove()"></button>
            </div>
        </div>`);
    setTimeout(() => document.getElementById(id)?.remove(), 4000);
}

/* ── Helpers ── */
function esc(s)     { const d = document.createElement('div'); d.textContent = s ?? ''; return d.innerHTML; }
function escAttr(s) { return (s || '').replace(/"/g, '&quot;').replace(/'/g, '&#39;'); }
</script>
@endpush
