<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Identitas Peserta Didik - {{ $siswa->nama_lengkap }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 11pt;
            color: #222;
            background: #fff;
        }

        /* ── Header ── */
        .header-top {
            background-color: #1a7a6e;
            height: 14px;
            width: 100%;
        }
        .header-body {
            padding: 10px 24px 8px;
            text-align: center;
            border-bottom: 3px solid #1a7a6e;
        }
        .logo-wrap {
            display: inline-block;
            width: 72px;
            height: 72px;
            border-radius: 50%;
            overflow: hidden;
            border: 3px solid #1a7a6e;
            margin-bottom: 6px;
        }
        .logo-wrap img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .logo-placeholder {
            width: 72px;
            height: 72px;
            border-radius: 50%;
            border: 3px solid #1a7a6e;
            background-color: #e8f5f3;
            display: inline-block;
            margin-bottom: 6px;
            text-align: center;
            line-height: 66px;
            font-size: 28pt;
            color: #1a7a6e;
        }
        .school-name {
            font-size: 13pt;
            font-weight: bold;
            color: #1a7a6e;
            letter-spacing: 0.5px;
        }
        .school-address {
            font-size: 9pt;
            color: #555;
            margin-top: 2px;
        }

        /* ── Title ── */
        .doc-title {
            text-align: center;
            font-size: 14pt;
            font-weight: bold;
            color: #1a7a6e;
            letter-spacing: 2px;
            margin: 16px 0 14px;
            text-transform: uppercase;
        }
        .doc-title-underline {
            width: 200px;
            height: 2px;
            background: #1a7a6e;
            margin: 4px auto 0;
        }

        /* ── Content table ── */
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin: 0 0 8px;
            padding: 0 4px;
        }
        .info-table td {
            padding: 4px 6px;
            vertical-align: top;
            line-height: 1.5;
        }
        .col-no {
            width: 28px;
            color: #1a7a6e;
            font-weight: bold;
            text-align: right;
        }
        .col-label {
            width: 200px;
            color: #1a7a6e;
            font-weight: bold;
        }
        .col-sep {
            width: 14px;
            text-align: center;
            color: #1a7a6e;
            font-weight: bold;
        }
        .col-value {
            color: #222;
        }
        /* sub-items */
        .sub-table {
            width: 100%;
            border-collapse: collapse;
        }
        .sub-table td {
            padding: 1px 0;
            vertical-align: top;
        }
        .sub-label {
            width: 180px;
            color: #444;
            padding-left: 4px;
        }
        .sub-sep {
            width: 14px;
            text-align: center;
            color: #444;
        }
        .sub-value {
            color: #222;
        }

        /* row shading */
        .row-shade {
            background-color: #f0faf8;
        }

        /* ── Photo ── */
        .photo-cell {
            width: 90px;
            text-align: center;
            vertical-align: top;
            padding: 4px;
        }
        .photo-cell img {
            width: 80px;
            height: 100px;
            object-fit: cover;
            border: 2px solid #1a7a6e;
            border-radius: 4px;
        }
        .photo-placeholder {
            width: 80px;
            height: 100px;
            border: 2px dashed #aaa;
            border-radius: 4px;
            background: #f5f5f5;
            display: inline-block;
            line-height: 100px;
            text-align: center;
            color: #aaa;
            font-size: 9pt;
        }

        /* ── Footer ── */
        .footer-line {
            border-top: 2px solid #1a7a6e;
            margin-top: 20px;
        }
        .footer-body {
            padding: 10px 24px 0;
            overflow: hidden; /* clearfix */
        }
        .footer-right {
            float: right;
            text-align: center;
            width: 220px;
        }
        .footer-left {
            float: left;
            width: 60%;
        }
        .sign-space {
            height: 50px;
        }
        .sign-name {
            border-top: 1px solid #222;
            padding-top: 2px;
            font-weight: bold;
            font-size: 10pt;
        }
        .sign-nip {
            font-size: 9pt;
            color: #555;
        }

        /* ── Outer wrapper ── */
        .page-wrap {
            padding: 0 24px 16px;
        }

        /* photo + info side by side */
        .top-content {
            width: 100%;
            border-collapse: collapse;
        }
        .top-content > tbody > tr > td {
            vertical-align: top;
        }
    </style>
</head>
<body>

    {{-- Header top bar --}}
    <div class="header-top"></div>

    {{-- School header --}}
    <div class="header-body">
        @php
            $logoPath = public_path('images/logo-sekolah.png');
        @endphp
        @if(file_exists($logoPath))
            <div class="logo-wrap">
                <img src="{{ $logoPath }}" alt="Logo Sekolah">
            </div>
        @else
            <div class="logo-placeholder">&#127979;</div>
        @endif
        <div class="school-name">{{ config('app.school_name', 'TK Yaspen Hindoli 01') }}</div>
        <div class="school-address">{{ config('app.school_address', 'Sungai Lilin, Musi Banyuasin, Sumatera Selatan') }}</div>
    </div>

    {{-- Document title --}}
    <div class="doc-title">
        Identitas Peserta Didik
        <div class="doc-title-underline"></div>
    </div>

    <div class="page-wrap">

        {{-- Photo + info row --}}
        <table class="top-content">
            <tbody>
                <tr>
                    <td style="width:90px; padding-right:12px; vertical-align:top; padding-top:2px;">
                        @php
                            $fotoPath = $siswa->foto ? public_path('storage/' . $siswa->foto) : null;
                        @endphp
                        @if($fotoPath && file_exists($fotoPath))
                            <img src="{{ $fotoPath }}" style="width:80px;height:100px;object-fit:cover;border:2px solid #1a7a6e;border-radius:4px;">
                        @else
                            <div class="photo-placeholder">Foto</div>
                        @endif
                    </td>
                    <td style="vertical-align:top;">

                        <table class="info-table">
                            <tbody>

                                {{-- 1. Nama --}}
                                <tr>
                                    <td class="col-no">1.</td>
                                    <td class="col-label">Nama Peserta Didik</td>
                                    <td class="col-sep">:</td>
                                    <td class="col-value">
                                        <strong>{{ strtoupper($siswa->nama_lengkap) }}</strong>
                                        @if($siswa->nama_panggilan)
                                            <br>
                                            <table class="sub-table"><tbody><tr>
                                                <td class="sub-label">Nama Panggilan</td>
                                                <td class="sub-sep">:</td>
                                                <td class="sub-value">{{ $siswa->nama_panggilan }}</td>
                                            </tr></tbody></table>
                                        @endif
                                    </td>
                                </tr>

                                {{-- 2. NISN/NIS --}}
                                <tr class="row-shade">
                                    <td class="col-no">2.</td>
                                    <td class="col-label">NISN / NIS</td>
                                    <td class="col-sep">:</td>
                                    <td class="col-value">{{ $siswa->nisn ?? '-' }} / {{ $siswa->nis ?? '-' }}</td>
                                </tr>

                                {{-- 3. Jenis Kelamin --}}
                                <tr>
                                    <td class="col-no">3.</td>
                                    <td class="col-label">Jenis Kelamin</td>
                                    <td class="col-sep">:</td>
                                    <td class="col-value">{{ $siswa->jenis_kelamin ?? '-' }}</td>
                                </tr>

                                {{-- 4. TTL --}}
                                <tr class="row-shade">
                                    <td class="col-no">4.</td>
                                    <td class="col-label">Tempat, Tanggal Lahir</td>
                                    <td class="col-sep">:</td>
                                    <td class="col-value">
                                        {{ $siswa->tempat_lahir ?? '-' }},
                                        {{ $siswa->tanggal_lahir
                                            ? \Carbon\Carbon::parse($siswa->tanggal_lahir)->locale('id')->translatedFormat('j F Y')
                                            : '-' }}
                                    </td>
                                </tr>

                                {{-- 5. Agama --}}
                                <tr>
                                    <td class="col-no">5.</td>
                                    <td class="col-label">Agama</td>
                                    <td class="col-sep">:</td>
                                    <td class="col-value">{{ $siswa->agama ?? '-' }}</td>
                                </tr>

                                {{-- 6. Anak ke --}}
                                <tr class="row-shade">
                                    <td class="col-no">6.</td>
                                    <td class="col-label">Anak Ke</td>
                                    <td class="col-sep">:</td>
                                    <td class="col-value">{{ $siswa->anak_ke ?? '-' }}</td>
                                </tr>

                                {{-- 7. Alamat Peserta Didik --}}
                                <tr>
                                    <td class="col-no">7.</td>
                                    <td class="col-label">Alamat Peserta Didik</td>
                                    <td class="col-sep">:</td>
                                    <td class="col-value">{{ $siswa->alamat_peserta_didik ?? '-' }}</td>
                                </tr>

                                {{-- 8. Orang Tua/Wali --}}
                                <tr class="row-shade">
                                    <td class="col-no">8.</td>
                                    <td class="col-label">Orang Tua / Wali</td>
                                    <td class="col-sep">:</td>
                                    <td class="col-value">
                                        <table class="sub-table"><tbody>
                                            <tr>
                                                <td class="sub-label">Nama Ayah</td>
                                                <td class="sub-sep">:</td>
                                                <td class="sub-value">{{ $siswa->nama_ayah ?? '-' }}</td>
                                            </tr>
                                            <tr>
                                                <td class="sub-label">Nama Ibu</td>
                                                <td class="sub-sep">:</td>
                                                <td class="sub-value">{{ $siswa->nama_ibu ?? '-' }}</td>
                                            </tr>
                                            <tr>
                                                <td class="sub-label">Nomor HP</td>
                                                <td class="sub-sep">:</td>
                                                <td class="sub-value">{{ $siswa->no_hp_ortu ?? '-' }}</td>
                                            </tr>
                                        </tbody></table>
                                    </td>
                                </tr>

                                {{-- 9. Pekerjaan Orang Tua --}}
                                <tr>
                                    <td class="col-no">9.</td>
                                    <td class="col-label">Pekerjaan Orang Tua / Wali</td>
                                    <td class="col-sep">:</td>
                                    <td class="col-value">
                                        <table class="sub-table"><tbody>
                                            <tr>
                                                <td class="sub-label">Ayah</td>
                                                <td class="sub-sep">:</td>
                                                <td class="sub-value">{{ $siswa->pekerjaan_ayah ?? '-' }}</td>
                                            </tr>
                                            <tr>
                                                <td class="sub-label">Ibu</td>
                                                <td class="sub-sep">:</td>
                                                <td class="sub-value">{{ $siswa->pekerjaan_ibu ?? '-' }}</td>
                                            </tr>
                                        </tbody></table>
                                    </td>
                                </tr>

                                {{-- 10. Alamat Orang Tua --}}
                                <tr class="row-shade">
                                    <td class="col-no">10.</td>
                                    <td class="col-label">Alamat Orang Tua / Wali</td>
                                    <td class="col-sep">:</td>
                                    <td class="col-value">
                                        <table class="sub-table"><tbody>
                                            <tr>
                                                <td class="sub-label">Nama Jalan / Desa</td>
                                                <td class="sub-sep">:</td>
                                                <td class="sub-value">{{ $siswa->alamat ?? '-' }}</td>
                                            </tr>
                                            <tr>
                                                <td class="sub-label">Kode Pos</td>
                                                <td class="sub-sep">:</td>
                                                <td class="sub-value">{{ $siswa->kode_pos ?? '-' }}</td>
                                            </tr>
                                            <tr>
                                                <td class="sub-label">Kecamatan</td>
                                                <td class="sub-sep">:</td>
                                                <td class="sub-value">{{ $siswa->kecamatan ?? '-' }}</td>
                                            </tr>
                                            <tr>
                                                <td class="sub-label">Kabupaten / Kota</td>
                                                <td class="sub-sep">:</td>
                                                <td class="sub-value">{{ $siswa->kab_kota ?? '-' }}</td>
                                            </tr>
                                            <tr>
                                                <td class="sub-label">Provinsi</td>
                                                <td class="sub-sep">:</td>
                                                <td class="sub-value">{{ $siswa->provinsi ?? '-' }}</td>
                                            </tr>
                                        </tbody></table>
                                    </td>
                                </tr>

                            </tbody>
                        </table>

                    </td>
                </tr>
            </tbody>
        </table>

    </div>{{-- end page-wrap --}}

    {{-- Footer --}}
    <div class="footer-line"></div>
    <div class="footer-body">
        <div class="footer-right">
            <p>{{ config('app.school_city', 'Sungai Lilin') }}, {{ \Carbon\Carbon::now()->locale('id')->translatedFormat('j F Y') }}</p>
            <p>Kepala Sekolah</p>
            <p>{{ config('app.school_name', 'TK Yaspen Hindoli 01') }}</p>
            <div class="sign-space"></div>
            <div class="sign-name">{{ config('app.principal_name', 'Sri Heryanti, S.Pd.Gr') }}</div>
            <div class="sign-nip">NIP. {{ config('app.principal_nip', '-') }}</div>
        </div>
    </div>

</body>
</html>
