@extends('layouts.dashboard')

@section('title', 'Edit Produksi Telur')

@section('content_header')
    <x-page-header title="Edit Produksi Telur" :breadcrumbs="[
        'Produksi Telur' => route('recording-telur.index'),
        'Edit' => null,
    ]" />
@endsection

@section('content')
<div class="mx-1200">
    @include('components.form-alert')

    <div class="row">
        <div class="col-12 col-lg-9">
            <form action="{{ route('recording-telur.update', $produksiTelur->id) }}" method="POST" id="form-produksi-telur">
                @csrf
                @method('PUT')
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title">Form Edit Produksi Telur</h2>
                    </div>
                    <div class="card-body">
                        @include('kandang::recording-telur._form', ['data' => $produksiTelur])
                    </div>
                </div>
            </form>
        </div>
        <div class="col-12 col-lg-3">
            <div class="card sticy-form-action">
                <div class="card-header">
                    <h2 class="card-title">Aksi</h2>
                </div>
                <div class="card-body">
                    <div class="d-flex gap-3">
                        <a href="{{ route('recording-telur.index') }}" class="btn btn-outline-secondary flex-1">Kembali</a>
                        <button class="btn btn-primary flex-1" type="submit" form="form-produksi-telur">Simpan</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
