@extends('layouts.dashboard')

@section('title', 'Tambah Formulasi Pakan')

@section('content_header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Tambah Formulasi Pakan</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">  
                <li class="breadcrumb-item"><a href="{{ route('gudang-pakan.bahan-pakan-formulasi.index') }}">Tambah Formulasi Pakan</a></li>
                <li class="breadcrumb-item active">Tambah</li>
            </ol>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="mx-1200">
    <x-form-alert />

    <form action="{{ route('gudang-pakan.bahan-pakan-formulasi.store',) }}" method="post">
        @csrf
        <div 
            class="row"
            x-data="{
                list_berat_pakan: @js(old('berat_pakan', @$data->bahanPakanFormulasiBerat ?? [])),
                addBeratPakan() {
                    this.list_berat_pakan.push({ berat: 0 });
                },
                removeBeratPakan(i) {
                    this.list_berat_pakan = this.list_berat_pakan.filter((_, i2) => i2 !== i);
                }
            }"
        >
            <div class="col-12 col-lg-9">
                @include('gudang-pakan::bahan-pakan-formulasi._form')
                @include('gudang-pakan::bahan-pakan-formulasi._formulasi')
            </div>
            <div class="col-12 col-lg-3">
                <div class="card sticy-form-action">
                    <div class="card-header">
                        <h2 class="card-title">Aksi</h2>
                    </div>
                    <div class="card-body">
                        <div class="d-flex gap-2">
                            <a href="{{ route('gudang-pakan.bahan-pakan-formulasi.index') }}" class="btn btn-outline-secondary flex-1">Kembali</a>
                            <button class="btn btn-primary flex-1">Simpan</button>
                        </div>
                    </div>
                </div>
                @include('gudang-pakan::bahan-pakan-formulasi._berat_pakan')
            </div>
        </div>
    </form>
</div>
@endsection