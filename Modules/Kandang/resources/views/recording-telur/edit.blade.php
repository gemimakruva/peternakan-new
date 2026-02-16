@extends('layouts.dashboard')

@section('title', 'Edit Produksi Telur')

@section('content_header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Edit Produksi Telur</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">  
                <li class="breadcrumb-item"><a href="{{ route('recording-telur.index') }}">Produksi Telur</a></li>
                <li class="breadcrumb-item active">{{ $produksiTelur->kandang->nama }} - {{ $produksiTelur->tanggal->translatedFormat('l, d F Y') }}</li>
                <li class="breadcrumb-item active">Edit</li>
            </ol>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="mx-1200">
    @include('components.form-alert')

    <div class="row">
        <div class="col-12 col-lg-9">
            <form action="{{ route('recording-telur.update', $produksiTelur->id) }}" method="POST" id="form-produksi-telur">
                @csrf
                @method('PUT')
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title">Form Edit Produksi Telur</h2>
                    </div>
                    <div class="card-body">
                        @include('kandang::recording-telur._form', ['data' => $produksiTelur])
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
                        <a href="{{ route('recording-telur.index') }}" class="btn btn-outline-secondary flex-1">Kembali</a>
                        <button class="btn btn-primary flex-1" type="submit" form="form-produksi-telur">Simpan</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
