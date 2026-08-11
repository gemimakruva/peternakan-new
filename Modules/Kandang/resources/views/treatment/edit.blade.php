@extends('layouts.dashboard')

@section('title', 'Edit Treatment')

@section('content_header')
    <x-page-header title="Edit Treatment" :breadcrumbs="[
        'Treatment' => route('treatment.index'),
        'Edit' => null,
    ]" />
@endsection

@section('content')
<div class="mx-1600">
    <x-form-alert />

    <div class="row">
        <div class="col-md-10 col-12">
            <form action="{{ route('treatment.update', $data) }}" method="post" id="form-treatment">
                @csrf
                @method('PUT')
                @include('kandang::treatment._form')
            </form>
        </div>
        <div class="col-md-2 col-12">
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
