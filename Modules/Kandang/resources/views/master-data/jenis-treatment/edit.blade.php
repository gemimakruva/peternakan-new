@extends('layouts.dashboard')

@section('title', 'Edit Jenis Treatment')

@section('content_header')
    <x-page-header title="Edit Jenis Treatment" :breadcrumbs="[
        'Master Data' => '#',
        'Jenis Treatment' => route('master-data.jenis-treatment.index'),
        'Edit' => null,
    ]" />
@endsection

@section('content')
<div class="mx-1200 row">
    <div class="col-md-9 col-12">
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">Form Jenis Treatment</h2>
            </div>
            <div class="card-body">
                <form action="{{ route('master-data.jenis-treatment.update', $data) }}" method="post" id="form-jenis-treatment" >
                    @csrf
                    @method('PUT')
                    @include('kandang::master-data.jenis-treatment._form')
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
                    <a href="{{ route('master-data.jenis-treatment.index') }}" class="btn btn-outline-secondary flex-1">
                        Kembali
                    </a>
                    <button type="submit" class="btn btn-primary flex-1" form="form-jenis-treatment">
                        Simpan
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
