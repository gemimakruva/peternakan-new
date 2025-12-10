@extends('adminlte::page')

@section('title', 'Edit Sisa Pakan')

@section('content_header')
<div class="mb-4 text-center d-flex flex-column align-items-center">
    <h2 class="h4 fw-bold text-dark">Edit Perhitungan Sisa Pakan</h2>
    <span class="text-muted mb-0" style="max-width: 600px;">
        Halaman ini digunakan untuk mengubah data pelaksanaan pemberian pakan
        dan sisa pakan harian.
    </span>
</div>
@endsection

@section('content')
<x-form-alert />

<div>
    <div style="max-width: 1200px" class="row justify-content-start px-3">

        {{-- Form Content --}}
        <div class="col-md-8">

            <form action="{{ route('sisa-pakan.update', $data->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="card">
                    <div class="card-body">

                        {{-- Inject data ke partial form --}}
                        @include('kandang::sisa-pakan._form_edit', ['edit' => true])

                    </div>
                </div>

                {{-- Button Submit --}}
                <div class="mt-4 d-flex justify-content-between px-3">
                    <a href="{{ route('sisa-pakan.listDataSisaPakanHarian') }}" class="btn btn-secondary px-4 py-2">
                        <i class="fas fa-arrow-left me-2"></i> Kembali
                    </a>

                    <button id="btnSubmitPopulasi" type="submit"
                        class="btn btn-primary px-4 py-2 shadow-sm">
                        <i class="fas fa-save me-2"></i> Update
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>

@include('components.snackbar')

@endsection
