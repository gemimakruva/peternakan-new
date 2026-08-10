@extends('layouts.dashboard')

@section('title', 'Tambah Output Kemasan')

@section('content_header')
<x-page-header title="Tambah Output Kemasan Supplier" :breadcrumbs="['Kemasan' => route('gudang-telur.kemasan-inventory.index'), 'Output' => route('gudang-telur.kemasan-output.index'), 'Tambah' => '']" />
@endsection

@section('content')
<div class="mx-1200">
    <x-form-alert />

    <form action="{{ route('gudang-telur.kemasan-output.store') }}" method="post">
        @csrf
        <div class="row">
            <div class="col-12 col-lg-9">
                @include('gudang-telur::kemasan.output._form')
            </div>
            <div class="col-12 col-lg-3">
                <div class="card sticy-form-action">
                    <div class="card-header">
                        <h2 class="card-title">Aksi</h2>
                    </div>
                    <div class="card-body">
                        <div class="d-flex gap-2">
                            <a href="{{ route('gudang-telur.kemasan-output.index') }}" class="btn btn-outline-secondary flex-1">Kembali</a>
                            <button class="btn btn-primary flex-1">Simpan</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection