@extends('layouts.dashboard')

@section('title', 'Edit Supplier')

@section('content_header')
<x-page-header title="Edit Supplier" :breadcrumbs="['Supplier' => route('gudang-telur.supplier.index'), 'Edit' => '']" />
@endsection

@section('content')
<div class="mx-1200">
    <x-form-alert />

    <form action="{{ route('gudang-telur.supplier.update', $data) }}" method="post">
        @csrf
        @method('put')
        <div class="row">
            <div class="col-12 col-lg-9">
                @include('gudang-telur::supplier._form-supplier')
                @include('gudang-telur::supplier._form-kemasan')
            </div>
            <div class="col-12 col-lg-3">
                <div class="card sticy-form-action">
                    <div class="card-header">
                        <h2 class="card-title">Aksi</h2>
                    </div>
                    <div class="card-body">
                        <div class="d-flex gap-2">
                            <a href="{{ route('gudang-telur.supplier.index') }}" class="btn btn-outline-secondary flex-1">Kembali</a>
                            <button class="btn btn-primary flex-1">Simpan</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection