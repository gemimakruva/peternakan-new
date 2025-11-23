@extends('adminlte::page')

@section('title', 'Pencatatan Ayam Masuk')

@section('content_header')
<div class="mb-4 text-center d-flex flex-column align-items-center pt-3">
    <h2 class="h4 fw-bold text-dark"> Form Pengadaan Ayam</h2>
    <span class="text-muted mb-0" style="max-width: 500px;">
        Halaman ini digunakan untuk input form pengadaan ayam
</div>
@stop

@section('content')
<div class="container-fluid px-2 px-md-4" style="max-width: 1200px">
    <div class="row justify-content-center">
        {{-- Form Content --}}
          <div class="col-md-8">
              <form action="{{ route('pengadaan-ayam.store') }}" method="post" id="form-flock">
                   <div class="card shadow-sm border-0">
                        <div class="card-body">
                            @csrf
                            @include('kandang::pengadaan-ayam._form')
                              @include('kandang::pengadaan-ayam._form_berkas')
                        </div>
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