{{-- ===== FORM PENGGUNA ===== --}}
<div class="card border-0 shadow-sm mb-3">
    <div class="card-header bg-white py-3">
        <h6 class="mb-0 fw-bold"><i class="bi bi-person me-2 text-primary"></i>Informasi Pengguna</h6>
    </div>
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label fw-semibold">Nama Lengkap <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control" required
                    value="{{ old('name', $user->name ?? '') }}">
                <div class="invalid-feedback" data-error-for="name"></div>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Email <span class="text-danger">*</span></label>
                <input type="email" name="email" class="form-control" required
                    value="{{ old('email', $user->email ?? '') }}">
                <div class="invalid-feedback" data-error-for="email"></div>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">
                    Password {!! isset($user) ? '<span class="text-muted small">(kosongkan jika tidak diubah)</span>' : '<span class="text-danger">*</span>' !!}
                </label>
                <div class="input-group">
                    <input type="password" name="password" id="input-password" class="form-control"
                        {{ isset($user) ? '' : 'required' }} autocomplete="new-password">
                    <button type="button" class="btn btn-outline-secondary" onclick="togglePassword()">
                        <i class="bi bi-eye" id="eye-icon"></i>
                    </button>
                </div>
                <div class="invalid-feedback" data-error-for="password"></div>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold">Role</label>
                <select name="role_id" id="select-role" class="form-select">
                    <option value="">-- Tanpa Role --</option>
                </select>
                <div class="invalid-feedback" data-error-for="role_id"></div>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold">Status</label>
                <select name="is_active" class="form-select">
                    <option value="1" {{ old('is_active', $user->is_active ?? true) ? 'selected' : '' }}>Aktif</option>
                    <option value="0" {{ !old('is_active', $user->is_active ?? true) ? 'selected' : '' }}>Nonaktif</option>
                </select>
            </div>
        </div>
    </div>
</div>

{{-- Tombol --}}
<div class="d-flex gap-2">
    <button type="submit" id="btn-submit" class="btn btn-primary">
        <span id="btn-spinner" class="spinner-border spinner-border-sm me-1 d-none"></span>
        <i class="bi bi-save me-1" id="btn-icon"></i>
        <span id="btn-label">Simpan</span>
    </button>
    <a href="{{ route('settings.users.index') }}" class="btn btn-secondary">Batal</a>
</div>

@push('scripts')
<script>
const ROLES_URL   = '{{ url("api/settings/users/roles") }}';
const INDEX_URL   = '{{ route("settings.users.index") }}';
const CURRENT_ROLE_ID = {{ isset($user) && $user->role_id ? $user->role_id : 'null' }};

/* ── Load roles ── */
fetch(ROLES_URL, { headers: { 'Accept': 'application/json' } })
    .then(r => r.json())
    .then(roles => {
        const sel = document.getElementById('select-role');
        roles.forEach(r => {
            const opt = document.createElement('option');
            opt.value = r.id;
            opt.textContent = r.label;
            if (CURRENT_ROLE_ID && r.id == CURRENT_ROLE_ID) opt.selected = true;
            sel.appendChild(opt);
        });
    });

/* ── Toggle password visibility ── */
function togglePassword() {
    const inp  = document.getElementById('input-password');
    const icon = document.getElementById('eye-icon');
    if (inp.type === 'password') { inp.type = 'text'; icon.className = 'bi bi-eye-slash'; }
    else                         { inp.type = 'password'; icon.className = 'bi bi-eye'; }
}

/* ── Form submit ── */
document.getElementById('siswa-form').addEventListener('submit', async function (e) {
    e.preventDefault();

    // Clear previous errors
    document.querySelectorAll('.invalid-feedback').forEach(el => { el.textContent = ''; el.closest('.form-control, .form-select, .input-group')?.classList.remove('is-invalid'); });
    document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));

    const btn     = document.getElementById('btn-submit');
    const spinner = document.getElementById('btn-spinner');
    const label   = document.getElementById('btn-label');
    btn.disabled  = true;
    spinner.classList.remove('d-none');
    label.textContent = 'Menyimpan...';

    const formData = new FormData(this);

    try {
        const resp = await fetch(this.action, {
            method: 'POST',
            headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content },
            body: formData,
        });

        const json = await resp.json();

        if (resp.ok && json.success) {
            window.location.href = INDEX_URL + '?success=' + encodeURIComponent(json.message);
            return;
        }

        // Validation errors
        if (resp.status === 422 && json.errors) {
            Object.entries(json.errors).forEach(([field, msgs]) => {
                const el = document.querySelector(`[data-error-for="${field}"]`);
                if (el) {
                    el.textContent = msgs[0];
                    const input = document.querySelector(`[name="${field}"]`);
                    input?.classList.add('is-invalid');
                    el.classList.add('d-block');
                }
            });
        } else {
            alert(json.message || 'Terjadi kesalahan.');
        }
    } catch {
        alert('Terjadi kesalahan koneksi.');
    } finally {
        btn.disabled = false;
        spinner.classList.add('d-none');
        label.textContent = 'Simpan';
    }
});
</script>
@endpush
