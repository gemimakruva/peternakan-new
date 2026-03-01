@extends('layouts.dashboard')

@section('title', 'Detail Inventory Telur')

@section('content_header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Detail Inventory Telur</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">  
                <li class="breadcrumb-item"><a href="{{ route('gudang-telur.telur-inventory.index') }}">Telur</a></li>
                <li class="breadcrumb-item active">Detail</li>
            </ol>
        </div>
    </div>
</div>
@endsection

@php
    function opname($mutate) {
        if ($mutate > 0) {
            return '+'.((string) $mutate);
        } else if ($mutate < 0) {
            return (string) $mutate;
        } else {
            return '';
        }
    }
@endphp

@section('content')
<div class="mx-1200">
    <x-form-alert />

    <div class="card">
        <div class="card-body">
            <form
                action="{{ route('gudang-telur.telur-inventory.index', request()->all()) }}"
                method="get"
                class="w-100"
            >
                <div class="d-flex gap-2 justify-content-start align-items-end">
                    <x-adminlte-input
                        type="date"
                        label="Tanggal Awal"
                        name="date_start"
                        :value="$dateStart"
                        fgroup-class="mb-0 mx-sm-200"
                    />

                    <x-adminlte-input
                        type="date"
                        label="Tanggal Akhir"
                        name="date_end"
                        :value="$dateEnd"
                        fgroup-class="mb-0 mx-sm-200"
                    />

                    <input 
                        type="search" 
                        name="search" 
                        class="form-control mx-sm-200" 
                        placeholder="Pic User ..."
                        value="{{ request()->query('search') }}"
                    >

                    <button class="btn btn-primary" title="Cari">
                        <i class="fas fa-search"></i>
                    </button>

                    <a href="{{ route('gudang-telur.telur-inventory.index') }}" class="btn btn-secondary">
                        <i class="fas fa-undo"></i>
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body table-responsive p-0">
            <table class="table table-hover table-striped table-bordered text-center mb-0">
                <thead>
                    <tr>
                        <th class="align-middle" style="width: 40px;">#</th>
                        <th class="align-middle" style="width: 150px;">Tanggal</th>
                        <th class="align-middle" style="width: 150px;">Jenis Telur</th>
                        <th class="align-middle" style="width: 150px;">Masuk</th>
                        <th class="align-middle" style="width: 150px;">Keluar</th>
                        <th class="align-middle" style="width: 150px;">Opname</th>
                        <th class="align-middle" style="width: 150px;">Saldo</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($datas as $data)
                        <tr>
                            <td>{{ ($datas->currentPage() - 1) * $datas->perPage() + $loop->iteration }}</td>
                            <td class="text-left">{{ $data->tanggal->translatedFormat('l, d F Y') }}</td>
                            <td class="text-left">{{ $data->nama_jenis_telur }}</td>
                            <td class="text-left">{{ $data->tipe == 'masuk'  ? $data->jumlah : '' }}</td>
                            <td class="text-left">{{ $data->tipe == 'keluar' ? $data->jumlah : '' }}</td>
                            <td class="text-left">{{ $data->tipe == 'opname' ? opname($data->jumlah) : '' }}</td>
                            <td class="text-left">{{ $data->saldo }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Data Inventory Telur tidak tersedia</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($datas->hasPages())
            <div class="card-footer d-flex justify-content-end">
                {{ $datas->links('components.pagination') }}
            </div>
        @endif
    </div>
</div>
@endsection
