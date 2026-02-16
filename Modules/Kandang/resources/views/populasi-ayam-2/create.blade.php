@extends('layouts.dashboard')

@section('title', 'Tambah Populasi Ayam')

@section('content_header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Tambah Populasi Ayam</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">  
                <li class="breadcrumb-item"><a href="{{ route('populasi-ayam-2.index') }}">Populasi Ayam</a></li>
                <li class="breadcrumb-item active">Tambah Populasi Ayam</li>
            </ol>
        </div>
    </div>
</div>
@endsection

@section('content')
<div
    class="mx-1200 page-create-populasi"
    x-data="data"
>
    @include('components.form-alert')

    <div class="row justify-content-center">
        <div class="col-12 col-lg-9">
            <form action="{{ route('populasi-ayam-2.store') }}" method="POST" id="form-populasi-ayam">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title">Form Informasi</h2>
                    </div>
                    <div class="card-body">
                        <x-adminlte-select
                            label="Kandang"
                            name="kandang_id"
                        >
                            <x-adminlte-options
                                :options="$listKandang"
                                empty-option="Pilih Kandang"
                                :selected="old('kandang_id')"
                            />
                        </x-adminlte-select>

                        <x-adminlte-input
                            type="date"
                            label="Tanggal"
                            name="tanggal"
                            :value="old('tanggal')"
                        />
                    </div>
                </div>
            </form>
        </div>

        <div class="col-12 col-lg-3">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Aksi</h2>
                </div>
                <div class="card-body">
                    <div class="d-flex gap-3">
                        <a href="{{ route('populasi-ayam-2.index') }}" class="btn btn-outline-secondary flex-1">
                            Kembali
                        </a>
                        <button id="btnSubmitPopulasi" type="submit" class="btn btn-primary flex-1" form="form-populasi-ayam">
                            Simpan
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('data', () => ({}))
    });
</script>
@endsection
