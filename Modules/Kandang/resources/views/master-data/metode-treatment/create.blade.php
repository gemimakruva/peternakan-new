@extends('layouts.dashboard')

@section('title', 'Tambah Metode Treatment')

@section('content_header')
    <x-page-header title="Tambah Metode Treatment" :breadcrumbs="[
        'Master Data' => '#',
        'Metode Treatment' => route('master-data.metode-treatment.index'),
        'Tambah' => null,
    ]" />
@endsection

@section('content')
<div class="mx-1200 row">
    <div class="col-md-9 col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Form Metode Treatment</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('master-data.metode-treatment.store') }}" method="post" id="form-metode-treatment">
                    @csrf
                    @include('kandang::master-data.metode-treatment._form')
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-12">
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">Aksi</h2>
            </div>
            <div class="card-body">
                <div class="d-flex gap-3">
                    <a href="{{ route('master-data.metode-treatment.index') }}" class="btn btn-outline-secondary flex-1">
                        Kembali
                    </a>
                    <button type="submit" class="btn btn-primary flex-1" form="form-metode-treatment">
                        Simpan
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
