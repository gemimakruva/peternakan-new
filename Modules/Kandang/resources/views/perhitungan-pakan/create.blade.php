@extends('layouts.dashboard')

@section('title', 'Tambah Perhitungan Pemberian Pakan')

@section('content_header')
    <x-page-header title="Tambah Perhitungan Pemberian Pakan" :breadcrumbs="[
        'Perhitungan Pakan' => route('perhitungan-pakan.index'),
        'Tambah' => null,
    ]" />
@endsection


@section('content')
<div class="mx-1200">
    <x-form-alert />

    <div class="row">
        <div class="col-12 col-lg-9">
            <form action="{{ route('perhitungan-pakan.store') }}" method="POST" id="form-perhitungan-pakan">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title">Form Perhitungan Pakan</h2>
                    </div>
                    <div class="card-body">
                        @include('kandang::perhitungan-pakan._form', ['readonly' => false])
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
                    <div class="d-flex gap-2">
                        <a href="{{ route('perhitungan-pakan.index') }}" class="btn btn-outline-secondary flex-1">
                            Kembali
                        </a>
                        <button form="form-perhitungan-pakan" type="submit" class="btn btn-primary flex-1">
                            Simpan
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection