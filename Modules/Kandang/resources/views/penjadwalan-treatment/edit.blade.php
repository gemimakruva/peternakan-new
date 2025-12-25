@extends('adminlte::page')

@section('title', isset($data) ? 'Edit Penjadwalan Treatment' : 'Penjadwalan Treatment')

@section('content_header')
<div class="mb-4 text-center d-flex flex-column align-items-center">
    <h2 class="h4 fw-bold text-dark">
        {{ isset($data) ? 'Edit Penjadwalan Treatment' : 'Penjadwalan Treatment' }}
    </h2>
    <span class="text-muted mb-0" style="max-width: 600px;">
        Halaman ini digunakan melakukan pencatatan penjadwalan treatment
    </span>
</div>
@endsection

@section('content')
<div>
    <div style="max-width: 1200px" class="row justify-content-start px-3">
        {{-- Form Content --}}
        <div class="col-12">
            <x-form-alert />

        <form action="{{ route('penjadwalan-treatment.update',
            $penjadwalan_treatment->id) }}" method="POST">
    @csrf
    @method('PUT')

                @csrf
                @if(isset($data))
                    @method('PUT')
                @endif

                <div class="card">
                    <div class="card-body">
                        @include('kandang::penjadwalan-treatment._form_edit', ['data' => $penjadwalan_treatment])
                    </div>
                    {{-- Button Submit --}}
                    <div class="mt-4 d-flex justify-content-between px-3">
                        <a href="{{ route('penjadwalan-treatment.index') }}" class="btn btn-secondary px-4 py-2">
                            <i class="fas fa-arrow-left me-2"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-success px-4 py-2 shadow-sm">
                            <i class="fas fa-save me-2"></i> {{ isset($data) ? 'Update' : 'Simpan' }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@include('components.snackbar')
@endsection
