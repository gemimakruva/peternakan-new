@extends('adminlte::page')

@section('title', 'Detail Monitoring Kesehatan')


@section('content_header')

<div class="card mb-4 d-flex flex-row justify-content-between 
     align-items-center text-center p-3 w-100">

    <div class="d-flex flex-row justify-center p-2 p-md">
        <div class="ms-2 text-start text-md-center">
            <h5 class="fw-bold text-dark mb-1 fs-5 fs-md-4 fs-lg-3">
                Detail Monitoring Kesehatan
            </h5>
            <span class="text-dark fw-semibold d-block fs-6 fs-md-5 fs-lg-4">
                {{ \Carbon\Carbon::parse($monitoringKesehatan->tanggal)
    ->translatedFormat('l, d F Y') }}
            </span>
        </div>
    </div>

    <div class="d-flex align-items-center gap-3">
        {{-- Edit button --}}
        <a href="{{ route('monitoring-kesehatan.edit', $monitoringKesehatan->id) }}" class="text-primary d-flex align-items-center justify-content-center 
                p-2 rounded hover-shadow" title="Edit Pengadaan">
            <i class="bi bi-pencil-square fs-4" style="font-size: 25px"></i>
        </a>
        {{-- Print button --}}
        <a href="#" class="text-success d-flex align-items-center justify-content-center 
                p-2 rounded hover-shadow" title="Print Detail">
            <i class="bi bi-printer fs-5" style="font-size: 25px"></i>
        </a>
    </div>
    <style>
        .hover-shadow:hover {
            background-color: #f1f1f1;
            transition: 0.2s;
        }
    </style>
</div>
@stop


@section('content')
    <div class="card shadow-sm border-0 mb-3">
        <div class="card-header">
            <h5 class="fw-semibold text-dark fs-5 fs-md-4 mb-0 m-2">
                Form Monitoring Kesehatan
            </h5>
        </div>
        <div class="card-body">
            {{-- ================= INFORMASI MONITORING ================= --}}
            <div class="mb-4">
                <h5 class="font-weight-bold">Kandang</h5>
                <p class="mb-3">{{ $monitoringKesehatan->kandang->nama ?? '' }}</p>

                <h5 class="font-weight-bold">Tim Pelaksana</h5>
                <p>{{ $monitoringKesehatan->tim_pelaksana ?? '' }}</p>
            </div>

        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title font-weight-bold">
                I. Data Populasi Ternak
            </h3>
        </div>

        <div class="card-body">

            {{-- 1. Total Populasi --}}
            <div class="mb-4">
                <h6 class="font-weight-bold">
                    1. Total Populasi Ayam
                </h6>
                <p class="ml-3 mb-0">{{ $monitoringKesehatan->total_populasi_ayam ?? '' }}</p>
            </div>

            {{-- 2. Distribusi --}}
            <div class="mb-4">
                <h6 class="font-weight-bold">
                    2. Distribusi Populasi Ayam
                </h6>

                <div class="ml-3">
                    <div class="mb-2">
                        <strong>Ayam Sehat</strong>
                        <div class="ml-3">{{ $monitoringKesehatan->ayam_sehat ?? '' }} ekor</div>
                    </div>

                    <div class="mb-2">
                        <strong>Ayam Sakit</strong>
                        <div class="ml-3">{{ $monitoringKesehatan->ayam_sakit ?? '' }} ekor</div>
                    </div>

                    <div class="mb-2">
                        <strong>Ayam Mait</strong>
                        <div class="ml-3">{{ $monitoringKesehatan->ayam_mati ?? '' }} ekor</div>
                    </div>

                    <div>
                        <strong>Ayam Afkir</strong>
                        <div class="ml-3">{{ $monitoringKesehatan->ayam_afkir ?? '' }} ekor</div>
                    </div>
                </div>
            </div>

            {{-- 3. Penyakit --}}
            <div>
                <h6 class="font-weight-bold">
                    3. Jenis Penyakit yang Ditemukan
                </h6>
                <p class="ml-3 mb-0">
                    {{ $monitoringKesehatan->detail_penyakit_ditemukan ?? '' }}
                </p>
            </div>

        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title font-weight-bold">
                II. Pemeriksaan Umum
            </h3>
        </div>

        <div class="card-body">

            {{-- ================= 1. KONDISI UMUM TERNAK ================= --}}
            <div class="mb-4">
                <h5 class="font-weight-bold mb-3">
                    1. Kondisi Umum Ternak
                </h5>

                <div class="mb-3">
                    <strong>Perilaku</strong>
                    <div class="border rounded p-2 mt-1">
                        {{ $monitoringKesehatan->umum_perilaku ?? '' }}
                    </div>
                </div>

                <div class="mb-3">
                    <strong>Kondisi Bulu</strong>
                    <div class="border rounded p-2 mt-1">
                        {{ $monitoringKesehatan->umum_kondisi_bulu ?? '' }}
                    </div>
                </div>

                <div class="mb-3">
                    <strong>Proporsi Tubuh</strong>
                    <div class="border rounded p-2 mt-1">
                        {{ $monitoringKesehatan->umum_proporsi_tubuh ?? '' }}
                    </div>
                </div>

                <div class="mb-3">
                    <strong>Nafsu Makan</strong>
                    <div class="border rounded p-2 mt-1">
                        {{ $monitoringKesehatan->umum_nafsu_makan ?? '' }}
                    </div>
                </div>

                <div>
                    <strong>Produktivitas Telur</strong>
                    <div class="border rounded p-2 mt-1">
                        {{ $monitoringKesehatan->umum_produktivitas_telur ?? '' }}
                    </div>
                </div>
            </div>

            {{-- ================= 2. KONDISI LINGKUNGAN KANDANG ================= --}}
            <div class="mb-4">
                <h5 class="font-weight-bold mb-3">
                    2. Kondisi Lingkungan Kandang
                </h5>

                <div class="mb-3">
                    <strong>Suhu</strong>
                    <div class="border rounded p-2 mt-1">
                        {{ $monitoringKesehatan->lingkungan_suhu ?? '' }}
                    </div>
                </div>

                <div class="mb-3">
                    <strong>Kelembapan</strong>
                    <div class="border rounded p-2 mt-1">
                        {{ $monitoringKesehatan->lingkungan_kelembapan ?? '' }}
                    </div>
                </div>

                <div>
                    <strong>Kebersihan</strong>
                    <div class="border rounded p-2 mt-1">
                        {{ $monitoringKesehatan->lingkungan_kebersihan ?? '' }}
                    </div>
                </div>
            </div>

            {{-- ================= 3. KONDISI UMUM AYAM ================= --}}
            <div>
                <h5 class="font-weight-bold mb-3">
                    3. Kondisi Umum Ayam
                </h5>

                <div class="border rounded p-3">
                    {{ $monitoringKesehatan->detail_kondisi_umum ?? '' }}
                </div>
            </div>

        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title font-weight-bold">
                III. Nekropsi
            </h3>
        </div>

        <div class="card-body">

            {{-- 1. Jumlah ternak --}}
            <div class="mb-4">
                <h5 class="font-weight-bold">
                    1. Jumlah ternak yang di-nekropsi (bedah)
                </h5>
                <p class="ml-3 mb-0">{{ $monitoringKesehatan->nekropsi_jumlah_ayam ?? 0 }} Ekor</p>
            </div>

            {{-- 2. Temuan Nekropsi --}}
            <div>
                <h5 class="font-weight-bold mb-3">
                    2. Temuan Nekropsi
                </h5>

                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="thead-light">
                            <tr>
                                <th style="width: 30%">Gambar</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($monitoringKesehatan->nekropsi as $nekropsi)
                                <tr>
                                    <td class="text-center">
                                        <img src="{{ Storage::url($nekropsi->path) }}" alt="Nekropsi" class="img-fluid"
                                            style="max-height: 150px;">
                                    </td>
                                    <td>{!! $nekropsi->keterangan !!}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>

        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title font-weight-bold">
                IV. Tindakan Penanganan dan Rekomendasi
            </h3>
        </div>

        <div class="card-body">

            {{-- 1. Pengobatan --}}
            <div class="mb-4">
                <h5 class="font-weight-bold">
                    1. Pengobatan yang dilakukan
                </h5>
                <div class="border rounded p-3">
                    {{ $monitoringKesehatan->tindakan_pengobatan ?? '' }}
                </div>
            </div>

            {{-- 2. Rekomendasi jangka pendek --}}
            <div class="mb-4">
                <h5 class="font-weight-bold">
                    2. Rekomendasi jangka pendek
                </h5>
                <div class="border rounded p-3">
                    {{ $monitoringKesehatan->tindakan_rekomendasi_jangka_pendek ?? '' }}
                </div>
            </div>

            {{-- 3. Rekomendasi jangka panjang --}}
            <div>
                <h5 class="font-weight-bold">
                    3. Rekomendasi jangka panjang
                </h5>
                <div class="border rounded p-3">
                    {{ $monitoringKesehatan->tindakan_rekomendasi_jangka_panjang ?? '' }}
                </div>
            </div>

        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title font-weight-bold">
                V. Evaluasi dan Catatan Tambahan
            </h3>
        </div>

        <div class="card-body">

            <div class="mb-4">
                <h5 class="font-weight-bold">1. Efektivitas Pengobatan</h5>
                <div class="border rounded p-3">
                    {{ $monitoringKesehatan->evaluasi_efektivitas_pengobatan ?? '' }}
                </div>
            </div>

            <div>
                <h5 class="font-weight-bold">2. Catatan Khusus</h5>
                <div class="border rounded p-3">
                    {{ $monitoringKesehatan->evaluasi_catatan ?? '' }}
                </div>
            </div>

        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title font-weight-bold">
                VI. Dokumentasi Pendukung
            </h3>
        </div>

        <div class="card-body">
            <div class="row">
                @foreach ($monitoringKesehatan->dokumentasi as $dokumentasi)
                    <div class="col-md-4 text-center mb-3">
                        <img src="{{ Storage::url($dokumentasi) }}" class="img-fluid rounded border" alt="Dokumentasi">
                    </div>
                @endforeach
            </div>

        </div>
    </div>
@endsection