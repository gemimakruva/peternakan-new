@extends('adminlte::page')

@section('title', 'Edit Vitamin Obat Minum')


@section('content_header')
<div class="mb-4 text-center">
    <h1 class="h4 fw-bold text-dark mb-1">Edit Vitamin Obat Minum</h1>
    <p class="text-muted">
        Perbarui data Vitamin Obat Minum di bawah ini
    </p>
</div>
@stop


@section('content')
    <div class="row">
        <div class="col-12 col-md-8 mb-4">
            @include('components.form-alert')
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <form action="{{ route('perhitungan-obat.vitamin-obat-minum.update', $vitaminObatMinum->id) }}" method="POST">

                        @csrf
                        @method('PUT')

                        {{-- Load reusable form fields --}}
                        @include('kandang::vitamin-obat-minum.._form')

                        {{-- ACTION BUTTONS --}}
                        <div class="mt-4 d-flex justify-content-between px-3">

                            {{-- Back Button --}}
                            <a href="{{ route('perhitungan-obat.vitamin-obat-minum.index') }}" class="btn btn-secondary px-4 py-2">
                                <i class="fas fa-arrow-left me-2"></i> Kembali
                            </a>

                            {{-- Submit Button --}}
                            <button type="submit" class="btn btn-success px-4 py-2 shadow-sm">
                                <i class="fas fa-save me-2"></i> Update
                            </button>

                        </div>

                    </form>

                </div>
            </div>

        </div>


    </div>
@endsection