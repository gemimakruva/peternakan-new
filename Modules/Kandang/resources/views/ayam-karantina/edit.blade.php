@extends('layouts.dashboard')

@section('title', 'Edit Ayam Karantina')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <div class="d-flex align-items-center gap-1">
                    <h1>Edit Ayam Karantina</h1>
                </div>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">  
                    <li class="breadcrumb-item"><a href="{{ route('ayam-karantina.index') }}"></a> Ayam Karantina</li>
                    <li class="breadcrumb-item active">{{ $data->kandang->name }}</li>
                    <li class="breadcrumb-item active">Edit</li>
                </ol>
            </div>
        </div>
    </div>
@endsection


@section('content')
    <div class="mx-1000">
        <x-form-alert />
        <div class="row">
            <div class="col-md-9 col-12">
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title">Form Ayam Karantina</h2>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('ayam-karantina.update', $data) }}" method="POST" id="edit-ayam-karantina-form">
                            @method('PUT')
                            @csrf
                            @include('kandang::ayam-karantina._form')
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
                            <a href="{{ route('ayam-karantina.index') }}" class="btn btn-secondary flex-1">Kembali</a>
                            <button type="submit" class="btn btn-primary flex-1" form="edit-ayam-karantina-form">Simpan</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection