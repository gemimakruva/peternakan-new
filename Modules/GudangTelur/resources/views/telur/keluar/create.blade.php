@extends('layouts.dashboard')

@section('title', 'Tambah Telur Keluar')

@section('content_header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Tambah Telur Keluar</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">  
                <li class="breadcrumb-item"><a href="{{ route('gudang-telur.telur-inventory.index') }}">Telur Inventory</a></li>
                <li class="breadcrumb-item"><a href="{{ route('gudang-telur.telur-keluar.index') }}">Telur Keluar</a></li>
                <li class="breadcrumb-item active">Tambah</li>
            </ol>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="mx-1200">
    <x-form-alert />

    <form action="{{ route('gudang-telur.telur-keluar.store') }}" method="post">
        @csrf
        <div class="row">
            <div class="col-12 col-lg-9">
                @include('gudang-telur::telur.keluar._form')
                @include('gudang-telur::telur.keluar._form-list-telur')
                @include('gudang-telur::telur.keluar._form-list-kemasan')
            </div>
            <div class="col-12 col-lg-3">
                <div class="card sticy-form-action">
                    <div class="card-header">
                        <h2 class="card-title">Aksi</h2>
                    </div>
                    <div class="card-body">
                        <div class="d-flex gap-2">
                            <a href="{{ route('gudang-telur.telur-keluar.index') }}" class="btn btn-outline-secondary flex-1">Kembali</a>
                            <button class="btn btn-primary flex-1">Simpan</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection