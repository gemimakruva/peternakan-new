@extends('layouts.dashboard')

@section('title', 'Tambah Peternakan')

@section('content_header')
    <x-page-header title="Tambah Peternakan" :breadcrumbs="[
        'Master Data' => '#',
        'Peternakan' => route('master-data.peternakan.index'),
        'Tambah' => null,
    ]" />
@endsection

@section('content')
<div class="mx-1200 row">
    <div class="col-md-9 col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Form Peternakan</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('master-data.peternakan.store') }}" method="post" id="form-peternakan">
                    @csrf
                    @include('kandang::master-data.peternakan._form')

                    <div class="d-flex justify-content-between" 
                    style="gap: 1rem; margin-top: 1.5rem;">
                        
                    </button>
                    </div>
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
                    <a href="{{ route('master-data.peternakan.index') }}" class="btn btn-outline-secondary flex-1">
                        Kembali
                    </a>
                    <button type="submit" class="btn btn-primary flex-1" form="form-peternakan">
                        Simpan
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
