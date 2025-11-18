@extends('adminlte::page')

@section('title', 'Update Peternakan')

@section('content_header')
<div class="mb-4 text-center d-flex flex-column align-items-center">
    <h2 class="h4 fw-bold text-dark">Update Data Peternakan</h2>
    <span class="text-muted mb-0" style="max-width: 500px;">
        Form ini digunakan untuk memperbarui data peternakan yang sudah terdaftar.
    </span>
</div>
@endsection

@section('content')
<div style="max-width: 1200px; padding: 0 15px;" class="container-fluid px-2 px-md-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            
            <div class="card shadow-sm border-0">
                <div class="card-header" style="background-color: #f8f9fa;">
                    <h4 class="card-title m-0 fw-semibold text-secondary">
                        <i class="fas fa-home me-2 text-muted"></i> Form Update Peternakan
                    </h4>
                </div>

                <div class="card-body d-flex justify-content-center">
                    <form 
                        action="{{ route('master-data.peternakan.update', $peternakan) }}" 
                        method="POST" 
                        id="form-Peternakan"
                        style="max-width: 650px; width: 100%;">

                        @csrf
                        @method('PUT')

                        @include('kandang::master-data.peternakan._form')

                        <hr class="my-4">

                        <div class="d-flex justify-content-end" style="gap: 1rem; margin-top: 1.5rem;">
                            <a href="{{ route('master-data.peternakan.index') }}" 
                                class="btn btn-outline-secondary px-4 py-2">
                                <i class="fas fa-arrow-left me-2"></i> Kembali
                            </a>

                            <button type="submit" 
                                class="btn btn-success px-4 py-2 shadow-sm" 
                                style="background-color: #28a745; border-color: #28a745;">
                                <i class="fas fa-save me-2"></i> Update
                            </button>
                        </div>

                    </form>
                </div>

            </div>

        </div>
    </div>
</div>
@endsection
