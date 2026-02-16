@extends('layouts.dashboard')

@section('title', 'Tambah Sampling Bobot Ayam')

@section('content_header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Tambah Sampling Bobot Ayam</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('sampling-ayam.index') }}">Sampling Bobot Ayam</a></li>
                <li class="breadcrumb-item active">Tambah</li>
            </ol>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="mx-1000">
    @include('components.form-alert')

    <div class="row">
        <div class="col-12 col-lg-9">
            <form action="{{ route('sampling-ayam.store') }}" method="POST" id="form-sampling-ayam">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title">Form Sampling Bobot Ayam</h2>
                    </div>
                    <div class="card-body">
                        @include('kandang::sampling-ayam._form', ['readonly' => false])
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
                    <div class="d-flex gap-3">
                        <a href="{{ route('sampling-ayam.index') }}" class="btn btn-outline-secondary flex-1">
                            Kembali
                        </a>
                        <button class="btn btn-primary flex-1" type="submit" form="form-sampling-ayam">
                            Simpan
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection