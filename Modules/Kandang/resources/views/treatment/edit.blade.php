@extends('layouts.dashboard')

@section('title', 'Edit Treatment')

@section('content_header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Edit Treatment</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Master Data</a></li>
                <li class="breadcrumb-item"><a href="{{ route('treatment.index') }}">Treatment</a></li>
                <li class="breadcrumb-item active">Edit</li>
            </ol>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="mx-1600">
    <x-form-alert />

    <div class="row">
        <div class="col-md-10 col-12">
            <form action="{{ route('treatment.update', $data) }}" method="post" id="form-treatment">
                @csrf
                @method('PUT')
                @include('kandang::treatment._form')
            </form>
        </div>
        <div class="col-md-2 col-12">
            <div class="card sticy-form-action">
                <div class="card-header">
                    <h2 class="card-title">Aksi</h2>
                </div>
                <div class="card-body">
                    <div class="d-flex gap-3">
                        <a href="{{ route('treatment.index') }}" class="btn btn-outline-secondary flex-1">
                            Kembali
                        </a>
                        <button type="submit" class="btn btn-primary flex-1" form="form-treatment">
                            Simpan
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
