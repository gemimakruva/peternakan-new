@extends('layouts.dashboard')

@section('title', 'Recording Harian')

@section('content_header')
<div class="mb-4 text-center d-flex flex-column align-items-center">
    <h2 class="h4 fw-bold text-dark">Form Ayam Afkir</h2>
    <span class="text-muted mb-0" style="max-width: 600px;">
       Halaman ini digunakan pendataan penjualan ayam afkir
    </span>
</div>
@endsection

@section('content')
<div>
        <div style="max-width: 1200px" class="row justify-content-center px-3">
            {{-- Form Content --}}
            <div class="col-md-8">
            <form action="{{ route('ayam-afkir.store') }}" method="POST">
                @csrf
                    @include('kandang::ayam-afkir._form')
                    {{-- Button Submit --}}
                    <div class="mt-4 d-flex justify-content-between px-3">
                        <a href="" class="btn btn-secondary px-4 py-2">
                            <i class="fas fa-arrow-left me-2"></i> Kembali
                        </a>
                        <button id="btnSubmitPopulasi" type="submit"
                            class="btn btn-success px-4 py-2 shadow-sm">
                            <i class="fas fa-save me-2"></i> Simpan
                        </button>
                    </div>
                </form>
            </div>

        {{-- Petunjuk Form --}}
            <div class="col-md-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-light">
                        <h5 class="m-0 fw-semibold text-secondary">
                            <i class="fas fa-info-circle me-2"></i> Informasi Pengadaan Ayam
                        </h5>
                    </div>

                    <div class="card-body">
                        <p class="text-muted mb-3">
                            Pastikan mengisi data pengadaan ayam dengan benar sesuai petunjuk berikut:
                        </p>

                        <ul class="small text-muted ps-3">
                            <li>
                                <strong>Tanggal Pengadaan</strong><br>
                                Masukkan tanggal pengadaan ayam saat ayam dari supplier datang ke kandang.
                            </li>

                            <li class="mt-2">
                                <strong>Jumlah Ayam Datang</strong><br>
                                Masukkan jumlah keseluruhan ayam yang datang, termasuk ayam sehat, sakit, maupun mati.
                            </li>

                            <li class="mt-2">
                                <strong>Umur Ayam</strong><br>
                                Masukkan rata-rata umur ayam saat datang dalam format minggu.
                            </li>

                            <li class="mt-2">
                                <strong>Jumlah Ayam Sakit</strong><br>
                                Catat jumlah ayam yang sakit saat proses pengadaan.
                            </li>

                            <li class="mt-2">
                                <strong>Jumlah Ayam Mati</strong><br>
                                Catat jumlah ayam yang mati saat proses pengadaan.
                            </li>

                            <li class="mt-2">
                                <strong>Form Berkas Supplier</strong><br>
                                - Masukkan nama atau jenis berkas sesuai dokumen dari supplier.<br>
                                - Unggah file dokumen berupa PNG, JPG, atau PDF (disarankan JPG).
                            </li>

                            <li class="mt-2">
                                <strong>Upload Dokumentasi</strong><br>
                                Unggah bukti dokumentasi proses pengadaan ayam (bisa lebih dari 1 foto).
                            </li>
                        </ul>

                        <hr>

                        <p class="text-muted small">
                            Jika dropdown tidak muncul atau pipe tidak tergenerate, pastikan Anda sudah menambahkan:
                        </p>
                        <ul class="small text-muted ps-3">
                            <li>Data Peternakan</li>
                            <li>Data Kandang</li>
                            <li>Data Strain</li>
                        </ul>
                    </div>
                </div>
            </div>

    </div>
</div>
@endsection