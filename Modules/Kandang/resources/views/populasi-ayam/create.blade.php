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
    <div style="max-width: 1200px">
        @include('components.form-alert')

        <div class="row justify-content-center">
            {{-- Form Content --}}
            <div class="col-md-8">
                <form action="{{ route('populasi-ayam.store') }}" method="POST">
                    @csrf
                    <div class="card">
                        <div class="card-header">
                            <h2 class="card-title">Recording Harian</h2>
                        </div>
                        <div class="card-body">
                            @include('kandang::populasi-ayam._form')
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

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title">Log Pencatatan Harian</h2>
                    </div>
                    <div class="card-body">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Pipa</th>
                                    <th>Sehat</th>
                                    <th>Mati</th>
                                    <th>Afkir</th>
                                    <!-- <th>Masuk Karantina</th>
                                    <th>Keluar Karantina</th> -->
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