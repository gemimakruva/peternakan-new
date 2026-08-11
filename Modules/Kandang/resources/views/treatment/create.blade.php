@extends('layouts.dashboard')

@section('title', 'Tambah Treatment')

@section('content_header')
    <x-page-header title="Tambah Treatment" :breadcrumbs="[
        'Treatment' => route('treatment.index'),
        'Tambah' => null,
    ]" />
@endsection

@section('content')
<div class="mx-1200">
    <div class="row">
        <div class="col-md-9 col-12">
            <form action="{{ route('treatment.store') }}" method="post" id="form-treatment">
                @csrf
                @include('kandang::treatment._form')
            </form>
        </div>
        <div class="col-md-3 col-12">
            <div class="card sticy-form-action">
                <div class="card-header">
                    <h2 class="card-title">Aksi</h2>
                </div>
                <div class="card-body">
                    <div class="d-flex gap-3">
                        <a href="{{ route('treatment.index') }}" class="btn btn-outline-secondary flex-1">
                            Kembali
                        </a>
                        <button type="submit" class="btn btn-primary flex-1" form="form-treatment">
                            Simpan
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
