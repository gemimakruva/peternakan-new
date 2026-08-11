@extends('layouts.dashboard')

@section('title', 'Edit Peternakan')

@section('content_header')
    <x-page-header title="Edit Peternakan" :breadcrumbs="[
        'Master Data' => '#',
        'Peternakan' => route('master-data.peternakan.index'),
        $peternakan->nama => route('master-data.peternakan.show', $peternakan),
        'Edit' => null,
    ]" />
@endsection

@section('content')
<div class="mx-1200 row">
    <div class="col-md-9 col-12">
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">Form Peternakan</h2>
            </div>
            <div class="card-body">
                <form action="{{ route('master-data.peternakan.update', $peternakan) }}" method="post" id="form-peternakan" >
                    @csrf
                    @method('PUT')
                    @include('kandang::master-data.peternakan._form')
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
