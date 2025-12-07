@extends('layouts.dashboard')

@section('title', 'Edit Sampling Bobot Ayam')

@section('content_header')
    <div class="mb-4 text-center d-flex flex-column align-items-center" style="max-width: 1200px;">
        <h2 class="h4 fw-bold text-dark">Edit Sampling Bobot Ayam</h2>
        <span class="text-muted mb-0" style="max-width: 600px;">
            Halaman ini digunakan untuk mengubah data sampling bobot ayam
        </span>
    </div>
@endsection

@section('content')
    <div style="max-width: 1200px">
        @include('components.form-alert')

        <div class="row justify-content-center">
            <div class="col-md-8">
                <form action="{{ route('sampling-ayam.update', $samplingBobotAyam->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="card">
                        <div class="card-header">
                            <h2 class="card-title">Edit Sampling Bobot Ayam</h2>
                        </div>
                        <div class="card-body">
                            @include('kandang::sampling-ayam._form', [
                                'kandangList' => $kandangList,
                                'samplingBobotAyam' => $samplingBobotAyam
                            ])
                        </div>
                    </div>
                    
                    <div class="mt-4 d-flex justify-content-between px-3">
                        <a href="{{ route('sampling-ayam.index') }}" class="btn btn-secondary px-4 py-2">
                            <i class="fas fa-arrow-left me-2"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-primary px-4 py-2 shadow-sm">
                            <i class="fas fa-save me-2"></i> Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
