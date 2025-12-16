@extends('adminlte::page')

@section('title', 'Tambah Pencatatan OVK & Pakan')

@section('content_header')
<div class="mb-4 text-center d-flex flex-column align-items-center">
    <h2 class="h4 fw-bold text-dark">Tambah Pencatatan OVK & Pakan</h2>
    <span class="text-muted mb-0">
        Halaman ini digunakan untuk melakukan pencatatan kebutuhan OVK dan pakan
    </span>
</div>
@endsection

@section('content')
<div class="row px-3">
    <div class="col-md-8">

        <x-form-alert />

        <form action="{{ route('ovk-pakan.store') }}" method="POST">
            @csrf

            <div class="card">
                <div class="card-body">
                    @include('kandang::ovk-pakan._form', [
                        'ovkPakan' => null
                    ])
                </div>
            </div>

            <div class="mt-4 d-flex justify-content-between">
                <a href="{{ route('ovk-pakan.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i> Kembali
                </a>

                <button type="submit" class="btn btn-success">
                    <i class="fas fa-save me-2"></i> Simpan
                </button>
            </div>

        </form>
    </div>
</div>
@endsection
