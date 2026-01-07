@extends('layouts.dashboard')

@section('title', 'Pencatatan Ayam Masuk')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Edit Pengadaan Ayam</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('pengadaan-ayam.index') }}">Pengadaan Ayam</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('pengadaan-ayam.show', $pengadaanAyam) }}">{{ $pengadaanAyam->name }}</a></li>
                    <li class="breadcrumb-item active">Edit</li>
                </ol>
            </div>
        </div>
    </div>
@stop

@section('content')
    <div class="mx-1200">
        <x-form-alert />
        <div class="row">
            <div class="col-md-9 col-12">
                <form
                    enctype="multipart/form-data"
                    action="{{ route('pengadaan-ayam.update', $pengadaanAyam->id) }}"
                    method="post"
                    id="form-pengadaan"
                >
                    @method('PUT')
                    @csrf
                    @include('kandang::pengadaan-ayam._form', ['data' => $pengadaanAyam])
                    @include('kandang::pengadaan-ayam._form_distribusi')
                    @include('kandang::pengadaan-ayam._form_berkas')
                    @include('kandang::pengadaan-ayam._form_documentation')
                </form>
        </div>
        <div class="col-md-3 col-12">
                <div class="card sticy-form-action">
                    <div class="card-header">
                        <h2 class="card-title">Aksi</h2>
                    </div>
                    <div class="card-body">
                        <div class="d-flex gap-3">
                            <a href="{{ route('pengadaan-ayam.index') }}" class="btn btn-outline-secondary flex-1">Kembali</a>
                            <button class="btn btn-primary flex-1" form="form-pengadaan">Simpan</button>
                        </div>
                    </div>
                </div>
        </div>
        </div>
    </div>
@endsection
