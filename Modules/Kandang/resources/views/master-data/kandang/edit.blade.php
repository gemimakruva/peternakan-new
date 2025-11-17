@extends('adminlte::page')

@section('title', 'Edit Kandang')

@section('content_header')
    <h1 class="text-dark fw-bold">Edit Kandang</h1>
@endsection

@section('content')
<div class="container-fluid px-2 px-md-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            
            <div class="card shadow-sm border-0">
                <div class="card-header" style="background-color: #f8f9fa;">
                    <h4 class="card-title m-0 fw-semibold text-secondary">
                        <i class="fas fa-home me-2 text-muted"></i> Form Edit Kandang
                    </h4>
                </div>

                <div class="card-body">
                    <form action="{{ route('master-data.kandang.update', @$data->id) }}" 
                          method="post" 
                          id="form-kandang">
                        @csrf
                        @method('put')
                        @include('kandang::master-data.kandang._form')

                        <hr class="my-4">

                        <div class="d-flex justify-content-end" style="gap: 1rem; margin-top: 1.5rem;">
                            <a href="{{ route('master-data.kandang.index') }}" 
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
