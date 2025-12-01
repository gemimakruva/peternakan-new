@extends('adminlte::page')

@section('title', 'Jenis pakan')

@section('content_header')
<div class="mb-4 text-center d-flex flex-column align-items-center">
    <h2 class="h4 fw-bold text-dark">Form Jenis Pakan</h2>
    <span class="text-muted mb-0" style="max-width: 500px;">
        Form ini digunakan untuk Menambah jenis pakan peternakan
    </span>
</div>
@endsection

@section('content')
<div class="container-fluid px-2 px-md-4" style="max-width: 1200px">
    <div class="row justify-content-center">
        {{-- Form Content --}}
       <div class="col-md-8">
          <div class="card shadow-sm border-0">
                <div class="card-body">
                    <form action="{{ route('master-data.jenis-pakan.store') }}" method="post" id="form-flock">
                            @csrf
                            @include('kandang::master-data.jenis-pakan._form')
                            <hr class="my-4">
                            <div class="d-flex justify-content-end" style="gap: 1rem; margin-top: 1.5rem;">
                                <a href="{{ route('master-data.jenis-pakan.index') }}" 
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
                <i class="fas fa-info-circle me-2"></i> Informasi Pengisian Jenis Pakan
            </h5>
        </div>

        <div class="card-body">
            <p class="text-muted mb-3">
                Pastikan mengisi data jenis pakan dengan benar sesuai petunjuk berikut:
            </p>

            <ul class="small text-muted ps-3">
                <li>
                    <strong>Nama Jenis Pakan</strong><br>
                    Masukkan nama jenis pakan yang jelas dan mudah dikenali. 
                    Contoh: <em>Starter, Grower, Finisher, Konsentrat, Layer 1</em>.
                </li>

                <li class="mt-2">
                    <strong>Nama Tidak Boleh Duplikat</strong><br>
                    Sistem tidak mengizinkan dua nama jenis pakan yang sama. 
                    Pastikan nama unik dan belum pernah ditambahkan sebelumnya.
                </li>

                <li class="mt-2">
                    <strong>Penulisan Field</strong><br>
                    Gunakan huruf kapital yang rapi agar mudah dipahami dan konsisten. 
                    Contoh penamaan baik: <em>Starter 01</em> bukan <em>starter01</em>.
                </li>
            </ul>

            <hr>

            <p class="text-muted small">
                Data ini akan digunakan pada proses:
            </p>
            <ul class="small text-muted ps-3">
                <li>Pencatatan pakan harian</li>
                <li>Pengelolaan stok gudang pakan</li>
                <li>Laporan performa feed intake</li>
            </ul>
        </div>
    </div>
</div>

    </div>
</div>
@endsection
