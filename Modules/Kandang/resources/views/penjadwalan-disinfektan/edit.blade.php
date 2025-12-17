@extends('adminlte::page')

@section('title', 'Edit Penjadwalan Disinfektan')


@section('content_header')
<div class="mb-4 text-center">
    <h1 class="h4 fw-bold text-dark mb-1">Edit Penjadwalan Disinfektan</h1>
    <p class="text-muted">
        Perbarui data Penjadwalan Disinfektan di bawah ini
    </p>
</div>
@stop


@section('content')
    <div class="row">
        <div class="col-12 col-md-12 mb-4">
            @include('components.form-alert')
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <form action="{{ route('penjadwalan-disinfektan.update', $penjadwalanDisinfektan->id) }}" method="POST">

                        @csrf
                        @method('PUT')

                        {{-- Load reusable form fields --}}
                        @include('kandang::penjadwalan-disinfektan._form')

                        {{-- ACTION BUTTONS --}}
                        <div class="mt-4 d-flex justify-content-between px-3">

                            {{-- Back Button --}}
                            <a href="{{ route('penjadwalan-disinfektan.index') }}" class="btn btn-secondary px-4 py-2">
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