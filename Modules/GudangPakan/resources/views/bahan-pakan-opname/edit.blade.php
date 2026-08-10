@extends('layouts.dashboard')

@section('title', 'Edit Bahan Pakan Opname')

@section('content_header')
    <x-page-header title="Edit Bahan Pakan Opname" :breadcrumbs="['Bahan Pakan Opname' => route('gudang-pakan.bahan-pakan-opname.index'), 'Edit' => '']" />
@endsection

@section('content')
<div class="mx-1200">
    <x-form-alert />

    <form action="{{ route('gudang-pakan.bahan-pakan-opname.update', $data->id) }}" method="post">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-12 col-lg-9">
                @include('gudang-pakan::bahan-pakan-opname._form')
                @include('gudang-pakan::bahan-pakan-opname._form_list_bahan_pakan')
            </div>
            <div class="col-12 col-lg-3">
                <div class="card sticy-form-action">
                    <div class="card-header">
                        <h2 class="card-title">Aksi</h2>
                    </div>
                    <div class="card-body">
                        <div class="d-flex gap-2">
                            <a href="{{ route('gudang-pakan.bahan-pakan-opname.index') }}" class="btn btn-outline-secondary flex-1">Kembali</a>
                            <button class="btn btn-primary flex-1">Simpan</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection