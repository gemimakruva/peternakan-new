@extends('layouts.dashboard')

@section('title', 'Edit Pipa')

@section('content_header')
    <x-page-header title="Edit Pipa" :breadcrumbs="[
        'Master Data' => '#',
        'Pipa' => route('master-data.pipe.index'),
        'Edit' => null,
    ]" />
@endsection

@section('content')
<div class="mx-900">
    <x-form-alert />

    <div class="row">
        <div class="col-md-9 col-12">
            <form action="{{ route('master-data.pipe.update',$pipe) }}" method="post" id="form-pipe">
                @csrf
                @method('PUT')
                @include('kandang::master-data.pipe._form')
            </form>        
        </div>
        <div class="col-md-3 col-12">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Aksi</h2>
                </div>
                <div class="card-body">
                    <div class="d-flex gap-3">
                        <a href="{{ route('master-data.pipe.index') }}" class="btn btn-outline-secondary flex-1">Kembali</a>
                        <button class="btn btn-primary flex-1" form="form-pipe">Simpan</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
