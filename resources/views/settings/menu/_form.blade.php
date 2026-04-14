{{-- ===== FORM MENU ===== --}}
<div class="card border-0 shadow-sm mb-3">
    <div class="card-header bg-white py-3">
        <h6 class="mb-0 fw-bold"><i class="bi bi-layout-sidebar me-2 text-primary"></i>Detail Menu</h6>
    </div>
    <div class="card-body">
        <div class="row g-3">

            {{-- Parent --}}
            <div class="col-md-6">
                <label class="form-label fw-semibold">Tipe Menu</label>
                <select name="parent_id" id="select-parent" class="form-select">
                    <option value="">-- Menu Utama (tidak punya parent) --</option>
                </select>
                <div class="form-text">Pilih parent jika ini adalah <strong>submenu</strong>. Kosongkan jika ini <strong>menu utama</strong>.</div>
                <div class="invalid-feedback" data-error-for="parent_id"></div>
            </div>

            {{-- Label --}}
            <div class="col-md-6">
                <label class="form-label fw-semibold">Label <span class="text-danger">*</span></label>
                <input type="text" name="label" class="form-control" required
                    placeholder="cth: Data Siswa"
                    value="{{ old('label', $menu->label ?? '') }}">
                <div class="form-text">Nama yang ditampilkan di sidebar.</div>
                <div class="invalid-feedback" data-error-for="label"></div>
            </div>

            {{-- Name / identifier --}}
            <div class="col-md-6">
                <label class="form-label fw-semibold">Name / Identifier <span class="text-danger">*</span></label>
                <input type="text" name="name" id="input-name" class="form-control" required
                    placeholder="cth: master.siswa"
                    value="{{ old('name', $menu->name ?? '') }}">
                <div class="form-text">Unik, huruf kecil, gunakan titik sebagai pemisah. cth: <code>master.siswa</code></div>
                <div class="invalid-feedback" data-error-for="name"></div>
            </div>

            {{-- Icon --}}
            <div class="col-md-6">
                <label class="form-label fw-semibold">Icon</label>
                <div class="input-group">
                    <span class="input-group-text" id="icon-preview"><i id="icon-display" class="{{ old('icon', $menu->icon ?? 'bi bi-circle') }}"></i></span>
                    <input type="text" name="icon" id="input-icon" class="form-control"
                        placeholder="cth: bi bi-people"
                        value="{{ old('icon', $menu->icon ?? '') }}">
                </div>
                <div class="form-text">Bootstrap Icons class. <a href="https://icons.getbootstrap.com" target="_blank">Lihat daftar icon <i class="bi bi-box-arrow-up-right small"></i></a></div>
            </div>

            {{-- Route name --}}
            <div class="col-md-6">
                <label class="form-label fw-semibold">Route Name</label>
                <input type="text" name="route_name" class="form-control"
                    placeholder="cth: master.siswa.index"
                    value="{{ old('route_name', $menu->route_name ?? '') }}">
                <div class="form-text">Named route Laravel. Kosongkan untuk menu utama.</div>
                <div class="invalid-feedback" data-error-for="route_name"></div>
            </div>

            {{-- Sort order --}}
            <div class="col-md-3">
                <label class="form-label fw-semibold">Urutan</label>
                <input type="number" name="sort_order" class="form-control" min="0"
                    value="{{ old('sort_order', $menu->sort_order ?? 0) }}">
                <div class="form-text">Angka kecil tampil lebih atas.</div>
            </div>

            {{-- Status --}}
            <div class="col-md-3">
                <label class="form-label fw-semibold">Status</label>
                <select name="is_active" class="form-select">
                    <option value="1" {{ old('is_active', $menu->is_active ?? true) ? 'selected' : '' }}>Aktif</option>
                    <option value="0" {{ !old('is_active', $menu->is_active ?? true) ? 'selected' : '' }}>Nonaktif</option>
                </select>
            </div>

        </div>
    </div>
</div>

{{-- Tombol --}}
<div class="d-flex gap-2">
    <button type="submit" id="btn-submit" class="btn btn-primary">
        <span id="btn-spinner" class="spinner-border spinner-border-sm me-1 d-none"></span>
        <i class="bi bi-save me-1"></i>
        <span id="btn-label">Simpan</span>
    </button>
    <a href="{{ route('settings.menus.index') }}" class="btn btn-secondary">Batal</a>
</div>

@push('scripts')
<script>
const PARENTS_URL     = '{{ url("api/settings/menus/parents") }}';
const INDEX_URL       = '{{ route("settings.menus.index") }}';
const CURRENT_PARENT  = {{ isset($menu) && $menu->parent_id ? $menu->parent_id : 'null' }};

/* ── Load parent options ── */
fetch(PARENTS_URL, { headers: { 'Accept': 'application/json' } })
    .then(r => r.json())
    .then(parents => {
        const sel = document.getElementById('select-parent');
        parents.forEach(p => {
            const opt = document.createElement('option');
            opt.value = p.id;
            opt.textContent = p.label;
            if (CURRENT_PARENT && p.id == CURRENT_PARENT) opt.selected = true;
            sel.appendChild(opt);
        });
    });

/* ── Icon live preview ── */
document.getElementById('input-icon').addEventListener('input', function () {
    document.getElementById('icon-display').className = this.value.trim() || 'bi bi-circle';
});

/* ── Auto-generate name from label (only on create, when name is still empty) ── */
@if (!isset($menu))
document.querySelector('[name="label"]').addEventListener('input', function () {
    const nameField = document.getElementById('input-name');
    if (nameField.dataset.edited) return;
    const parent = document.getElementById('select-parent');
    const prefix = parent.value ? parent.options[parent.selectedIndex]?.text.toLowerCase().replace(/\s+/g, '_') + '.' : '';
    nameField.value = prefix + this.value.toLowerCase().replace(/\s+/g, '_').replace(/[^a-z0-9_.]/g, '');
});
document.getElementById('input-name').addEventListener('input', function () {
    this.dataset.edited = '1';
});
@endif

/* ── Form submit ── */
document.getElementById('menu-form').addEventListener('submit', async function (e) {
    e.preventDefault();

    document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
    document.querySelectorAll('[data-error-for]').forEach(el => { el.textContent = ''; el.classList.remove('d-block'); });

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

        if (resp.status === 422 && json.errors) {
            Object.entries(json.errors).forEach(([field, msgs]) => {
                const errEl = document.querySelector(`[data-error-for="${field}"]`);
                if (errEl) { errEl.textContent = msgs[0]; errEl.classList.add('d-block'); }
                const input = document.querySelector(`[name="${field}"]`);
                input?.classList.add('is-invalid');
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
