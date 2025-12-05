@extends('adminlte::page')

@section('title', 'Edit Jenis Disenfectan')

@section('content_header')
<div class="mb-4 text-center d-flex flex-column align-items-center">
    <h2 class="h4 fw-bold text-dark">Edit Jenis Disenfectan</h2>
    <span class="text-muted mb-0" style="max-width: 500px;">
        Form ini digunakan untuk mengubah data jenis disenfectan pada treatment
    </span>
</div>
@endsection

@section('content')
<div class="container-fluid px-2 px-md-4" style="max-width: 1200px">
    <div class="row justify-content-center">
        {{-- Form Content --}}
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <form action="{{ route('master-data.jenis-disinfectan.update', $data->id) }}"
                         method="post" id="form-flock">
                        @csrf
                        @method('put')

                        @include('kandang::master-data.disinfectan._form')

                        <hr class="my-4">
                        <div class="d-flex justify-content-end" style="gap: 1rem;
                         margin-top: 1.5rem;">
                            <a href="{{ route('master-data.jenis-disinfectan.index') }}" 
                               class="btn btn-outline-secondary px-4 py-2">
                                <i class="fas fa-arrow-left me-2"></i> Kembali
                            </a>

                            <button type="submit" 
                                class="btn btn-warning px-4 py-2 shadow-sm text-white"
                                style="border-color: #ffc107;">
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
