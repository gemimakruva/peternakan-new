@extends('adminlte::page')

@section('title', 'Tambah Peternakan')

@section('content_header')
<div class="mb-4 text-center d-flex flex-column align-items-center">
    <h2 class="h4 fw-bold text-dark">Form Peternakan</h2>
    <span class="text-muted mb-0" style="max-width: 500px;">
        Form ini digunakan untuk menambahkan data Peternakan
    </span>
</div>
@endsection

@section('content')
<div style="max-width: 1200px; padding: 0 15px;" class="container-fluid px-2 px-md-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0" >
                <div class="card-header" style="background-color: #f8f9fa;">
                    <h4 class="card-title m-0 fw-semibold text-secondary">
                        <i class="fas fa-home me-2 text-muted"></i> Form Tambah Peternakan
                    </h4>
                </div>

               <div class="card-body d-flex justify-content-center">
                    <form action="{{ route('master-data.peternakan.store') }}" 
                        method="post" 
                        id="form-Peternakan"
                        style="max-width: 650px; width: 100%;">
                        @csrf
                        @include('kandang::master-data.peternakan._form')

                        <hr class="my-4">

                        <div class="d-flex justify-content-between" style="gap: 1rem; margin-top: 1.5rem;">
                            <a href="{{ route('master-data.peternakan.index') }}" 
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
           <div class="col-md-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-light">
                        <h5 class="m-0 fw-semibold text-secondary">
                            <i class="fas fa-info-circle me-2"></i> Panduan Form Peternakan
                        </h5>
                    </div>

                    <div class="card-body">
                            <p class="text-muted mb-3">
                                Pastikan mengisi data Peternakan dengan benar sesuai petunjuk berikut:
                            </p>
                        <ul class="small text-muted ps-3">
                            <li>
                                <strong>Nama Peternakan</strong><br>
                                Masukkan nama Peternakan yang jelas, contoh:
                                <em>Peternakan Lohwan, Peternakan Surya Farm</em>.
                            </li>

                            <li class="mt-2"> 
                                <strong>Alamat Peternakan</strong>
                                <br class="text-center"> Masukan alamat lengkap peternakan termasuk
                                jalan, kota, dan kode pos untuk referensi yang tepat.
                        </ul>
                        <hr>
                        <p class="text-muted small">
                            Jika terjadi kendala dalam pengisian form, pastikan Anda sudah mengisi data dengan benar dan lengkap
                        </p>
                    </div>
                </div>
        </div>
    </div>
</div>
@endsection
