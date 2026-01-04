@extends('layouts.dashboard')

@section('title', 'Tambah Baris')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <div class="d-flex align-items-center gap-1">
                <h1>Tambah Baris</h1>
            </div>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Master Data</a></li>
              <li class="breadcrumb-item"><a href="{{ route('master-data.flock.index') }}">Baris</a></li>
              <li class="breadcrumb-item active">Tambah</li>
            </ol>
          </div>
        </div>
    </div>
@endsection

@section('content')
<div class="mx-1200">
    <div class="row">

        {{-- Form Content --}}
        <div class="col-md-9 col-md-3">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Form Baris</h2>
                </div>
                <div class="card-body">
                    <form action="{{ route('master-data.flock.store') }}" method="post" id="form-flock">
                            @csrf
                            @include('kandang::master-data.flock._form')
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-12">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Aksi</h2>
                </div>
                <div class="card-body">
                    <div class="d-flex gap-3">
                        <a href="{{ route('master-data.flock.index') }}" class="btn btn-outline-secondary flex-1">Kembali</a>
                        <button class="btn btn-primary flex-1" form="form-flock">Simpan</button>
                    </div>
                </div>
            </div>

            {{-- Petunjuk Form --}}
            <div class="card">
                <div class="card-header bg-light">
                    <h2 class="card-title">Petunjuk Pengisian Baris</h2>
                </div>
                <div class="card-body">
                    <ul class="small text-muted">
                        <li>
                            <strong>Nama Baris</strong><br>
                            Masukkan nama Baris yang jelas, contoh:
                            <em>Baris A1, Baris Produksi 2</em>.
                        </li>

                        <li class="mt-2"> 
                            <strong>Kata Kunci Nama Pipa</strong>
                            <br class="text-center"> - Kata kunci ini digunakan untuk mengelompokkan
                            atau mengidentifikasi pipa yang terhubung dengan baris.
                            <br class="text-center"> - Pastikan kata kunci dibuat tanpa sepasi
                            atau dihubungkan antar kata dengan strip (-). Contoh: <em>baris1-pipa-1, baris2-pipa-1</em>.
                        </li>

                        <li class="mt-2">
                            <strong>Jumlah Pipa per-Baris</strong><br>
                            isi dengan jumlah pipa yang akan digunakan dalam baris ini.
                        </li>
                    </ul>
                    <hr>
                    <p class="text-muted small">
                        Jika pilihan dropdown tidak muncul atau pipa tidak tergenerate, pastikan Anda sudah menambahkan:
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
@include('components.snackbar')
@endsection
