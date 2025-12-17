@extends('layouts.dashboard')

@section('title', 'Form Vitamin Obat Minum')

@section('content_header')
    <div class="mb-4 text-center d-flex flex-column align-items-center" style="max-width: 1200px;'">
        <h2 class="h4 fw-bold text-dark">Form Vitamin Obat Minum</h2>
        <span class="text-muted mb-0" style="max-width: 600px;">
            Halaman ini digunakan Vitamin Obat Minum
        </span>
    </div>
@endsection

@section('content')
    <div>
        <div style="max-width: 1200px" class="row justify-content-center px-3">
            <div class="col-md-8">
                @include('components.form-alert')
                <form action="{{ route('perhitungan-obat.vitamin-obat-minum.store') }}" method="POST">
                    @csrf
                    @include('kandang::vitamin-obat-minum._form')
                    {{-- Button Submit --}}
                    <div class="mt-4 d-flex justify-content-between px-3">
                        <a href="{{ route('perhitungan-obat.vitamin-obat-minum.index') }}" class="btn btn-secondary px-4 py-2">
                            <i class="fas fa-arrow-left me-2"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-success px-4 py-2 shadow-sm">
                            <i class="fas fa-save me-2"></i> Simpan
                        </button>
                    </div>
                </form>
            </div>
            <div class="col-md-4"></div>
        </div>
    </div>
@endsection