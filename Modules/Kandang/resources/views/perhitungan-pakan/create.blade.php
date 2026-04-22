@extends('layouts.dashboard')

@section('title', 'Tambah Perhitungan Pemberian Pakan')

@section('content_header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <div class="d-flex align-items-center gap-1">
                <h1>Tambah Perhitungan Pemberian Pakan</h1>
            </div>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">Pemberian Pakan</li>
                <li class="breadcrumb-item"><a href="{{ route('perhitungan-pakan.index') }}">Perhitungan Pemberian Pakan</a></li>
                <li class="breadcrumb-item active">Tambah</li>
            </ol>
        </div>
    </div>
</div>
@endsection


@section('content')
<div class="mx-1200">
    <x-form-alert />

    <div class="row">
        <div class="col-12 col-lg-9">
            <form action="{{ route('perhitungan-pakan.store') }}" method="POST" id="form-perhitungan-pakan">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title">Form Perhitungan Pakan</h2>
                    </div>
                    <div class="card-body">
                        @include('kandang::perhitungan-pakan._form', ['readonly' => false])
                    </div>
                </div>
            </form>
        </div>
    
        <div class="col-12 col-lg-3">
            <div class="card sticy-form-action">
                <div class="card-header">
                    <h2 class="card-title">Aksi</h2>
                </div>
                <div class="card-body">
                    <div class="d-flex gap-2">
                        <a href="{{ route('perhitungan-pakan.index') }}" class="btn btn-outline-secondary flex-1">
                            Kembali
                        </a>
                        <button form="form-perhitungan-pakan" type="submit" class="btn btn-primary flex-1">
                            Simpan
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection