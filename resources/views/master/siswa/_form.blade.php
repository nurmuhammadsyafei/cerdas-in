{{-- ===== _form.blade.php (digunakan oleh create & edit) ===== --}}
@php
    use Illuminate\Support\Facades\Storage;
    $isEdit = isset($siswa) && $siswa !== null;
@endphp

{{-- Error global (AJAX) --}}
<div id="form-error-alert" class="alert alert-danger py-2 mb-3 d-none">
    <ul id="form-error-list" class="mb-0 ps-3"></ul>
</div>

{{-- ===== IDENTITAS SISWA ===== --}}
<div class="card border-0 shadow-sm mb-3">
    <div class="card-header bg-white py-3">
        <h6 class="mb-0 fw-bold"><i class="bi bi-person-badge me-2 text-primary"></i>Identitas Siswa</h6>
    </div>
    <div class="card-body">
        <div class="row g-3">

            {{-- Foto --}}
            <div class="col-12 col-md-3 text-center">
                <div class="mb-2">
                    @if($isEdit && $siswa->foto)
                        <img id="preview-foto" src="{{ Storage::url($siswa->foto) }}"
                            class="rounded border" style="width:120px;height:150px;object-fit:cover;">
                    @else
                        <div id="preview-foto-placeholder" class="rounded border bg-light d-flex align-items-center
                            justify-content-center mx-auto" style="width:120px;height:150px;">
                            <i class="bi bi-person fs-1 text-secondary"></i>
                        </div>
                        <img id="preview-foto" src="#" class="rounded border d-none"
                            style="width:120px;height:150px;object-fit:cover;">
                    @endif
                </div>
                <label class="form-label small fw-semibold">Foto (3×4)</label>
                <input type="file" name="foto" id="foto"
                    class="form-control form-control-sm"
                    accept="image/jpg,image/jpeg,image/png">
                <div class="form-text">Maks. 2MB · JPG/PNG</div>
                <div class="invalid-feedback d-block small text-danger" data-error-for="foto"></div>
            </div>

            <div class="col-12 col-md-9">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" name="nama_lengkap" id="nama_lengkap"
                            class="form-control"
                            value="{{ old('nama_lengkap', $siswa->nama_lengkap ?? '') }}" required>
                        <div class="invalid-feedback" data-error-for="nama_lengkap"></div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Nama Panggilan</label>
                        <input type="text" name="nama_panggilan"
                            class="form-control"
                            value="{{ old('nama_panggilan', $siswa->nama_panggilan ?? '') }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">NISN</label>
                        <input type="text" name="nisn"
                            class="form-control"
                            value="{{ old('nisn', $siswa->nisn ?? '') }}">
                        <div class="invalid-feedback" data-error-for="nisn"></div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">NIS</label>
                        <input type="text" name="nis"
                            class="form-control"
                            value="{{ old('nis', $siswa->nis ?? '') }}">
                        <div class="invalid-feedback" data-error-for="nis"></div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Jenis Kelamin <span class="text-danger">*</span></label>
                        <select name="jenis_kelamin" class="form-select" required>
                            <option value="">-- Pilih --</option>
                            <option value="L" {{ old('jenis_kelamin', $siswa->jenis_kelamin ?? '') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="P" {{ old('jenis_kelamin', $siswa->jenis_kelamin ?? '') == 'P' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                        <div class="invalid-feedback" data-error-for="jenis_kelamin"></div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Agama</label>
                        <select name="agama" class="form-select">
                            <option value="">-- Pilih --</option>
                            @foreach(['Islam','Kristen','Katolik','Hindu','Buddha','Konghucu'] as $ag)
                                <option value="{{ $ag }}" {{ old('agama', $siswa->agama ?? '') == $ag ? 'selected' : '' }}>{{ $ag }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Anak Ke-</label>
                        <input type="number" name="anak_ke" min="1"
                            class="form-control"
                            value="{{ old('anak_ke', $siswa->anak_ke ?? '') }}">
                    </div>
                </div>
            </div>

            {{-- TTL --}}
            <div class="col-md-4">
                <label class="form-label fw-semibold">Tempat Lahir</label>
                <input type="text" name="tempat_lahir"
                    class="form-control"
                    value="{{ old('tempat_lahir', $siswa->tempat_lahir ?? '') }}">
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">Tanggal Lahir</label>
                <input type="date" name="tanggal_lahir"
                    class="form-control"
                    value="{{ old('tanggal_lahir', isset($siswa->tanggal_lahir) ? \Carbon\Carbon::parse($siswa->tanggal_lahir)->format('Y-m-d') : '') }}">
            </div>
            <div class="col-md-2">
                <label class="form-label fw-semibold">BB (Kg)</label>
                <input type="number" step="0.1" name="bb"
                    class="form-control"
                    value="{{ old('bb', $siswa->bb ?? '') }}">
            </div>
            <div class="col-md-2">
                <label class="form-label fw-semibold">TB (cm)</label>
                <input type="number" step="0.1" name="tb"
                    class="form-control"
                    value="{{ old('tb', $siswa->tb ?? '') }}">
            </div>

            {{-- Alamat peserta didik --}}
            <div class="col-12">
                <label class="form-label fw-semibold">Alamat Peserta Didik</label>
                <textarea name="alamat_peserta_didik" rows="2"
                    class="form-control">{{ old('alamat_peserta_didik', $siswa->alamat_peserta_didik ?? '') }}</textarea>
            </div>
        </div>
    </div>
</div>

{{-- ===== DATA ORANG TUA ===== --}}
<div class="card border-0 shadow-sm mb-3">
    <div class="card-header bg-white py-3">
        <h6 class="mb-0 fw-bold"><i class="bi bi-people me-2 text-success"></i>Data Orang Tua</h6>
    </div>
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-4">
                <label class="form-label fw-semibold">Nama Ayah</label>
                <input type="text" name="nama_ayah" class="form-control"
                    value="{{ old('nama_ayah', $siswa->nama_ayah ?? '') }}">
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">Nama Ibu</label>
                <input type="text" name="nama_ibu" class="form-control"
                    value="{{ old('nama_ibu', $siswa->nama_ibu ?? '') }}">
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">No. HP Orang Tua</label>
                <input type="text" name="no_hp_ortu" class="form-control"
                    value="{{ old('no_hp_ortu', $siswa->no_hp_ortu ?? '') }}">
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Pekerjaan Ayah</label>
                <input type="text" name="pekerjaan_ayah" class="form-control"
                    value="{{ old('pekerjaan_ayah', $siswa->pekerjaan_ayah ?? '') }}">
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Pekerjaan Ibu</label>
                <input type="text" name="pekerjaan_ibu" class="form-control"
                    value="{{ old('pekerjaan_ibu', $siswa->pekerjaan_ibu ?? '') }}">
            </div>
        </div>
    </div>
</div>

{{-- ===== ALAMAT ===== --}}
<div class="card border-0 shadow-sm mb-3">
    <div class="card-header bg-white py-3">
        <h6 class="mb-0 fw-bold"><i class="bi bi-geo-alt me-2 text-danger"></i>Alamat</h6>
    </div>
    <div class="card-body">
        <div class="row g-3">
            <div class="col-12">
                <label class="form-label fw-semibold">Alamat</label>
                <textarea name="alamat" rows="2" class="form-control">{{ old('alamat', $siswa->alamat ?? '') }}</textarea>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold">Kode Pos</label>
                <input type="text" name="kode_pos" class="form-control"
                    value="{{ old('kode_pos', $siswa->kode_pos ?? '') }}">
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold">Kecamatan</label>
                <input type="text" name="kecamatan" class="form-control"
                    value="{{ old('kecamatan', $siswa->kecamatan ?? '') }}">
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold">Kab/Kota</label>
                <input type="text" name="kab_kota" class="form-control"
                    value="{{ old('kab_kota', $siswa->kab_kota ?? '') }}">
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold">Provinsi</label>
                <input type="text" name="provinsi" class="form-control"
                    value="{{ old('provinsi', $siswa->provinsi ?? '') }}">
            </div>
        </div>
    </div>
</div>

{{-- ===== TOMBOL ===== --}}
<div class="d-flex gap-2 justify-content-end mb-4">
    <a href="{{ route('master.siswa.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left me-1"></i> Batal
    </a>
    <button type="submit" id="btn-submit" class="btn btn-primary">
        <i class="bi bi-save me-1"></i> {{ $isEdit ? 'Simpan Perubahan' : 'Simpan' }}
    </button>
</div>

@push('scripts')
<script>
(function () {
    const CSRF        = document.querySelector('meta[name="csrf-token"]').content;
    const INDEX_URL   = '{{ route("master.siswa.index") }}';
    const form        = document.getElementById('siswa-form');
    const btnSubmit   = document.getElementById('btn-submit');
    const btnOrigText = btnSubmit.innerHTML;

    /* ── Preview foto ── */
    document.getElementById('foto').addEventListener('change', function (e) {
        const file = e.target.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = function (ev) {
            const img         = document.getElementById('preview-foto');
            const placeholder = document.getElementById('preview-foto-placeholder');
            img.src = ev.target.result;
            img.classList.remove('d-none');
            if (placeholder) placeholder.classList.add('d-none');
        };
        reader.readAsDataURL(file);
    });

    /* ── AJAX submit ── */
    form.addEventListener('submit', function (e) {
        e.preventDefault();
        clearErrors();

        btnSubmit.disabled  = true;
        btnSubmit.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span>Menyimpan...';

        fetch(form.action, {
            method:  'POST',
            headers: {
                'Accept':           'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN':     CSRF,
            },
            body: new FormData(form),
        })
        .then(r => r.json().then(data => ({ ok: r.ok, status: r.status, data })))
        .then(({ ok, status, data }) => {
            if (ok) {
                window.location.href = INDEX_URL;
            } else if (status === 422 && data.errors) {
                showErrors(data.errors);
                btnSubmit.disabled  = false;
                btnSubmit.innerHTML = btnOrigText;
            } else {
                alert(data.message || 'Terjadi kesalahan. Silakan coba lagi.');
                btnSubmit.disabled  = false;
                btnSubmit.innerHTML = btnOrigText;
            }
        })
        .catch(() => {
            alert('Terjadi kesalahan koneksi.');
            btnSubmit.disabled  = false;
            btnSubmit.innerHTML = btnOrigText;
        });
    });

    /* ── Error helpers ── */
    function showErrors(errors) {
        const list = document.getElementById('form-error-list');
        const alert = document.getElementById('form-error-alert');
        list.innerHTML = '';
        Object.entries(errors).forEach(([field, messages]) => {
            // inline error
            const errDiv = document.querySelector(`[data-error-for="${field}"]`);
            if (errDiv) {
                errDiv.textContent = messages[0];
                errDiv.style.display = 'block';
                const input = form.querySelector(`[name="${field}"]`);
                if (input) input.classList.add('is-invalid');
            }
            // global list
            const li = document.createElement('li');
            li.className = 'small';
            li.textContent = messages[0];
            list.appendChild(li);
        });
        alert.classList.remove('d-none');
        alert.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }

    function clearErrors() {
        document.querySelectorAll('[data-error-for]').forEach(el => {
            el.textContent   = '';
            el.style.display = '';
        });
        form.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
        document.getElementById('form-error-alert').classList.add('d-none');
        document.getElementById('form-error-list').innerHTML = '';
    }
})();
</script>
@endpush
