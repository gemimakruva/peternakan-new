@extends('adminlte::page')

@section('title', 'Tambah Flock')

@section('content_header')
    <h1 class="text-dark fw-bold">Tambah Flock</h1>
@endsection

@section('content')
<div class="container-fluid px-2 px-md-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <form action="{{ route('master-data.flock.store') }}" method="post" id="form-flock">
                        @csrf
                        @include('kandang::master-data.flock._form')

                        <hr class="my-4">

                        <div class="d-flex justify-content-end" style="gap: 1rem; margin-top: 1.5rem;">
                            <a href="{{ route('master-data.flock.index') }}" 
                               class="btn btn-outline-secondary px-4 py-2">
                                <i class="fas fa-arrow-left me-2"></i> Kembali
                            </a>

                            <button type="submit" 
                                    class="btn btn-success px-4 py-2 shadow-sm" 
                                    style="background-color: #28a745; border-color: #28a745;">
                                <i class="fas fa-save me-2"></i> Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
