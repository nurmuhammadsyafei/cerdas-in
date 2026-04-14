@extends('layouts.app')

@section('title', 'Hak Akses')
@section('page-title', 'Hak Akses')

@section('content')
<div class="container-fluid">

    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="bi bi-house-door"></i></a></li>
            <li class="breadcrumb-item">Pengaturan</li>
            <li class="breadcrumb-item active">Hak Akses</li>
        </ol>
    </nav>

    <div id="toast-wrap" class="position-fixed top-0 end-0 p-3" style="z-index:1100"></div>

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3 d-flex align-items-center justify-content-between flex-wrap gap-2">
            <h6 class="mb-0 fw-bold"><i class="bi bi-shield-check me-2 text-primary"></i>Pengaturan Hak Akses</h6>

            {{-- Role selector --}}
            <div class="d-flex align-items-center gap-2">
                <label class="form-label mb-0 fw-semibold small">Role:</label>
                <select id="role-select" class="form-select form-select-sm" style="min-width:180px;">
                    <option value="">-- Pilih Role --</option>
                </select>
            </div>
        </div>

        <div class="card-body p-0">
            <div id="matrix-wrap">
                <div class="text-center text-muted py-5">
                    <i class="bi bi-arrow-up-circle fs-3 d-block mb-2"></i>
                    Pilih role di atas untuk menampilkan hak akses.
                </div>
            </div>
        </div>

        <div class="card-footer bg-white border-top px-4 py-3 d-none" id="footer-actions">
            <button id="btn-save" class="btn btn-primary" onclick="saveAccess()">
                <span id="save-spinner" class="spinner-border spinner-border-sm me-1 d-none"></span>
                <i class="bi bi-save me-1"></i> Simpan Hak Akses
            </button>
            <button class="btn btn-outline-secondary ms-2" onclick="checkAll(true)">Centang Semua</button>
            <button class="btn btn-outline-secondary ms-1" onclick="checkAll(false)">Hapus Semua</button>
        </div>
    </div>
</div>

@push('scripts')
<script>
const ROLES_URL  = '{{ url("api/settings/hak-akses/roles") }}';
const ACCESS_URL = '{{ url("api/settings/hak-akses") }}';
const CSRF       = document.querySelector('meta[name="csrf-token"]').content;

let currentRoleId = null;

/* ── Load roles ── */
fetch(ROLES_URL, { headers: { 'Accept': 'application/json' } })
    .then(r => r.json())
    .then(roles => {
        const sel = document.getElementById('role-select');
        roles.forEach(r => {
            const opt = document.createElement('option');
            opt.value = r.id;
            opt.textContent = r.label;
            sel.appendChild(opt);
        });
    });

document.getElementById('role-select').addEventListener('change', function () {
    currentRoleId = this.value || null;
    if (currentRoleId) loadMatrix(currentRoleId);
    else {
        document.getElementById('matrix-wrap').innerHTML = `<div class="text-center text-muted py-5">
            <i class="bi bi-arrow-up-circle fs-3 d-block mb-2"></i>Pilih role di atas.</div>`;
        document.getElementById('footer-actions').classList.add('d-none');
    }
});

/* ── Load matrix ── */
function loadMatrix(roleId) {
    const wrap = document.getElementById('matrix-wrap');
    wrap.innerHTML = '<div class="text-center py-5"><span class="spinner-border spinner-border-sm me-2"></span>Memuat...</div>';

    fetch(`${ACCESS_URL}?role_id=${roleId}`, { headers: { 'Accept': 'application/json' } })
        .then(r => r.json())
        .then(parents => {
            renderMatrix(parents);
            document.getElementById('footer-actions').classList.remove('d-none');
        })
        .catch(() => {
            wrap.innerHTML = '<div class="text-center text-danger py-4">Gagal memuat data.</div>';
        });
}

/* ── Render matrix ── */
function renderMatrix(parents) {
    if (!parents.length) {
        document.getElementById('matrix-wrap').innerHTML =
            '<div class="text-center text-muted py-5">Tidak ada menu terdaftar.</div>';
        return;
    }

    let html = '<div class="p-4">';

    parents.forEach(parent => {
        const children = parent.children || [];

        html += `
        <div class="mb-4">
            <div class="d-flex align-items-center gap-2 mb-2">
                <i class="${esc(parent.icon || 'bi bi-folder')} text-primary fs-5"></i>
                <span class="fw-bold fs-6">${esc(parent.label)}</span>
                <span class="badge bg-secondary-subtle text-secondary">${children.length} submenu</span>
            </div>`;

        if (children.length === 0) {
            html += `<p class="text-muted small ms-4 mb-0">Belum ada submenu.</p>`;
        } else {
            html += `<div class="row g-2 ms-3">`;
            children.forEach(child => {
                const checked = child.has_access ? 'checked' : '';
                html += `
                <div class="col-md-4 col-lg-3">
                    <div class="form-check border rounded p-2 ps-4 bg-light h-100">
                        <input class="form-check-input menu-checkbox" type="checkbox"
                            id="menu-${child.id}" value="${child.id}" ${checked}>
                        <label class="form-check-label w-100" for="menu-${child.id}">
                            <i class="${esc(child.icon || 'bi bi-dot')} me-1 text-muted small"></i>
                            <span class="small fw-semibold">${esc(child.label)}</span>
                            ${child.route_name
                                ? `<div class="text-muted" style="font-size:0.7rem;">${esc(child.route_name)}</div>`
                                : '<div class="text-warning" style="font-size:0.7rem;">belum ada route</div>'}
                        </label>
                    </div>
                </div>`;
            });
            html += `</div>`;
        }

        html += `</div><hr class="my-1">`;
    });

    html += '</div>';
    document.getElementById('matrix-wrap').innerHTML = html;
}

/* ── Save ── */
async function saveAccess() {
    if (!currentRoleId) return;

    const ids = [...document.querySelectorAll('.menu-checkbox:checked')].map(el => parseInt(el.value));

    const btn     = document.getElementById('btn-save');
    const spinner = document.getElementById('save-spinner');
    btn.disabled  = true;
    spinner.classList.remove('d-none');

    try {
        const resp = await fetch(ACCESS_URL, {
            method:  'POST',
            headers: { 'Accept': 'application/json', 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF },
            body:    JSON.stringify({ role_id: currentRoleId, menu_ids: ids }),
        });
        const json = await resp.json();
        if (json.success) showToast(`${json.message} (${json.total} menu aktif)`, 'success');
        else              showToast(json.message || 'Gagal menyimpan.', 'danger');
    } catch {
        showToast('Terjadi kesalahan koneksi.', 'danger');
    } finally {
        btn.disabled = false;
        spinner.classList.add('d-none');
    }
}

/* ── Check/uncheck all ── */
function checkAll(state) {
    document.querySelectorAll('.menu-checkbox').forEach(cb => { cb.checked = state; });
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

function esc(s) { const d=document.createElement('div'); d.textContent=s||''; return d.innerHTML; }
</script>
@endpush
@endsection
