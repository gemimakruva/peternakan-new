@extends('adminlte::page')

@section('title', 'Perhitungan Pakan')

@section('content_header')
<div class="mb-4 text-center d-flex flex-column align-items-center">
    <h2 class="h4 fw-bold text-dark">Perhitungan Sisa Pakan</h2>
    <span class="text-muted mb-0" style="max-width: 600px;">
        Halaman ini digunakan Mencatat pelaksanaan pemberian Pakan dan
         sisa pakan harian
    </span>
</div>
@endsection


@section('content')
<div>
        <div style="max-width: 1200px" class="row justify-content-start px-3">
            {{-- Form Content --}}
            <div class="col-md-8">
            <form action="{{ route('perhitungan-pakan.store') }}" method="POST">
                @csrf
                    <div class="card">
                        <div class="card-body">
                            @include('kandang::sisa-pakan._form')
                        </div>
                    </div>
                    {{-- Button Submit --}}
                    <div class="mt-4 d-flex justify-content-between px-3">
                        <a href="" class="btn btn-secondary px-4 py-2">
                            <i class="fas fa-arrow-left me-2"></i> Kembali
                        </a>
                        <button id="btnSubmitPopulasi" type="submit"
                            class="btn btn-success px-4 py-2 shadow-sm">
                            <i class="fas fa-save me-2"></i> Simpan
                        </button>
                    </div>
                </form>
            </div>
    </div>
</div>
@endsection