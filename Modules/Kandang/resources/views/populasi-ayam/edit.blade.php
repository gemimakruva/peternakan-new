@extends('layouts.dashboard')

@section('title', 'Edit Populasi Ayam')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <div class="d-flex align-items-center gap-1">
                <h1>Edit Populasi Ayam</h1>
            </div>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">  
              <li class="breadcrumb-item"><a href="{{ route('populasi-ayam.index') }}">Populasi Ayam</a></li>
              <li class="breadcrumb-item active">{{ $kandang->nama }}</li>
              <li class="breadcrumb-item"><a href="{{ route('populasi-ayam.flock.index', $kandang) }}">Flock</a></li>
              <li class="breadcrumb-item active">{{ $flock->nama }}</li>
              <li class="breadcrumb-item active">Edit</li>
            </ol>
          </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="mx-1400">
        @include('components.form-alert')

        <div class="row justify-content-center">
            {{-- Form Content --}}
            <div class="col-md-12 col-xl-6">
                <form action="{{ route('populasi-ayam.update', @$data->id) }}" method="POST" id="form-populasi-ayam">
                    @method('PUT')
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
                </form>
            </div>

            <div class="col-md-12 col-xl-6">
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title">Aksi</h2>
                    </div>
                    <div class="card-body">
                        <div class="d-flex gap-3">
                            <a href="{{ route('populasi-ayam.flock.index', $kandang) }}" class="btn btn-secondary flex-1">
                                Kembali
                            </a>
                            <button id="btnSubmitPopulasi" type="submit" class="btn btn-primary flex-1" form="form-populasi-ayam">
                                Simpan
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title">Log Pencatatan Harian</h2>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-sm table-bordered">
                            <thead>
                                <tr style="vertical-align: middle; text-align: center;">
                                    <th rowspan="2" style="vertical-align: middle; text-align: center;">Pipa</th>
                                    <th rowspan="2" style="vertical-align: middle; text-align: center;">Sehat</th>
                                    <th rowspan="2" style="vertical-align: middle; text-align: center;">Mati</th>
                                    <th rowspan="2" style="vertical-align: middle; text-align: center;">Afkir</th>
                                    <th colspan="2" style="vertical-align: middle; text-align: center;">Karantina</th>
                                    <th rowspan="2" style="vertical-align: middle; text-align: center;">Aksi</th>
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