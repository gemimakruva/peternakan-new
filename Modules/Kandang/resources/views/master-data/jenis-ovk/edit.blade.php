@extends('layouts.dashboard')

@section('title', 'Tambah Jenis OVK')

@section('content_header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Tambah Jenis OVK</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Master Data</a></li>
                <li class="breadcrumb-item"><a href="{{ route('master-data.jenis-ovk.index') }}">Jenis OVK</a></li>
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
                    <h4 class="card-title">Form Jenis OVK</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('master-data.jenis-ovk.update', @$data->id) }}" method="post" id="form-jenis-ovk">
                        @method('PUT')
                        @csrf
                        @include('kandang::master-data.jenis-ovk._form')
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
                        <a href="{{ route('master-data.jenis-ovk.index') }}" class="btn btn-outline-secondary flex-1">
                            Kembali
                        </a>
                        <button type="submit" class="btn btn-primary flex-1" form="form-jenis-ovk">
                            Simpan
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
