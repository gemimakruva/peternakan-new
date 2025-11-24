@extends('adminlte::page')

@section('title', 'Tambah Kandang')

@section('content_header')
<div class="mb-4 text-center d-flex flex-column align-items-center">
    <h2 class="h4 fw-bold text-dark">Form Kandang</h2>
    <span class="text-muted mb-0" style="max-width: 500px;">
        Form ini digunakan untuk menambahkan data kandang
    </span>
</div>
@endsection

@section('content')
<div style="max-width: 1200px; padding: 0 15px;" class="container-fluid px-2 px-md-4">
    <div class="row justify-content-center">
        <div class="col-md-8 col-12">
            
            <div class="card shadow-sm border-0" >
                <div class="card-header" style="background-color: #f8f9fa;">
                    <h4 class="card-title m-0 fw-semibold text-secondary">
                        <i class="fas fa-home me-2 text-muted"></i> Form Tambah Kandang
                    </h4>
                </div>

               <div class="card-body d-flex justify-content-center">
                    <form action="{{ route('master-data.kandang.store') }}" 
                        method="post" 
                        id="form-kandang"
                        style="max-width: 650px; width: 100%;">
                        @csrf
                        @include('kandang::master-data.kandang._form')

                        <hr class="my-4">

                        <div class="d-flex justify-content-between" style="gap: 1rem; margin-top: 1.5rem;">
                            <a href="{{ route('master-data.kandang.index') }}" 
                            class="btn btn-outline-secondary px-4 py-2">
                                <i class="fas fa-arrow-left me-2"></i> Kembali
                            </a>

                            <button type="submit" 
                               class="btn btn-success px-4 py-2 shadow-sm" 
                               style="background-color: #28a745; border-color: #28a745;">
                               <i class="fas fa-save me-2"></i> Simpan
                            </button>
                        </div>
                    </form>
                </div>

            </div>

        </div>
        <div class="col-md-4 col-12">
          <div class="card border-0 shadow-sm">
                <div class="card-header bg-light">
                    <h5 class="m-0 fw-semibold text-secondary">
                        <i class="fas fa-info-circle me-2"></i> Informasi Pengisian Kandang
                    </h5>
                </div>

                <div class="card-body">
                    <p class="text-muted mb-3">
                        Pastikan mengisi data kandang dengan benar sesuai petunjuk berikut:
                    </p>
                    <ul class="small text-muted ps-3">
                        <li>
                            <strong>Nama Kandang</strong><br>
                            Masukkan nama kandang yang jelas, contoh:
                            <em>Kandang A1, Kandang Produksi 2</em>.
                        </li>

                        <li class="mt-2">
                            <strong>Pilih Peternakan</strong><br>
                            Sesuaikan dengan lokasi kandang berada. Peternakan muncul berdasarkan data yang sudah terdaftar.
                        </li>

                        <li class="mt-2">
                            <strong>Pilih Strain Ayam</strong><br>
                            Tentukan strain ayam dalam kandang, misalnya:
                            <em>CP707, MB202, ISA Brown</em>.
                        </li>
                    </ul>
                    <hr>
                    <p class="text-muted small">
                        Jika pilihan dropdown tidak muncul, pastikan Anda telah menambahkan:
                    </p>
                    <ul class="small text-muted ps-3">
                        <li>Data Peternakan</li>
                        <li>Data Strain</li>
                    </ul>
                </div>
            </div>
        </div>   
    </div>
</div>
@endsection
