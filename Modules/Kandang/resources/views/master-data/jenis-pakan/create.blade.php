@extends('layouts.dashboard')

@section('title', 'Tambah Jenis Pakan')

@section('content_header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
        <div class="d-flex align-items-center gap-1">
            <h1>Tambah Jenis Pakan</h1>
        </div>
        </div>
        <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Master Data</a></li>
            <li class="breadcrumb-item"><a href="{{ route('master-data.jenis-pakan.index') }}">Jenis Pakan</a></li>
            <li class="breadcrumb-item active">Tambah Jenis Pakan</li>
        </ol>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="mx-1200 row">
    <div class="col-md-9 col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Form Jenis Pakan</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('master-data.jenis-pakan.store') }}" method="post" id="form-jenis-pakan">
                    @csrf
                    @include('kandang::master-data.jenis-pakan._form')
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-12">
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">Aksi</h2>
            </div>
            <div class="card-body">
                <div class="d-flex gap-3">
                    <a href="{{ route('master-data.jenis-pakan.index') }}" class="btn btn-outline-secondary flex-1">
                        Kembali
                    </a>
                    <button type="submit" class="btn btn-primary flex-1" form="form-jenis-pakan">
                        Simpan
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
