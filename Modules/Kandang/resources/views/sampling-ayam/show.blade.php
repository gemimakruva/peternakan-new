@extends('layouts.dashboard')

@section('title', 'Edit Sampling Bobot Ayam')

@section('content_header')
    <x-page-header title="Detail Sampling Bobot Ayam" :breadcrumbs="[
        'Sampling Bobot Ayam' => route('sampling-ayam.index'),
        'Detail' => null,
    ]" />
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
