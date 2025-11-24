@extends('adminlte::page')

@section('title', 'Edit Pipe')

@section('content_header')
<div class="mb-4 text-center d-flex flex-column align-items-center">
    <h2 class="h4 fw-bold text-dark">Edit Pipe</h2>
    <span class="text-muted mb-0" style="max-width: 500px;">
        Form Ini Digunakan Untuk Mengubah Nama dan Kapasitas Pipe
    </span>
</div>
@endsection

@section('content')
<div class="container-fluid px-2 px-md-4">
    <div class="row justify-content-center">
        {{-- Form Content --}}
       <div class="col-md-8">
            <div class="card shadow-sm border-0 p-3">
                <form action="{{ route('master-data.pipe.update',$pipe) }}" method="post" id="form-flock">
                    @csrf
                    @method('PUT')
                    @include('kandang::master-data.pipe._form')
                    <hr class="my-4">
                    <div class="d-flex justify-content-between px-2" style="gap: 1rem; margin-top: 1.5rem;">
                        <a href="{{ route('master-data.flock.index') }}" 
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
       {{-- Petunjuk Form --}}
    <div class="col-md-4">
             <div class="card border-0 shadow-sm">
                <div class="card-header bg-light">
                    <h5 class="m-0 fw-semibold text-secondary">
                        <i class="fas fa-info-circle me-2"></i> Informasi Pengisian Pipe
                    </h5>
                </div>

                <div class="card-body">
                        <p class="text-muted mb-3">
                            Pastikan mengisi data Pipe dengan benar sesuai petunjuk berikut:
                        </p>
                    <ul class="small text-muted ps-3">
                        <li>
                            <strong>Nama Pipe</strong><br>
                            Digunakan untuk mengganti nama pipe yang sudah ada dan tidak sesuai standar penamaan.
                        </li>

                        <li class="mt-2"> 
                            <strong>Kapasitas</strong>
                            <br class="text-center"> Kapasitas digunakan untuk menginisalisasi
                            jumlah maksimum entitas (misalnya ayam) yang dapat ditampung oleh pipe tersebut.
                        </li>

                    </ul>
                    <hr>
                    <p class="text-muted small">
                        Jika terjadi masalah dalam pengisian data pipe, pastikan Anda sudah menambahkan:
                    </p>
                    <ul class="small text-muted ps-3">
                        <li>Data Peternakan</li>
                        <li>Data Kandang</li>
                        <li>Data Strain</li>
                        <li>Data Flock</li>
                    </ul>
                </div>
            </div>
       </div>
    </div>
</div>
@endsection
