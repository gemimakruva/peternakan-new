@extends('adminlte::page')

@section('title', 'Transaksi Ayam Karantina')

@section('content_header')
<div class="mb-4 text-center d-flex flex-column align-items-center">
    <h2 class="h4 fw-bold text-dark">Form Ayam karantina</h2>
    <span class="text-muted mb-0" style="max-width: 600px;">
        Halaman ini digunakan Mencatat Populasi dan detail ayam karantina
    </span>
</div>
@endsection


@section('content')
<div>
        <div style="max-width: 1200px" class="row justify-content-center px-3">
            {{-- Form Content --}}
            <div class="col-md-8">
            <form action="{{ route('ayam-karantina.store') }}" method="POST">
                @csrf
                    @include('kandang::ayam-karantina._form')
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
                        <i class="fas fa-info-circle me-2"></i> Panduan Pengisian Karantina Ayam
                    </h5>
                </div>

                <div class="card-body">
                    <p class="text-muted mb-3">
                        Pastikan mengisi data karantina ayam dengan benar sesuai petunjuk berikut:
                    </p>

                    <ul class="small text-muted ps-3">
                        <li>
                            <strong>Pilih Populasi Ayam</strong><br>
                            Pilih populasi ayam yang akan dicatat di karantina, termasuk informasi 
                            kandang, flock, dan pipe.
                        </li>

                        <li class="mt-2">
                            <strong>Tanggal Transaksi</strong><br>
                            Masukkan tanggal catatan karantina ayam dilakukan.
                        </li>

                        <li class="mt-2">
                            <strong>Ayam Masuk Karantina</strong><br>
                            Catat jumlah ayam yang masuk ke karantina pada hari tersebut.
                        </li>

                        <li class="mt-2">
                            <strong>Ayam Mati</strong><br>
                            Catat jumlah ayam yang mati selama proses karantina.
                        </li>

                        <li class="mt-2">
                            <strong>Ayam Afkir</strong><br>
                            Masukkan jumlah ayam yang afkir atau tidak layak dipelihara lagi.
                        </li>

                        <li class="mt-2">
                            <strong>Ayam Keluar Karantina</strong><br>
                            Catat jumlah ayam yang selesai karantina dan kembali ke kandang utama.
                        </li>

                        <li class="mt-2">
                            <strong>Pemberian Pakan</strong><br>
                            Masukkan jumlah pakan yang diberikan selama periode karantina (dalam kg).
                        </li>

                        <li class="mt-2">
                            <strong>Sisa Pakan</strong><br>
                            Catat jumlah sisa pakan yang tidak habis (dalam kg).
                        </li>

                        <li class="mt-2">
                            <strong>Jumlah Telur Bagus</strong><br>
                            Masukkan jumlah telur yang dalam kondisi baik.
                        </li>

                        <li class="mt-2">
                            <strong>Jumlah Telur Retak</strong><br>
                            Catat jumlah telur yang retak selama periode karantina.
                        </li>

                        <li class="mt-2">
                            <strong>Jumlah Telur Rusak</strong><br>
                            Catat jumlah telur yang rusak atau tidak layak jual.
                        </li>

                        <li class="mt-2">
                            <strong>Berat Telur Bagus / Retak / Rusak</strong><br>
                            Masukkan berat total untuk masing-masing kategori telur (dalam gram).
                        </li>

                        <li class="mt-2">
                            <strong>Pengobatan yang Dilakukan</strong><br>
                            Catat jenis pengobatan yang diberikan selama periode karantina.
                        </li>

                        <li class="mt-2">
                            <strong>Jumlah Ayam Diobati</strong><br>
                            Masukkan jumlah ayam yang mendapat pengobatan.
                        </li>

                        <li class="mt-2">
                            <strong>Penyemprotan</strong><br>
                            Masukkan jenis atau jadwal penyemprotan yang dilakukan di kandang karantina.
                        </li>

                        <li class="mt-2">
                            <strong>Vaksin</strong><br>
                            Catat jenis vaksin yang diberikan selama periode karantina.
                        </li>

                        <li class="mt-2">
                            <strong>Catatan</strong><br>
                            Tambahkan catatan tambahan yang relevan, seperti kondisi khusus ayam atau kendala selama karantina.
                        </li>
                    </ul>

                    <hr>

                    <p class="text-muted small">
                        Pastikan dropdown dan pilihan pipe muncul dengan benar, jika tidak, periksa bahwa
                         data berikut sudah ada:
                    </p>
                    <ul class="small text-muted ps-3">
                        <li>Data Peternakan</li>
                        <li>Data Kandang</li>
                        <li>Data Flock / Strain</li>
                    </ul>
                </div>
            </div>
        </div>


    </div>
</div>
@endsection