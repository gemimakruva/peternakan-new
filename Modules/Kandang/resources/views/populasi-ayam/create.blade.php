@extends('layouts.dashboard')

@section('title', 'Recording Harian')

@section('content_header')
    <div class="mb-4 text-center d-flex flex-column align-items-center" style="max-width: 1200px;">
        <h2 class="h4 fw-bold text-dark">Recording Harian - {{ $kandang->nama }}</h2>
        <span class="text-muted mb-0" style="max-width: 600px;">
            Halaman ini digunakan untuk Melakukan Pencatatan Populasi Ayam Harian
        </span>
    </div>
@endsection

@section('content')
    <div style="max-width: 1400px">
        @include('components.form-alert')

        <div class="row justify-content-center">
            {{-- Form Content --}}
            <div class="col-md-12 col-xl-6">
                <form action="{{ route('populasi-ayam.store') }}" method="POST">
                    @csrf
                    <div class="card">
                        <div class="card-header">
                            <h2 class="card-title">Form Pencatatan Harian Ayam</h2>
                        </div>
                        <div class="card-body">
                            @include('kandang::populasi-ayam.create-form-pencatatan-harian-ayam')
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h2 class="card-title">Kondisi Harian Ayam</h2>
                        </div>
                        <div class="card-body">
                            @include('kandang::populasi-ayam.create-form-kondisi-harian-ayam')
                        </div>
                    </div>
                    {{-- Button Submit --}}
                    <div class="mt-4 d-flex justify-content-between px-3">
                        <a href="" class="btn btn-secondary px-4 py-2">
                            <i class="fas fa-arrow-left me-2"></i> Kembali
                        </a>
                        <button id="btnSubmitPopulasi" type="submit" class="btn btn-success px-4 py-2 shadow-sm">
                            <i class="fas fa-save me-2"></i> Simpan
                        </button>
                    </div>
                </form>
            </div>

            <div class="col-md-12 col-xl-6">
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title">Log Pencatatan Harian</h2>
                    </div>
                    <div class="card-body">
                        <table class="table table-sm table-bordered">
                            <thead>
                                <tr style="vertical-align: middle; text-align: center;">
                                    <th rowspan="2" style="vertical-align: middle; text-align: center;">Pipa</th>
                                    <th rowspan="2" style="vertical-align: middle; text-align: center;">Sehat</th>
                                    <th rowspan="2" style="vertical-align: middle; text-align: center;">Mati</th>
                                    <th rowspan="2" style="vertical-align: middle; text-align: center;">Afkir</th>
                                    <th colspan="2" style="vertical-align: middle; text-align: center;">Karantina</th>
                                </tr>
                                <tr style="vertical-align: middle; text-align: center;">
                                    <th style="vertical-align: middle; text-align: center;">Masuk</th>
                                    <th style="vertical-align: middle; text-align: center;">Keluar</th>
                                </tr>
                            </thead>
                            <tbody id="record-harian">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection