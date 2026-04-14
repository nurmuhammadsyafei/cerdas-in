@extends('layouts.app')

@section('title', 'Pengguna')
@section('page-title', 'Pengguna')

@section('content')
<div class="container-fluid">

    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="bi bi-house-door"></i></a></li>
            <li class="breadcrumb-item">Pengaturan</li>
            <li class="breadcrumb-item active">Pengguna</li>
        </ol>
    </nav>

    {{-- Toast --}}
    <div id="toast-wrap" class="position-fixed top-0 end-0 p-3" style="z-index:1100"></div>

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white d-flex align-items-center justify-content-between py-3">
            <h6 class="mb-0 fw-bold"><i class="bi bi-people me-2 text-primary"></i>Daftar Pengguna</h6>
            <a href="{{ route('settings.users.create') }}" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-lg me-1"></i> Tambah Pengguna
            </a>
        </div>

        <div class="card-body p-0">
            {{-- Filter --}}
            <div class="p-3 border-bottom d-flex flex-wrap gap-2 align-items-center">
                <div class="input-group" style="max-width: 280px;">
                    <span class="input-group-text bg-white"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" id="search-input" class="form-control form-control-sm border-start-0"
                        placeholder="Cari nama / email...">
                </div>
                <select id="filter-role" class="form-select form-select-sm" style="max-width:180px;">
                    <option value="">Semua Role</option>
                </select>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th width="50">No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Login Terakhir</th>
                            <th width="120" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="table-body">
                        <tr>
                            <td colspan="7" class="text-center py-4">
                                <span class="spinner-border spinner-border-sm me-2"></span>Memuat data...
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div id="pagination-wrap" class="p-3 border-top d-none"></div>
        </div>
    </div>
</div>

@push('scripts')
<script>
const API_URL     = '{{ url("api/settings/users") }}';
const ROLES_URL   = '{{ url("api/settings/users/roles") }}';
const EDIT_BASE   = '{{ url("settings/users") }}';
const CSRF        = document.querySelector('meta[name="csrf-token"]').content;

let currentPage   = 1;
let currentSearch = '';
let currentRole   = '';
let searchTimer;

/* ── Load roles for filter ── */
fetch(ROLES_URL, { headers: { 'Accept': 'application/json' } })
    .then(r => r.json())
    .then(roles => {
        const sel = document.getElementById('filter-role');
        roles.forEach(r => {
            const opt = document.createElement('option');
            opt.value = r.id;
            opt.textContent = r.label;
            sel.appendChild(opt);
        });
    });

/* ── Search ── */
document.getElementById('search-input').addEventListener('input', function () {
    clearTimeout(searchTimer);
    searchTimer = setTimeout(() => loadUsers(1, this.value, currentRole), 400);
});
document.getElementById('filter-role').addEventListener('change', function () {
    currentRole = this.value;
    loadUsers(1, currentSearch, currentRole);
});

/* ── Load table ── */
function loadUsers(page, search, role) {
    currentPage   = page   ?? currentPage;
    currentSearch = search ?? currentSearch;
    currentRole   = role   ?? currentRole;

    const tbody = document.getElementById('table-body');
    tbody.innerHTML = '<tr><td colspan="7" class="text-center py-4">' +
        '<span class="spinner-border spinner-border-sm me-2"></span>Memuat data...</td></tr>';

    let url = `${API_URL}?page=${currentPage}&search=${encodeURIComponent(currentSearch)}`;
    if (currentRole) url += `&role_id=${currentRole}`;

    fetch(url, { headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' } })
        .then(r => r.json())
        .then(res => { renderRows(res); renderPagination(res); })
        .catch(() => {
            tbody.innerHTML = '<tr><td colspan="7" class="text-center text-danger py-4">' +
                '<i class="bi bi-exclamation-circle me-1"></i>Gagal memuat data.</td></tr>';
        });
}

/* ── Render rows ── */
function renderRows(res) {
    const tbody  = document.getElementById('table-body');
    const offset = (res.current_page - 1) * res.per_page;

    if (!res.data.length) {
        tbody.innerHTML = '<tr><td colspan="7" class="text-center text-muted py-5">' +
            '<i class="bi bi-inbox fs-2 d-block mb-2"></i>Belum ada data pengguna.</td></tr>';
        return;
    }

    tbody.innerHTML = res.data.map((u, i) => `
        <tr>
            <td>${offset + i + 1}</td>
            <td class="fw-semibold">${esc(u.name)}</td>
            <td class="small text-muted">${esc(u.email)}</td>
            <td>${u.role ? `<span class="badge bg-primary-subtle text-primary">${esc(u.role.label)}</span>` : '<span class="text-muted small">-</span>'}</td>
            <td>${u.is_active
                ? '<span class="badge bg-success-subtle text-success">Aktif</span>'
                : '<span class="badge bg-secondary-subtle text-secondary">Nonaktif</span>'}</td>
            <td class="small text-muted">${u.last_login ? formatDate(u.last_login) : '-'}</td>
            <td class="text-center text-nowrap">
                <a href="${EDIT_BASE}/${u.user_code}/edit" class="btn btn-sm btn-warning" title="Edit">
                    <i class="bi bi-pencil"></i>
                </a>
                <button class="btn btn-sm btn-danger" title="Hapus"
                    data-id="${u.user_code}" data-nama="${escAttr(u.name)}"
                    onclick="deleteUser(this)">
                    <i class="bi bi-trash"></i>
                </button>
            </td>
        </tr>
    `).join('');
}

/* ── Pagination ── */
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
            <small class="text-muted">Menampilkan ${res.from||0}–${res.to||0} dari ${res.total} data</small>
        </div>`;
}
function pageItem(p, active=false) {
    return `<li class="page-item ${active?'active':''}">
        <a class="page-link" href="#" onclick="return goPage(${p})">${p}</a></li>`;
}
function goPage(p) { loadUsers(p, currentSearch, currentRole); return false; }

/* ── Delete ── */
function deleteUser(btn) {
    const id   = btn.dataset.id;
    const nama = btn.getAttribute('data-nama');
    if (!confirm(`Hapus pengguna "${nama}"?\nData tidak dapat dikembalikan.`)) return;

    btn.disabled = true;
    fetch(`${API_URL}/${id}`, {
        method: 'DELETE',
        headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF }
    })
    .then(r => r.json())
    .then(res => {
        if (res.success) {
            showToast(res.message, 'success');
            loadUsers(currentPage, currentSearch, currentRole);
        } else {
            showToast(res.message || 'Gagal menghapus data.', 'danger');
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
function esc(s)     { const d=document.createElement('div'); d.textContent=s||''; return d.innerHTML; }
function escAttr(s) { return (s||'').replace(/"/g,'&quot;'); }
function formatDate(dt) {
    if (!dt) return '-';
    const d = new Date(dt);
    return d.toLocaleDateString('id-ID', { day:'2-digit', month:'short', year:'numeric' }) +
           ' ' + d.toLocaleTimeString('id-ID', { hour:'2-digit', minute:'2-digit' });
}

/* ── Init ── */
loadUsers(1, '', '');
</script>
@endpush
@endsection
