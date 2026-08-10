@extends('layouts.dashboard')

@section('title', 'Tambah Opname Pre-Mixing')

@section('content_header')
    <x-page-header title="Tambah Opname Pre-Mixing" :breadcrumbs="['Opname Pre-Mixing' => route('gudang-pakan.pakan-pre-mixing-opname.index'), 'Tambah' => '']" />
@endsection

@section('content')
<div class="mx-1200">
    <x-form-alert />

    <form action="{{ route('gudang-pakan.pakan-pre-mixing-opname.store',) }}" method="post">
        @csrf
        <div class="row">
            <div class="col-12 col-lg-9">
                @include('gudang-pakan::pakan-pre-mixing-opname._form')
                @include('gudang-pakan::pakan-pre-mixing-opname._form_list_bahan_pakan')
            </div>
            <div class="col-12 col-lg-3">
                <div class="card sticy-form-action">
                    <div class="card-header">
                        <h2 class="card-title">Aksi</h2>
                    </div>
                    <div class="card-body">
                        <div class="d-flex gap-2">
                            <a href="{{ route('gudang-pakan.pakan-pre-mixing-opname.index') }}" class="btn btn-outline-secondary flex-1">Kembali</a>
                            <button class="btn btn-primary flex-1">Simpan</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection