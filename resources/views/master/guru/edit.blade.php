@extends('layouts.app')

@section('title', 'Edit Penempatan Guru')
@section('page-title', 'Edit Penempatan Guru')

@section('content')
<div class="container-fluid">

    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="bi bi-house-door"></i></a></li>
            <li class="breadcrumb-item"><a href="{{ route('master.guru.index') }}">Data Guru</a></li>
            <li class="breadcrumb-item active">Edit — {{ $user->name }}</li>
        </ol>
    </nav>

    <div id="toast-wrap" class="position-fixed top-0 end-0 p-3" style="z-index:1100"></div>

    @php
        $gs = $user->guruSekolah;
    @endphp

    <div id="form-error-alert" class="alert alert-danger py-2 mb-3 d-none">
        <ul id="form-error-list" class="mb-0 ps-3"></ul>
    </div>

    <form id="guru-form"
          action="{{ route('api.master.guru.update', $user) }}"
          method="POST"
          enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="_method" value="PUT">

        <div class="row g-3">

            {{-- ── Foto Guru ── --}}
            <div class="col-12 col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white py-3">
                        <h6 class="mb-0 fw-bold"><i class="bi bi-person-circle me-2 text-primary"></i>Foto Guru</h6>
                    </div>
                    <div class="card-body text-center">
                        @if($gs && $gs->foto)
                            <img id="preview-foto" src="{{ \Illuminate\Support\Facades\Storage::url($gs->foto) }}"
                                class="rounded border mb-2" style="width:130px;height:160px;object-fit:cover;">
                        @else
                            <div id="preview-foto-placeholder" class="rounded border bg-light d-flex align-items-center
                                justify-content-center mx-auto mb-2" style="width:130px;height:160px;">
                                <i class="bi bi-person fs-1 text-secondary"></i>
                            </div>
                            <img id="preview-foto" src="#" class="rounded border mb-2 d-none"
                                style="width:130px;height:160px;object-fit:cover;">
                        @endif
                        <div class="mt-2">
                            <label class="form-label small fw-semibold d-block">Upload Foto (3×4)</label>
                            <input type="file" name="foto" id="foto"
                                class="form-control form-control-sm"
                                accept="image/jpg,image/jpeg,image/png">
                            <div class="form-text">Maks. 2MB · JPG/PNG</div>
                            <div class="small text-danger" data-error-for="foto"></div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ── Info Guru + Penempatan ── --}}
            <div class="col-12 col-md-9">

                {{-- Info Akun (readonly) --}}
                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-header bg-white py-3">
                        <h6 class="mb-0 fw-bold"><i class="bi bi-person-badge me-2 text-primary"></i>Informasi Guru</h6>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Nama Lengkap</label>
                                <input type="text" class="form-control" value="{{ $user->name }}" disabled>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Email</label>
                                <input type="email" class="form-control" value="{{ $user->email }}" disabled>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Status</label>
                                <div class="form-control-plaintext">
                                    @if($user->is_active)
                                        <span class="badge bg-success">Aktif</span>
                                    @else
                                        <span class="badge bg-secondary">Nonaktif</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Penempatan Sekolah --}}
                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-header bg-white py-3">
                        <h6 class="mb-0 fw-bold"><i class="bi bi-building me-2 text-primary"></i>Penempatan Sekolah</h6>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label fw-semibold">Sekolah Penempatan</label>
                                <select name="sekolah_id" id="sekolah_id" class="form-select">
                                    <option value="">— Belum ditetapkan —</option>
                                    @foreach($sekolahList as $skl)
                                        <option value="{{ $skl->id }}"
                                            {{ ($gs?->sekolah_id == $skl->id) ? 'selected' : '' }}>
                                            {{ $skl->nama_sekolah }}
                                            @if($skl->kab_kota) ({{ $skl->kab_kota }}) @endif
                                        </option>
                                    @endforeach
                                </select>
                                <div class="form-text">Pilih sekolah tempat guru ini bertugas.</div>
                                <div class="small text-danger" data-error-for="sekolah_id"></div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Actions --}}
                <div class="d-flex gap-2 justify-content-end">
                    <a href="{{ route('master.guru.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left me-1"></i>Kembali
                    </a>
                    <button type="submit" id="btn-submit" class="btn btn-primary">
                        <span id="btn-submit-text"><i class="bi bi-floppy me-1"></i>Simpan Perubahan</span>
                        <span id="btn-submit-spin" class="d-none">
                            <span class="spinner-border spinner-border-sm me-1"></span>Menyimpan...
                        </span>
                    </button>
                </div>

            </div>
        </div>
    </form>

</div>
@endsection

@push('scripts')
<script>
document.getElementById('foto')?.addEventListener('change', function () {
    const file = this.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = (e) => {
        const img = document.getElementById('preview-foto');
        const ph  = document.getElementById('preview-foto-placeholder');
        img.src = e.target.result;
        img.classList.remove('d-none');
        ph?.classList.add('d-none');
    };
    reader.readAsDataURL(file);
});

document.getElementById('guru-form')?.addEventListener('submit', async function (e) {
    e.preventDefault();

    document.getElementById('btn-submit-text').classList.add('d-none');
    document.getElementById('btn-submit-spin').classList.remove('d-none');
    document.getElementById('btn-submit').disabled = true;

    document.querySelectorAll('[data-error-for]').forEach(el => el.textContent = '');
    document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
    document.getElementById('form-error-alert').classList.add('d-none');

    try {
        const res  = await fetch(this.action, {
            method: 'POST',
            headers: { 'Accept': 'application/json' },
            body: new FormData(this)
        });
        const json = await res.json();

        if (res.ok && json.success) {
            showToast(json.message, 'success');
            setTimeout(() => window.location.href = '{{ route("master.guru.index") }}', 1200);
            return;
        }

        if (res.status === 422 && json.errors) {
            const list = document.getElementById('form-error-list');
            list.innerHTML = '';
            Object.entries(json.errors).forEach(([field, msgs]) => {
                msgs.forEach(m => { list.insertAdjacentHTML('beforeend', `<li>${m}</li>`); });
                const el = document.querySelector(`[data-error-for="${field}"]`);
                if (el) {
                    el.textContent = msgs[0];
                    this.querySelector(`[name="${field}"]`)?.classList.add('is-invalid');
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
    const wrap = document.getElementById('toast-wrap');
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
