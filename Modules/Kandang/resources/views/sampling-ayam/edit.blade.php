@extends('layouts.dashboard')

@section('title', 'Edit Sampling Bobot Ayam')

@section('content_header')
    <x-page-header title="Edit Sampling Bobot Ayam" :breadcrumbs="[
        'Sampling Bobot Ayam' => route('sampling-ayam.index'),
        'Edit' => null,
    ]" />
@endsection

@section('content')
<div class="mx-1200">
    @include('components.form-alert')

    <div class="row">
        <div class="col-12 col-lg-9">
            <form action="{{ route('sampling-ayam.update', $samplingBobotAyam->id) }}" method="POST" id="form-sampling-ayam">
                @csrf
                @method('PUT')
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title">Form Sampling Bobot Ayam</h2>
                    </div>
                    <div class="card-body">
                        @include('kandang::sampling-ayam._form', ['readonly' => true])
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
                    <div class="d-flex gap-3">
                        <a href="{{ route('sampling-ayam.index') }}" class="btn btn-outline-secondary flex-1">
                            Kembali
                        </a>
                        <button class="btn btn-primary flex-1" type="submit" form="form-sampling-ayam">
                            Simpan
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
