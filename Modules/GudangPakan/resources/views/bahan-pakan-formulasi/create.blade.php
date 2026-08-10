@extends('layouts.dashboard')

@section('title', 'Tambah Formulasi Pakan')

@section('content_header')
<x-page-header title="Tambah Formulasi Pakan" :breadcrumbs="['Formulasi Pakan' => route('gudang-pakan.bahan-pakan-formulasi.index'), 'Tambah' => '']" />
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
            </div>
        </div>
    </form>
</div>
@endsection