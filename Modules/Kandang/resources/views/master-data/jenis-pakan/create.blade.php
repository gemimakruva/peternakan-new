@extends('layouts.dashboard')

@section('title', 'Tambah Jenis Pakan')

@section('content_header')
    <x-page-header title="Tambah Jenis Pakan" :breadcrumbs="[
        'Master Data' => '#',
        'Jenis Pakan' => route('master-data.jenis-pakan.index'),
        'Tambah' => null,
    ]" />
@endsection

@section('content')
<div class="mx-1200 row">
    <div class="col-md-9 col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Form Jenis Pakan</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('master-data.jenis-pakan.store') }}" method="post" id="form-jenis-pakan">
                    @csrf
                    @include('kandang::master-data.jenis-pakan._form')
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
                    <a href="{{ route('master-data.jenis-pakan.index') }}" class="btn btn-outline-secondary flex-1">
                        Kembali
                    </a>
                    <button type="submit" class="btn btn-primary flex-1" form="form-jenis-pakan">
                        Simpan
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
