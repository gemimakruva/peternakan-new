@extends('layouts.dashboard')

@section('title', 'Edit Satuan')

@section('content_header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Edit Satuan</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Master Data</a></li>
                <li class="breadcrumb-item"><a href="{{ route('master-data.jenis-ovk.index') }}">Satuan</a></li>
                <li class="breadcrumb-item active">Edit</li>
            </ol>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="mx-1200">
    <div class="row">
        <div class="col-md-9 col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Form Satuan</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('master-data.satuan.update', $data) }}" method="post" id="form-satuan">
                        @csrf
                        @method('PUT')
                        @include('kandang::master-data.satuan._form')
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-12">
            <div class="card sticy-form-action">
                <div class="card-header">
                    <h2 class="card-title">Aksi</h2>
                </div>
                <div class="card-body">
                    <div class="d-flex gap-3">
                        <a href="{{ route('master-data.satuan.index') }}" class="btn btn-outline-secondary flex-1">
                            Kembali
                        </a>
                        <button type="submit" class="btn btn-primary flex-1" form="form-satuan">
                            Simpan
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
