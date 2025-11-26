@extends('layouts.dashboard')

@section('title', 'Recording Harian')

@section('content_header')
<div class="mb-4 text-center d-flex flex-column align-items-center">
    <h2 class="h4 fw-bold text-dark">Recording Harian</h2>
    <span class="text-muted mb-0" style="max-width: 600px;">
        Halaman ini digunakan untuk Melakukan Pencatatan Populasi Ayam Harian 
    </span>
</div>
@endsection

@section('content')
<div>
<div class="row justify-content-center">
        {{-- Form Content --}}
        <div class="col-md-8">
           <form action="{{ route('populasi-ayam.store') }}" method="POST">
             @csrf
                 @include('kandang::populasi-ayam._form')
                 {{-- Button Submit --}}
                 <div class="mt-4 d-flex justify-content-between px-3">
                     <a href="" class="btn btn-secondary px-4 py-2">
                        <i class="fas fa-arrow-left me-2"></i> Kembali
                     </a>
                     <button id="btnSubmitPopulasi" type="submit"
                        class="btn btn-success px-4 py-2 shadow-sm">
                        <i class="fas fa-save me-2"></i> Simpan
                     </button>
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
                                Pastikan mengisi data pengadaan ayam dengan benar sesuai petunjuk berikut:
                            </p>
                        <ul class="small text-muted ps-3">
                            <li>
                                <strong>Tanggal Pengadaan</strong><br>
                                Tanggal pengadaan diinput saat ayam dari supplier Datang
                                dari kandang
                            </li>

                            <li class="mt-2"> 
                                <strong>Jumlah Ayam Datang</strong>
                                <br class="text-center"> - Masukan jumlah keseluruhan ayam yang datang
                                baik ayam sehat, ayam sakit maupun ayam mati
                            </li>

                            <li class="mt-2">
                                <strong>Umur Ayam</strong><br>
                                Masukan rata rata populasi umur ayam datang dalam format mingguan
                            </li>

                            <li class="mt-2">
                                <strong>Jumlah Ayam Sakit</strong><br>
                                Masukan jumlah ayam sakit pada saat proses pengadaan ayam
                            </li>

                            <li class="mt-2"> 
                                <strong>Jumlah Ayam Mati</strong>
                                <br class="text-center"> - Masukan jumlah ayam yang mati pada
                                saat proses pengadaan ayam
                            </li>

                             <li class="mt-2">
                                <strong>Input Form Berkas Supplier</strong>
                                <br>
                                - petugas diharapkan menginput nama (jenis) Berkas
                                dalam proses pengadaan Ayam
                                <br>
                                - setelah itu petugas diharapkan menguploud file
                                baik berupa file PNG , JPG atau PDF (disarankan JPG)
                            </li>

                              <li class="mt-2">
                                <strong>Upload Dokumentasi</strong>
                                <br>
                                - petugas diharapkan menguploud bukti proses
                                  dokumentasi saat pelaksanaan proses pengadaan ayam
                                  (bisa uploud lebih dari 1 foto)
                            </li>

                        </ul>
                        <hr>
                        <p class="text-muted small">
                            Jika pilihan dropdown tidak muncul atau pipe tidak tergenerate, pastikan Anda
                             sudah menambahkan:
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

