@extends('layouts.dashboard')

@section('title', 'Edit Sampling Bobot Ayam')

@section('content_header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Edit Sampling Bobot Ayam</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('sampling-ayam.index') }}">Sampling Bobot Ayam</a></li>
                <li class="breadcrumb-item active">{{ $samplingBobotAyam->kandang->nama }} - {{ $samplingBobotAyam->tanggal->translatedFormat('l, d F Y') }}</li>
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
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Detail Sampling Bobot Ayam</h2>
                </div>
                <div class="card-body">
                    @include('kandang::sampling-ayam._form', ['readonly' => true])
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-3">
            <div class="card sticy-form-action">
                <div class="card-header">
                    <h2 class="card-title">Aksi</h2>
                </div>
                <div class="card-body">
                    <div class="d-flex gap-2">
                        <a href="{{ route('sampling-ayam.index') }}" class="btn btn-outline-secondary flex-1">
                            Kembali
                        </a>
                        @can('kandang.sampling.edit-sampling-bobot-ayam')
                            <a href="{{ route('sampling-ayam.edit', $samplingBobotAyam->id) }}" class="btn btn-warning flex-1">
                                Edit
                            </a>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
