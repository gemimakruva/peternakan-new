@extends('layouts.dashboard')

@section('title', 'Tambah Kandang')

@section('content_header')
    <x-page-header title="Tambah Kandang" :breadcrumbs="[
        'Master Data' => '#',
        'Kandang' => route('master-data.kandang.index'),
        'Tambah' => null,
    ]" />
@endsection

@section('content')
<div class="mx-1200 row">
    <x-form-alert />
    <div class="col-md-9 col-12">
        <form action="{{ route('master-data.kandang.store') }}" method="post" id="form-kandang">
            @csrf
            @include('kandang::master-data.kandang._form')
            @include('kandang::master-data.kandang._form_generate_flock_n_pipe')
        </form>
    </div>
    <div class="col-md-3 col-12">
        <div class="card sticy-form-action">
            <div class="card-header">
                <h2 class="card-title">Aksi</h2>
            </div>
            <div class="card-body">
                <div class="d-flex gap-3">
                    <a href="{{ route('master-data.kandang.index') }}" class="btn btn-outline-secondary flex-1">
                        Kembali
                    </a>
                    <button type="submit" class="btn btn-primary flex-1" form="form-kandang">
                        Simpan
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
