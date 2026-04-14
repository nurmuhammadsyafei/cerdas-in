@extends('layouts.app')

@section('title', 'Data Siswa')
@section('page-title', 'Data Siswa')

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
        <div class="card-header bg-white d-flex align-items-center justify-content-between py-3">
            <h6 class="mb-0 fw-bold"><i class="bi bi-people me-2 text-primary"></i>Daftar Siswa</h6>
            <a href="{{ route('master.siswa.create') }}" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-lg me-1"></i> Tambah Siswa
            </a>
        </div>

        <div class="card-body p-0">
            {{-- Search --}}
            <div class="p-3 border-bottom">
                <div class="input-group" style="max-width: 320px;">
                    <span class="input-group-text bg-white"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" id="search-input" class="form-control form-control-sm border-start-0"
                        placeholder="Cari nama / NISN / NIS...">
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th width="50">No</th>
                            <th width="70">Foto</th>
                            <th>Nama Lengkap</th>
                            <th>NISN / NIS</th>
                            <th>Jenis Kelamin</th>
                            <th>TTL</th>
                            <th>No. HP Ortu</th>
                            <th width="130" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="table-body">
                        <tr>
                            <td colspan="8" class="text-center py-4">
                                <span class="spinner-border spinner-border-sm me-2"></span>Memuat data...
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div id="pagination-wrap" class="p-3 border-top d-none"></div>
        </div>
    </div>
</div>

@push('scripts')
<script>
const API_URL   = '{{ url("api/master/siswa") }}';
const EDIT_BASE = '{{ url("master/siswa") }}';
const CSRF      = document.querySelector('meta[name="csrf-token"]').content;

let currentPage   = 1;
let currentSearch = '';
let searchTimer;

/* ── Load table ── */
function loadSiswa(page, search) {
    currentPage   = page   ?? currentPage;
    currentSearch = search ?? currentSearch;

    const tbody = document.getElementById('table-body');
    tbody.innerHTML = '<tr><td colspan="8" class="text-center py-4">' +
        '<span class="spinner-border spinner-border-sm me-2"></span>Memuat data...</td></tr>';

    fetch(`${API_URL}?page=${currentPage}&search=${encodeURIComponent(currentSearch)}`, {
        headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(r => r.json())
    .then(res => {
        renderRows(res);
        renderPagination(res);
    })
    .catch(() => {
        tbody.innerHTML = '<tr><td colspan="8" class="text-center text-danger py-4">' +
            '<i class="bi bi-exclamation-circle me-1"></i>Gagal memuat data.</td></tr>';
    });
}

/* ── Render rows ── */
function renderRows(res) {
    const tbody  = document.getElementById('table-body');
    const offset = (res.current_page - 1) * res.per_page;

    if (!res.data.length) {
        tbody.innerHTML = '<tr><td colspan="8" class="text-center text-muted py-5">' +
            '<i class="bi bi-inbox fs-2 d-block mb-2"></i>Belum ada data siswa.</td></tr>';
        return;
    }

    tbody.innerHTML = res.data.map((s, i) => `
        <tr>
            <td>${offset + i + 1}</td>
            <td>${fotoHtml(s)}</td>
            <td>
                <div class="fw-semibold">${esc(s.nama_lengkap)}</div>
                ${s.nama_panggilan ? `<small class="text-muted">${esc(s.nama_panggilan)}</small>` : ''}
            </td>
            <td>
                <div class="small">${s.nisn || '-'}</div>
                <div class="small text-muted">${s.nis || '-'}</div>
            </td>
            <td>${jkBadge(s.jenis_kelamin)}</td>
            <td class="small">${ttl(s)}</td>
            <td class="small">${s.no_hp_ortu || '-'}</td>
            <td class="text-center text-nowrap">
                <a href="${EDIT_BASE}/${s.id}/edit" class="btn btn-sm btn-warning" title="Edit">
                    <i class="bi bi-pencil"></i>
                </a>
                <button class="btn btn-sm btn-danger" title="Hapus"
                    data-id="${s.id}" data-nama="${escAttr(s.nama_lengkap)}"
                    onclick="deleteSiswa(this)">
                    <i class="bi bi-trash"></i>
                </button>
            </td>
        </tr>
    `).join('');
}

/* ── Render pagination ── */
function renderPagination(res) {
    const wrap = document.getElementById('pagination-wrap');
    if (res.last_page <= 1) { wrap.classList.add('d-none'); return; }
    wrap.classList.remove('d-none');

    const s = Math.max(1, res.current_page - 2);
    const e = Math.min(res.last_page, res.current_page + 2);
    let pages = '';

    if (s > 1) pages += pageItem(1);
    if (s > 2) pages += `<li class="page-item disabled"><span class="page-link">…</span></li>`;
    for (let p = s; p <= e; p++) pages += pageItem(p, p === res.current_page);
    if (e < res.last_page - 1) pages += `<li class="page-item disabled"><span class="page-link">…</span></li>`;
    if (e < res.last_page) pages += pageItem(res.last_page);

    wrap.innerHTML = `
        <div class="d-flex align-items-center flex-wrap gap-2">
            <nav><ul class="pagination pagination-sm mb-0">
                <li class="page-item ${res.current_page===1?'disabled':''}">
                    <a class="page-link" href="#" onclick="return goPage(${res.current_page-1})">‹</a></li>
                ${pages}
                <li class="page-item ${res.current_page===res.last_page?'disabled':''}">
                    <a class="page-link" href="#" onclick="return goPage(${res.current_page+1})">›</a></li>
            </ul></nav>
            <small class="text-muted">
                Menampilkan ${res.from||0}–${res.to||0} dari ${res.total} data
            </small>
        </div>`;
}
function pageItem(p, active=false) {
    return `<li class="page-item ${active?'active':''}">
        <a class="page-link" href="#" onclick="return goPage(${p})">${p}</a></li>`;
}
function goPage(p) { loadSiswa(p, currentSearch); return false; }

/* ── Delete ── */
function deleteSiswa(btn) {
    const id   = btn.dataset.id;
    const nama = btn.getAttribute('data-nama');
    if (!confirm(`Hapus data siswa "${nama}"?\nData tidak dapat dikembalikan.`)) return;

    btn.disabled = true;
    fetch(`${API_URL}/${id}`, {
        method: 'DELETE',
        headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF }
    })
    .then(r => r.json())
    .then(res => {
        if (res.success) {
            showToast(res.message, 'success');
            loadSiswa(currentPage, currentSearch);
        } else {
            showToast('Gagal menghapus data.', 'danger');
            btn.disabled = false;
        }
    })
    .catch(() => { showToast('Terjadi kesalahan koneksi.', 'danger'); btn.disabled = false; });
}

/* ── Toast ── */
function showToast(msg, type='success') {
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
function esc(s)     { const d=document.createElement('div'); d.textContent=s; return d.innerHTML; }
function escAttr(s) { return (s||'').replace(/"/g,'&quot;'); }
function fotoHtml(s) {
    return s.foto_url
        ? `<img src="${s.foto_url}" class="rounded" style="width:44px;height:55px;object-fit:cover;">`
        : `<div class="rounded bg-secondary bg-opacity-10 d-flex align-items-center justify-content-center"
              style="width:44px;height:55px;"><i class="bi bi-person text-secondary fs-5"></i></div>`;
}
function jkBadge(jk) {
    return jk === 'L'
        ? '<span class="badge bg-primary bg-opacity-10 text-primary">Laki-laki</span>'
        : '<span class="badge bg-danger bg-opacity-10 text-danger">Perempuan</span>';
}
function ttl(s) {
    const parts = [];
    if (s.tempat_lahir) parts.push(esc(s.tempat_lahir));
    if (s.tanggal_lahir) {
        const d = new Date(s.tanggal_lahir);
        parts.push(d.toLocaleDateString('id-ID', {day:'numeric',month:'short',year:'numeric'}));
    }
    return parts.join(', ') || '-';
}

/* ── Search debounce ── */
document.getElementById('search-input').addEventListener('input', function () {
    clearTimeout(searchTimer);
    searchTimer = setTimeout(() => loadSiswa(1, this.value), 400);
});

/* ── Init ── */
loadSiswa(1, '');
</script>
@endpush
@endsection
