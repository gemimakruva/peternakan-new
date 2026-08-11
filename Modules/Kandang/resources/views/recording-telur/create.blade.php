@extends('layouts.dashboard')

@section('title', 'Tambah Produksi Telur')

@section('content_header')
    <x-page-header title="Tambah Produksi Telur" :breadcrumbs="[
        'Produksi Telur' => route('recording-telur.index'),
        'Tambah' => null,
    ]" />
@endsection

@section('content')
<div class="mx-1000">
    @include('components.form-alert')

    <div class="row">
        <div class="col-12 col-lg-9">
            <form action="{{ route('recording-telur.store') }}" method="POST" id="form-produksi-telur">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title">Form Produksi Telur</h2>
                    </div>
                    <div class="card-body">
                        @include('kandang::recording-telur._form')
                    </div>
                </div>
            </form>
        </div>
        <div class="col-12 col-lg-3">
            <div class="card sticy-form-action">
                <div class="card-header">
                    <h2 class="card-title">Aksi</h2>
                </div>
                <div class="card-body d-flex gap-2">
                    <a href="{{ route('recording-telur.index') }}" class="btn btn-outline-secondary flex-1">Kembali</a>
                    <button class="btn btn-primary flex-1" form="form-produksi-telur">Simpan</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection