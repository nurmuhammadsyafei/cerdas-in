{{-- ===== _form.blade.php (Sekolah — digunakan oleh create & edit) ===== --}}
@php
    use Illuminate\Support\Facades\Storage;
    $isEdit = isset($sekolah) && $sekolah !== null;
@endphp

<div id="form-error-alert" class="alert alert-danger py-2 mb-3 d-none">
    <ul id="form-error-list" class="mb-0 ps-3"></ul>
</div>

{{-- ===== IDENTITAS SEKOLAH ===== --}}
<div class="card border-0 shadow-sm mb-3">
    <div class="card-header bg-white py-3">
        <h6 class="mb-0 fw-bold"><i class="bi bi-building me-2 text-primary"></i>Identitas Sekolah</h6>
    </div>
    <div class="card-body">
        <div class="row g-3">

            {{-- Logo --}}
            <div class="col-12 col-md-3 text-center">
                <div class="mb-2">
                    @if($isEdit && $sekolah->logo)
                        <img id="preview-logo" src="{{ Storage::url($sekolah->logo) }}"
                            class="rounded border" style="width:120px;height:120px;object-fit:cover;">
                    @else
                        <div id="preview-logo-placeholder" class="rounded border bg-light d-flex align-items-center
                            justify-content-center mx-auto" style="width:120px;height:120px;">
                            <i class="bi bi-building fs-1 text-secondary"></i>
                        </div>
                        <img id="preview-logo" src="#" class="rounded border d-none"
                            style="width:120px;height:120px;object-fit:cover;">
                    @endif
                </div>
                <label class="form-label small fw-semibold">Logo Sekolah</label>
                <input type="file" name="logo" id="logo"
                    class="form-control form-control-sm"
                    accept="image/jpg,image/jpeg,image/png">
                <div class="form-text">Maks. 2MB · JPG/PNG</div>
                <div class="invalid-feedback d-block small text-danger" data-error-for="logo"></div>
            </div>

            <div class="col-12 col-md-9">
                <div class="row g-3">
                    <div class="col-md-8">
                        <label class="form-label fw-semibold">Nama Sekolah <span class="text-danger">*</span></label>
                        <input type="text" name="nama_sekolah" id="nama_sekolah"
                            class="form-control"
                            value="{{ old('nama_sekolah', $sekolah->nama_sekolah ?? '') }}" required>
                        <div class="invalid-feedback" data-error-for="nama_sekolah"></div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">NPSN</label>
                        <input type="text" name="npsn"
                            class="form-control"
                            value="{{ old('npsn', $sekolah->npsn ?? '') }}">
                        <div class="invalid-feedback" data-error-for="npsn"></div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Telepon / HP</label>
                        <input type="text" name="telepon"
                            class="form-control"
                            value="{{ old('telepon', $sekolah->telepon ?? '') }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Website</label>
                        <input type="text" name="website" placeholder="https://..."
                            class="form-control"
                            value="{{ old('website', $sekolah->website ?? '') }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Email</label>
                        <input type="email" name="email"
                            class="form-control"
                            value="{{ old('email', $sekolah->email ?? '') }}">
                        <div class="invalid-feedback" data-error-for="email"></div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

{{-- ===== KEPALA SEKOLAH ===== --}}
<div class="card border-0 shadow-sm mb-3">
    <div class="card-header bg-white py-3">
        <h6 class="mb-0 fw-bold"><i class="bi bi-person-check me-2 text-primary"></i>Kepala Sekolah</h6>
    </div>
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label fw-semibold">Pilih Kepala Sekolah</label>
                <select name="kepala_sekolah_id" id="kepala_sekolah_id" class="form-select">
                    <option value="">— Belum ditentukan —</option>
                    @foreach ($guruList ?? [] as $guru)
                        <option value="{{ $guru->id }}"
                            {{ old('kepala_sekolah_id', $sekolah->kepala_sekolah_id ?? '') == $guru->id ? 'selected' : '' }}>
                            {{ $guru->name }}
                            @if ($guru->email) ({{ $guru->email }}) @endif
                        </option>
                    @endforeach
                </select>
                <div class="form-text">Dipilih dari daftar guru yang aktif.</div>
                <div class="invalid-feedback" data-error-for="kepala_sekolah_id"></div>
            </div>

            {{-- Info kepala yang terpilih --}}
            @if ($isEdit && $sekolah->kepalaSekolah)
            <div class="col-md-6 d-flex align-items-center">
                <div class="alert alert-info mb-0 py-2 px-3 w-100">
                    <i class="bi bi-person-fill me-1"></i>
                    <strong>{{ $sekolah->kepalaSekolah->name }}</strong>
                    <span class="text-muted small ms-1">— saat ini menjabat</span>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

{{-- ===== ALAMAT ===== --}}
<div class="card border-0 shadow-sm mb-3">
    <div class="card-header bg-white py-3">
        <h6 class="mb-0 fw-bold"><i class="bi bi-geo-alt me-2 text-primary"></i>Alamat</h6>
    </div>
    <div class="card-body">
        <div class="row g-3">
            <div class="col-12">
                <label class="form-label fw-semibold">Alamat Sekolah (Lengkap)</label>
                <textarea name="alamat_sekolah" rows="2" class="form-control">{{ old('alamat_sekolah', $sekolah->alamat_sekolah ?? '') }}</textarea>
            </div>
            <div class="col-md-8">
                <label class="form-label fw-semibold">Nama Jalan / Desa</label>
                <input type="text" name="nama_jalan"
                    class="form-control"
                    value="{{ old('nama_jalan', $sekolah->nama_jalan ?? '') }}">
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">Kode Pos</label>
                <input type="text" name="kode_pos"
                    class="form-control"
                    value="{{ old('kode_pos', $sekolah->kode_pos ?? '') }}">
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">Kecamatan</label>
                <input type="text" name="kecamatan"
                    class="form-control"
                    value="{{ old('kecamatan', $sekolah->kecamatan ?? '') }}">
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">Kabupaten / Kota</label>
                <input type="text" name="kab_kota"
                    class="form-control"
                    value="{{ old('kab_kota', $sekolah->kab_kota ?? '') }}">
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">Provinsi</label>
                <input type="text" name="provinsi"
                    class="form-control"
                    value="{{ old('provinsi', $sekolah->provinsi ?? '') }}">
            </div>
        </div>
    </div>
</div>

{{-- ===== ACTIONS ===== --}}
<div class="d-flex gap-2 justify-content-end">
    <a href="{{ route('master.sekolah.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left me-1"></i>Kembali
    </a>
    <button type="submit" id="btn-submit" class="btn btn-primary">
        <span id="btn-submit-text">
            <i class="bi bi-floppy me-1"></i>{{ $isEdit ? 'Simpan Perubahan' : 'Simpan' }}
        </span>
        <span id="btn-submit-spin" class="d-none">
            <span class="spinner-border spinner-border-sm me-1"></span>Menyimpan...
        </span>
    </button>
</div>

@push('scripts')
<script>
// Logo preview
document.getElementById('logo')?.addEventListener('change', function () {
    const file = this.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = (e) => {
        const img = document.getElementById('preview-logo');
        const ph  = document.getElementById('preview-logo-placeholder');
        img.src = e.target.result;
        img.classList.remove('d-none');
        ph?.classList.add('d-none');
    };
    reader.readAsDataURL(file);
});

// AJAX form submit
const form = document.getElementById('sekolah-form');
form?.addEventListener('submit', async function (e) {
    e.preventDefault();

    document.getElementById('btn-submit-text').classList.add('d-none');
    document.getElementById('btn-submit-spin').classList.remove('d-none');
    document.getElementById('btn-submit').disabled = true;

    // clear errors
    document.querySelectorAll('[data-error-for]').forEach(el => el.textContent = '');
    document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
    document.getElementById('form-error-alert').classList.add('d-none');

    const fd = new FormData(form);

    try {
        const res  = await fetch(form.action, { method: 'POST', headers: { 'Accept': 'application/json' }, body: fd });
        const json = await res.json();

        if (res.ok && json.success) {
            showToast(json.message, 'success');
            setTimeout(() => window.location.href = '{{ route("master.sekolah.index") }}', 1200);
            return;
        }

        if (res.status === 422 && json.errors) {
            const list = document.getElementById('form-error-list');
            list.innerHTML = '';
            Object.entries(json.errors).forEach(([field, msgs]) => {
                msgs.forEach(m => {
                    list.insertAdjacentHTML('beforeend', `<li>${m}</li>`);
                });
                const el = document.querySelector(`[data-error-for="${field}"]`);
                if (el) {
                    el.textContent = msgs[0];
                    const input = form.querySelector(`[name="${field}"]`);
                    input?.classList.add('is-invalid');
                }
            });
            document.getElementById('form-error-alert').classList.remove('d-none');
        } else {
            showToast(json.message || 'Terjadi kesalahan.', 'danger');
        }
    } catch {
        showToast('Terjadi kesalahan koneksi.', 'danger');
    } finally {
        document.getElementById('btn-submit-text').classList.remove('d-none');
        document.getElementById('btn-submit-spin').classList.add('d-none');
        document.getElementById('btn-submit').disabled = false;
    }
});

function showToast(msg, type = 'success') {
    const wrap = document.getElementById('toast-wrap') ?? document.body;
    const id   = 'toast-' + Date.now();
    wrap.insertAdjacentHTML('beforeend', `
        <div id="${id}" class="toast align-items-center text-bg-${type} border-0 mb-2" role="alert">
            <div class="d-flex"><div class="toast-body">${msg}</div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button></div>
        </div>`);
    const el = document.getElementById(id);
    new bootstrap.Toast(el, { delay: 3500 }).show();
    el.addEventListener('hidden.bs.toast', () => el.remove());
}
</script>
@endpush
