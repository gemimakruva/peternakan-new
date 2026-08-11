@extends('layouts.dashboard')

@section('title', 'Form Monitoring Kesehatan')

@section('content_header')
    <x-page-header title="Tambah Monitoring Kesehatan" :breadcrumbs="[
        'Monitoring Kesehatan' => route('monitoring-kesehatan.index'),
        'Tambah' => null,
    ]" />
@endsection

@section('content')
    <div class="row">
        <div class="col-12 col-lg-9 mb-4">
            @include('components.form-alert')
            @include('kandang::monitoring-kesehatan._form')
        </div>
        <div class="col-md-4"></div>
    </div>
@endsection