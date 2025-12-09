@extends('adminlte::page')

@section('title', 'Edit Baris')

@section('content_header')
<div class="mb-4 text-center d-flex flex-column align-items-center">
    <h2 class="h4 fw-bold text-dark">Edit Baris</h2>
    <span class="text-muted mb-0" style="max-width: 500px;">
        Form ini digunakan untuk mengubah data Baris
    </span>
</div>
@endsection
@section('content')
<div class="container-fluid px-2 px-md-4" style="1200px">
    <div class="row justify-content-center">
        {{-- Form Content --}}
       <div class="col-md-8">
          <div class="card shadow-sm border-0">
                <div class="card-body">
                    <form action="{{ route('master-data.flock.update',$flock) }}"
                     method="post" id="form-flock">
                            @csrf
                            @method('PUT')
                            @include('kandang::master-data.flock._form_edit',[
                                'kandang' => $flock->kandang,
                            ])
                            <hr class="my-4">
                            <div class="d-flex justify-content-end" style="gap: 1rem; margin-top: 1.5rem;">
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
       </div>
       {{-- Petunjuk Form --}}
    <div class="col-md-4">
             <div class="card border-0 shadow-sm">
                <div class="card-header bg-light">
                    <h5 class="m-0 fw-semibold text-secondary">
                        <i class="fas fa-info-circle me-2"></i> Informasi Pengisian Baris
                    </h5>
                </div>

                <div class="card-body">
                        <p class="text-muted mb-3">
                            Pastikan mengisi data Baris dengan benar sesuai petunjuk berikut:
                        </p>
                    <ul class="small text-muted ps-3">
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
@endsection
