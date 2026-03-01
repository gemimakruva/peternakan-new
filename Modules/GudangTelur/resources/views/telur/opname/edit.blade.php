@extends('layouts.dashboard')

@section('title', 'Edit Telur Opname')

@section('content_header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Edit Telur Opname</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">  
                <li class="breadcrumb-item"><a href="{{ route('gudang-telur.telur-inventory.index') }}">Telur Inventory</a></li>
                <li class="breadcrumb-item"><a href="{{ route('gudang-telur.telur-opname.index') }}">Telur Opname</a></li>
                <li class="breadcrumb-item active">Edit</li>
            </ol>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="mx-1200">
    <x-form-alert />

    <form action="{{ route('gudang-telur.telur-opname.update', @$data) }}" method="post">
        @csrf
        @method('put')
        <div class="row">
            <div class="col-12 col-lg-9">
                @include('gudang-telur::telur.opname._form')
            </div>
            <div class="col-12 col-lg-3">
                <div class="card sticy-form-action">
                    <div class="card-header">
                        <h2 class="card-title">Aksi</h2>
                    </div>
                    <div class="card-body">
                        <div class="d-flex gap-2">
                            <a href="{{ route('gudang-telur.telur-opname.index') }}" class="btn btn-outline-secondary flex-1">Kembali</a>
                            <button class="btn btn-primary flex-1">Simpan</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection