@extends('layouts.dashboard')

@section('title', 'Form Produksi Telur')

@section('content_header')
    <div class="mb-4 text-center d-flex flex-column align-items-center" style="max-width: 1200px;">
        <h2 class="h4 fw-bold text-dark">Form Produksi Telur</h2>
        <span class="text-muted mb-0" style="max-width: 600px;">
            Halaman ini digunakan untuk input produksi telur
        </span>
    </div>
@endsection

@section('content')
    <div style="max-width: 1200px">
        @include('components.form-alert')

        <div class="row justify-content-center">
            <div class="col-md-8">
                <form action="{{ route('recording-telur.store') }}" method="POST">
                    @csrf
                    <div class="card">
                        <div class="card-header">
                            <h2 class="card-title">Form Produksi Telur</h2>
                        </div>
                        <div class="card-body">
                            @include('kandang::recording-telur._form')
                        </div>
                    </div>

                    <div class="mt-4 d-flex justify-content-between px-3">
                        <a href="{{ route('recording-telur.index') }}" class="btn btn-secondary px-4 py-2">
                            <i class="fas fa-arrow-left me-2"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-success px-4 py-2 shadow-sm">
                            <i class="fas fa-save me-2"></i> Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection