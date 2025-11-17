@extends('adminlte::page')

@section('title', 'Pencatatan Ayam Afkir')

@section('content_header')
    <div class="mb-4 text-center">
        <h1 class="h4 fw-bold text-dark mb-1">Pencatatan Ayam Afkir</h1>
        <p class="text-muted">
            Lengkapi form berikut untuk mencatat transaksi Ayam Afkir
        </p>
    </div>
@stop


@section('content')
<div class="row">

    {{-- ======================== --}}
    {{-- FORM UTAMA AYAM AFKIR    --}}
    {{-- ======================== --}}
    <div class="col-12 col-md-8 mb-4">

        <div class="card shadow-sm border-0">
            <div class="card-body">

                <form action="" method="POST" id="form-afkir">
                    @csrf

                    {{-- Include Form --}}
                    @include('kandang::ayam-afkir._form')

                    <div class="mt-4 d-flex justify-content-between px-3">
                        <a href="" 
                           class="btn btn-secondary px-4 py-2">
                            <i class="fas fa-arrow-left me-2"></i> Kembali
                        </a>
                         <button type="submit" 
                                class="btn btn-success px-4 py-2 shadow-sm">
                            <i class="fas fa-save me-2"></i> Simpan
                        </button>
                    </div>
                </form>

            </div>
        </div>

    </div>

    {{-- ======================== --}}
    {{-- SIDEBAR INFORMASI        --}}
    {{-- ======================== --}}
    <div class="col-12 col-md-4">

        <div class="card border-0 shadow-sm">
            <div class="card-header bg-light">
                <h5 class="m-0 fw-semibold text-secondary">
                    <i class="fas fa-info-circle me-2"></i> Informasi
                </h5>
            </div>
            <div class="card-body">

                <p class="text-muted mb-3">
                    Pastikan data yang Anda masukkan sudah benar, terutama:
                </p>

                <ul class="small text-muted ps-3">
                    <li>Tanggal afkir sesuai catatan</li>
                    <li>Kandang, Flock, dan Pipe terhubung</li>
                    <li>Jumlah ayam afkir sesuai data lapangan</li>
                    <li>Harga per kg sesuai transaksi</li>
                </ul>

                <hr>

                <p class="text-muted small">
                    Jika terdapat data yang belum muncul pada pilihan (dropdown), pastikan Anda sudah menambahkan:
                </p>

                <ul class="small text-muted ps-3">
                    <li>Data Kandang</li>
                    <li>Data Flock</li>
                    <li>Data Pipe</li>
                </ul>

            </div>
        </div>

    </div>

</div>
@endsection
