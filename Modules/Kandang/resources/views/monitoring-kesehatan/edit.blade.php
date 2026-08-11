@extends('adminlte::page')

@section('title', 'Edit Monitoring Kesehatan')


@section('content_header')
    <x-page-header title="Edit Monitoring Kesehatan" :breadcrumbs="[
        'Monitoring Kesehatan' => route('monitoring-kesehatan.index'),
        'Edit' => null,
    ]" />
@stop


@section('content')
    <div class="row">
        <div class="col-12 col-lg-9 mb-4">
            @include('components.form-alert')
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    @include('kandang::monitoring-kesehatan._form')
                </div>
            </div>
        </div>
    </div>
@endsection