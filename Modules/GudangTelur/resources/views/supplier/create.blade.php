@extends('layouts.dashboard')

@section('title', 'Tambah Supplier')

@section('content_header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Tambah Supplier</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">  
                <li class="breadcrumb-item"><a href="{{ route('gudang-telur.supplier.index') }}">Supplier</a></li>
                <li class="breadcrumb-item active">Tambah</li>
            </ol>
        </div>
    </div>
</div>
@endsection


@section('content')
<div class="mx-1200">
    <x-form-alert />

    <div class="row">
        <div class="col-12 col-lg-9">
            <div class="card">
                <div class="card-body">
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection