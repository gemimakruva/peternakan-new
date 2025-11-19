@extends('adminlte::page')

@section('title', 'Edit Flock')

@section('content_header')
<div class="mb-4 text-center d-flex flex-column align-items-center">
    <h2 class="h4 fw-bold text-dark">Edit Flock</h2>
    <span class="text-muted mb-0" style="max-width: 500px;">
        Form ini digunakan untuk mengubah data Flock
    </span>
</div>
@endsection

@section('content')
<div class="container-fluid px-2 px-md-4">
    <div class="row justify-content-center">
        {{-- Form Content --}}
       <div class="col-md-8">
          <div class="card shadow-sm border-0">
                <div class="card-body">
                    <form action="{{ route('master-data.flock.update',$flock) }}" method="post" id="form-flock">
                            @csrf
                            @method('PUT')
                            @include('kandang::master-data.flock._form_edit',[
                                'kandang' => $kandang,
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
                        <i class="fas fa-info-circle me-2"></i> Informasi Pengisian Flock
                    </h5>
                </div>

                <div class="card-body">
                        <p class="text-muted mb-3">
                            Pastikan mengisi data Flock dengan benar sesuai petunjuk berikut:
                        </p>
                    <ul class="small text-muted ps-3">
                        <li>
                            <strong>Nama Flock</strong><br>
                            Masukkan nama Flock yang jelas, contoh:
                            <em>Flock A1, Flock Produksi 2</em>.
                        </li>

                        <li class="mt-2"> 
                            <strong>Kata Kunci Nama Pipe</strong>
                            <br class="text-center"> - Kata kunci ini digunakan untuk mengelompokkan
                            atau mengidentifikasi pipe yang terhubung dengan flock.
                            <br class="text-center"> - Pastikan kata kunci dibuat tanpa sepasi
                            atau dihubungkan antar kata dengan strip (-). Contoh: <em>flock1-pipe-1, flock2-pipe-1</em>.
                        </li>

                        <li class="mt-2">
                            <strong>Jumlah Pipe per-Flock</strong><br>
                            isi dengan jumlah pipe yang akan digunakan dalam flock ini.
                        </li>
                    </ul>
                    <hr>
                    <p class="text-muted small">
                        Jika pilihan dropdown tidak muncul atau pipe tidak tergenerate, pastikan Anda sudah menambahkan:
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
