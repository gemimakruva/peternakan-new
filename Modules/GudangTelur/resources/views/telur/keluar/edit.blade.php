@extends('layouts.dashboard')

@section('title', 'Edit Telur Keluar')

@section('content_header')
<x-page-header title="Edit Telur Keluar" :breadcrumbs="['Telur Inventory' => route('gudang-telur.telur-inventory.index'), 'Telur Keluar' => route('gudang-telur.telur-keluar.index'), 'Edit' => '']" />
@endsection

@section('content')
<div class="mx-1200">
    <x-form-alert />

    <form action="{{ route('gudang-telur.telur-keluar.update', @$data) }}" method="post">
        @csrf
        @method('put')
        <div class="row">
            <div class="col-12 col-lg-9">
                @include('gudang-telur::telur.keluar._form')
                @include('gudang-telur::telur.keluar._form-list-telur')
                @include('gudang-telur::telur.keluar._form-list-kemasan')
            </div>
            <div class="col-12 col-lg-3">
                <div class="card sticy-form-action">
                    <div class="card-header">
                        <h2 class="card-title">Aksi</h2>
                    </div>
                    <div class="card-body">
                        <div class="d-flex gap-2">
                            <a href="{{ route('gudang-telur.telur-keluar.index') }}" class="btn btn-outline-secondary flex-1">Kembali</a>
                            <button class="btn btn-primary flex-1">Simpan</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection