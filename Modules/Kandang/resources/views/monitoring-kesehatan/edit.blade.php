@extends('adminlte::page')

@section('title', 'Edit Monitoring Kesehatan')


@section('content_header')
<div class="mb-4 text-center">
    <h1 class="h4 fw-bold text-dark mb-1">Edit Monitoring Kesehatan</h1>
    <p class="text-muted">
        Perbarui data Monitoring Kesehatan di bawah ini
    </p>
</div>
@stop


@section('content')
    <div class="row">
        <div class="col-12 col-md-9 mb-4">
            @include('components.form-alert')
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    @include('kandang::monitoring-kesehatan._form')
                </div>
            </div>
        </div>
    </div>
@endsection