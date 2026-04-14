@extends('layouts.app')

@section('title', 'Menu')
@section('page-title', 'Menu')

@section('content')
<div class="container-fluid">

    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="bi bi-house-door"></i></a></li>
            <li class="breadcrumb-item">Pengaturan</li>
            <li class="breadcrumb-item active">Menu</li>
        </ol>
    </nav>

    <div id="toast-wrap" class="position-fixed top-0 end-0 p-3" style="z-index:1100"></div>

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white d-flex align-items-center justify-content-between py-3">
            <h6 class="mb-0 fw-bold"><i class="bi bi-layout-sidebar me-2 text-primary"></i>Daftar Menu</h6>
            <a href="{{ route('settings.menus.create') }}" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-lg me-1"></i> Tambah Menu
            </a>
        </div>

        <div class="card-body p-0">
            {{-- Search --}}
            <div class="p-3 border-bottom">
                <div class="input-group" style="max-width:300px;">
                    <span class="input-group-text bg-white"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" id="search-input" class="form-control form-control-sm border-start-0"
                        placeholder="Cari label / name...">
                </div>
            </div>

            <div id="table-wrap">
                <div class="text-center py-4">
                    <span class="spinner-border spinner-border-sm me-2"></span>Memuat data...
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
const API_URL   = '{{ url("api/settings/menus") }}';
const EDIT_BASE = '{{ url("settings/menus") }}';
const CSRF      = document.querySelector('meta[name="csrf-token"]').content;

let currentPage   = 1;
let currentSearch = '';
let searchTimer;

document.getElementById('search-input').addEventListener('input', function () {
    clearTimeout(searchTimer);
    searchTimer = setTimeout(() => loadMenus(1, this.value), 400);
});

function loadMenus(page, search) {
    currentPage   = page   ?? currentPage;
    currentSearch = search ?? currentSearch;

    const wrap = document.getElementById('table-wrap');
    wrap.innerHTML = '<div class="text-center py-4"><span class="spinner-border spinner-border-sm me-2"></span>Memuat...</div>';

    fetch(`${API_URL}?page=${currentPage}&search=${encodeURIComponent(currentSearch)}`, {
        headers: { 'Accept': 'application/json' }
    })
    .then(r => r.json())
    .then(res => renderTree(res))
    .catch(() => {
        wrap.innerHTML = '<div class="text-center text-danger py-4"><i class="bi bi-exclamation-circle me-1"></i>Gagal memuat data.</div>';
    });
}

function renderTree(res) {
    const wrap = document.getElementById('table-wrap');

    if (!res.data.length) {
        wrap.innerHTML = '<div class="text-center text-muted py-5"><i class="bi bi-inbox fs-2 d-block mb-2"></i>Belum ada menu.</div>';
        return;
    }

    let html = '<div class="table-responsive"><table class="table table-hover align-middle mb-0">';
    html += `<thead class="table-light"><tr>
        <th width="50">No</th><th>Label</th><th>Name / Identifier</th>
        <th>Route</th><th>Sort</th><th>Status</th><th width="110" class="text-center">Aksi</th>
    </tr></thead><tbody>`;

    res.data.forEach((parent, i) => {
        const offset = (res.current_page - 1) * res.per_page;
        html += rowHtml(parent, offset + i + 1, false);
        (parent.children || []).forEach(child => {
            html += rowHtml(child, '', true);
        });
    });

    html += '</tbody></table></div>';

    // Pagination
    if (res.last_page > 1) {
        html += renderPagination(res);
    }

    wrap.innerHTML = html;
}

function rowHtml(item, no, isChild) {
    const statusBadge = item.is_active
        ? '<span class="badge bg-success-subtle text-success">Aktif</span>'
        : '<span class="badge bg-secondary-subtle text-secondary">Nonaktif</span>';

    const labelCell = isChild
        ? `<td><span class="ms-3 text-muted">↳</span> <i class="${esc(item.icon||'bi bi-dot')} me-1 text-muted"></i><span class="small">${esc(item.label)}</span></td>`
        : `<td><i class="${esc(item.icon||'bi bi-folder')} me-1 text-primary"></i><strong>${esc(item.label)}</strong></td>`;

    const childCount = !isChild && item.children?.length
        ? ` <span class="badge bg-primary-subtle text-primary ms-1">${item.children.length}</span>` : '';

    return `<tr class="${isChild ? 'table-light' : ''}">
        <td class="text-muted small">${no || ''}</td>
        ${isChild
            ? `<td><span class="ms-3 text-muted">↳</span> <i class="${esc(item.icon||'bi bi-dot')} me-1 text-muted small"></i><span class="small">${esc(item.label)}</span></td>`
            : `<td><i class="${esc(item.icon||'bi bi-folder')} me-1 text-primary"></i><strong>${esc(item.label)}</strong>${childCount}</td>`
        }
        <td><code class="small">${esc(item.name)}</code></td>
        <td class="small text-muted">${item.route_name ? esc(item.route_name) : '<span class="text-warning small">-</span>'}</td>
        <td class="small">${item.sort_order}</td>
        <td>${statusBadge}</td>
        <td class="text-center text-nowrap">
            <a href="${EDIT_BASE}/${item.id}/edit" class="btn btn-sm btn-warning" title="Edit">
                <i class="bi bi-pencil"></i>
            </a>
            <button class="btn btn-sm btn-danger" title="Hapus"
                data-id="${item.id}" data-label="${escAttr(item.label)}"
                onclick="deleteMenu(this)">
                <i class="bi bi-trash"></i>
            </button>
        </td>
    </tr>`;
}

function renderPagination(res) {
    const s = Math.max(1, res.current_page - 2);
    const e = Math.min(res.last_page, res.current_page + 2);
    let pages = '';
    if (s > 1) pages += pageItem(1);
    if (s > 2) pages += `<li class="page-item disabled"><span class="page-link">…</span></li>`;
    for (let p = s; p <= e; p++) pages += pageItem(p, p === res.current_page);
    if (e < res.last_page - 1) pages += `<li class="page-item disabled"><span class="page-link">…</span></li>`;
    if (e < res.last_page) pages += pageItem(res.last_page);

    return `<div class="p-3 border-top d-flex align-items-center flex-wrap gap-2">
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
    return `<li class="page-item ${active?'active':''}"><a class="page-link" href="#" onclick="return goPage(${p})">${p}</a></li>`;
}
function goPage(p) { loadMenus(p, currentSearch); return false; }

function deleteMenu(btn) {
    const id    = btn.dataset.id;
    const label = btn.getAttribute('data-label');
    if (!confirm(`Hapus menu "${label}"?\nSubmenu yang ada di dalamnya juga akan terhapus.`)) return;

    btn.disabled = true;
    fetch(`${API_URL}/${id}`, {
        method: 'DELETE',
        headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF }
    })
    .then(r => r.json())
    .then(res => {
        if (res.success) { showToast(res.message, 'success'); loadMenus(currentPage, currentSearch); }
        else { showToast(res.message || 'Gagal menghapus.', 'danger'); btn.disabled = false; }
    })
    .catch(() => { showToast('Terjadi kesalahan koneksi.', 'danger'); btn.disabled = false; });
}

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

function esc(s)     { const d=document.createElement('div'); d.textContent=s||''; return d.innerHTML; }
function escAttr(s) { return (s||'').replace(/"/g,'&quot;'); }

loadMenus(1, '');
</script>
@endpush
@endsection
