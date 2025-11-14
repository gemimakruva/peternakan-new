@extends('adminlte::page')

@section('title', 'Pencatatan Ayam Masuk')

@section('content_header')
    <div class="mb-4 text-center">
        <h1 class="h4 fw-bold text-dark mb-1">
            Pencatatan Pengadaan Ayam
        </h1>
        <p class="text-muted">
            Lengkapi form berikut untuk mencatat pengadaan ayam baru
        </p>
    </div>
@stop


@section('content')
<div class="row">
    <div class="col-12 col-md-8">
        {{-- Form Pengadaan Ayam --}}
           <form action="" method="post" id="form-flock">
                        @csrf
                        @include('kandang::supplier-log._form') 
                            <button type="submit" 
                                    class="btn btn-success px-4 py-2 shadow-sm" 
                                    style="background-color: #28a745; border-color: #28a745;">
                                <i class="fas fa-save me-2"></i> Simpan
                            </button>
                        </div>
                    </form>
    </div>

    <div class="col-12 col-md-4">
  {{-- Panduan Pengisian --}}
<div class="card shadow-sm border-0 h-fit">
    <div class="card-header bg-light fw-bold text-dark">
        <i class="bi bi-info-circle me-2"></i> Panduan Pengisian
    </div>

    <div class="card-body">

        <h6 class="fw-bold text-secondary">1. Informasi Ayam</h6>
        <ul class="small mb-3 text-secondary">
            <li>Pilih jenis pencatatan: <strong>Ayam Karantina</strong> atau <strong>Ayam Masuk</strong>.</li>
            <li>Isi tanggal masuk ayam.</li>
            <li>Masukkan umur ayam dalam hari.</li>
            <li>Pilih kondisi ayam (sehat, kurang sehat, sakit).</li>
            <li>Isi jumlah ayam datang, ayam mati, dan ayam sakit.</li>
        </ul>

        <h6 class="fw-bold text-secondary">2. Informasi Kandang</h6>
        <ul class="small mb-3 text-secondary">
            <li>Pilih nama kandang tempat ayam ditempatkan.</li>
            <li>Tambahkan data flock, nama pipe, dan Jumlah ekor yang mau diinput.</li>
        </ul>

        <h6 class="fw-bold text-secondary">3. Berkas & Dokumentasi</h6>
        <ul class="small mb-3 text-secondary">
            <li>Isi nama berkas sesuai dokumen yang diupload.</li>
            <li>Upload file seperti PDF, gambar, atau foto pendukung.</li>
            <li>Upload dokumentasi Foto Pengadaan ayam melalui dropzone yang tersedia.</li>
        </ul>
    </div>
</div>

<div class="alert alert-warning d-flex align-items-start gap-2 p-3">
    <i class="bi bi-exclamation-triangle-fill fs-4 px-1"></i>
    <div>
        <h6 class="fw-bold mb-1">Perhatian</h6>
        <p class="mb-0 small">
            Data yang sudah disubmit <strong>tidak dapat diubah</strong>.  
            Pastikan semua informasi sudah benar sebelum menekan tombol submit.
        </p>
    </div>
</div>


</div>

</div>

@endsection