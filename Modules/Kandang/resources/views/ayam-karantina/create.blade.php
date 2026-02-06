@extends('layouts.dashboard')

@section('title', 'Tambah Ayam Karantina')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <div class="d-flex align-items-center gap-1">
                    <h1>Tambah Ayam Karantina</h1>
                </div>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">  
                    <li class="breadcrumb-item"><a href="{{ route('ayam-karantina.index') }}">Ayam Karantina</a></li>
                    <li class="breadcrumb-item active">Tambah</li>
                </ol>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="mx-1200">
        <div class="row">
            <div class="col-md-9 col-12">
                <form action="{{ route('ayam-karantina.store') }}" method="POST" id="form-ayam-karantina">
                    @csrf
                    <div class="card">
                        <div class="card-header">
                            <h2 class="card-title">Form Ayam Karantina</h2>
                        </div>
                        <div class="card-body">
                            @include('kandang::ayam-karantina._form')
                        </div>
                    </div>    
                </form>
            </div>
            <div class="col-md-3 col-12">
                <div class="card sticy-form-action">
                    <div class="card-header">
                        <h2 class="card-title">Aksi</h2>
                    </div>
                    <div class="card-body">
                        <div class="d-flex gap-3">
                            <a href="{{ route('ayam-karantina.index') }}" class="btn btn-outline-secondary flex-1">Kembali</a>
                            <button class="btn btn-primary flex-1" form="form-ayam-karantina">Simpan</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection