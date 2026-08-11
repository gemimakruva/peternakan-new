@extends('layouts.dashboard')

@section('title', 'Edit Produksi Telur')

@section('content_header')
    <x-page-header title="Detail Produksi Telur" :breadcrumbs="[
        'Produksi Telur' => route('recording-telur.index'),
        'Detail' => null,
    ]" />
@endsection

@section('content')
<div class="mx-1200">
    @include('components.form-alert')

    <div class="row">
        <div class="col-12 col-lg-9">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Form Edit Produksi Telur</h2>
                </div>
                <div class="card-body">
                    @include('kandang::recording-telur._form', ['data' => $produksiTelur, 'readonly' => true])
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-3">
            <div class="card sticy-form-action">
                <div class="card-header">
                    <h2 class="card-title">Aksi</h2>
                </div>
                <div class="card-body">
                    <div class="d-flex gap-3">
                        <a href="{{ route('recording-telur.index') }}" class="btn btn-outline-secondary flex-1">Kembali</a>
                        @can('kandang.telur.edit-produksi-telur')
                            <a href="{{ route('recording-telur.edit', $produksiTelur) }}" class="btn btn-warning flex-1">Edit</a>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
