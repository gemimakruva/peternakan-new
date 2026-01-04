@extends('layouts.dashboard')

@section('title', 'Tambah Pipa')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <div class="d-flex align-items-center gap-1">
                    <h1>Tambah Pipa</h1>
                </div>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Master Data</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('master-data.kandang.index') }}">Kandang</a></li>
                    <li class="breadcrumb-item active">{{ $kandang->nama }}</li>
                    <li class="breadcrumb-item"><a href="{{ route('master-data.kandang.show', $kandang) }}">Detail</a></li>
                    <li class="breadcrumb-item active">{{ $flock->nama }}</li>
                    <li class="breadcrumb-item"><a href="{{ route('master-data.kandang.flock.show', [$kandang, $flock]) }}">Detail</a></li>
                    <li class="breadcrumb-item active">Tambah Pipa</li>
                </ol>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="mx-1200">
        <x-form-alert />

        <div class="row">
            <div class="col-md-9 col-md-3">
                <form 
                    action="{{ route('master-data.kandang.flock.pipe.store', [$kandang, $flock]) }}"
                    method="post"
                    id="form-kandang-flock"
                >
                    @csrf
                    @include('kandang::master-data.kandang.flock.pipe._form')
                </form>
            </div>

            <div class="col-md-3 col-12">
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title">Aksi</h2>
                    </div>
                    <div class="card-body">
                        <div class="d-flex gap-3">
                            <a href="{{ route('master-data.kandang.flock.show', [$kandang, $flock]) }}" class="btn btn-outline-secondary flex-1">Kembali</a>
                            <button class="btn btn-primary flex-1" form="form-kandang-flock">Simpan</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
