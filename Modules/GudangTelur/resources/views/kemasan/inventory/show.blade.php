@extends('layouts.dashboard')

@section('title', 'Detail Inventory Kemasan')

@section('content_header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Detail Inventory Kemasan</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">  
                <li class="breadcrumb-item"><a href="{{ route('gudang-telur.kemasan-inventory.index') }}">Kemasan</a></li>
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
        <div class="card-header text-white d-flex justify-content-between align-items-center">
            <form
                action="{{ route('gudang-telur.kemasan-inventory.show', array_merge(['kemasanId' => @$data->id], request()->all())) }}"
                method="get"
                class="w-100"
            >
                <div class="d-flex gap-2 justify-content-start align-items-end">
                    <input 
                        type="search" 
                        name="search" 
                        class="form-control mx-sm-200" 
                        placeholder="Nama Kemasan ..."
                        value="{{ request()->query('search') }}"
                    >

                    <button class="btn btn-primary" title="Cari">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </form>
        </div>

        <div class="card-body table-responsive p-0">
            <table class="table table-hover table-striped table-bordered text-center mb-0">
                <thead>
                    <tr>
                        <th class="align-middle" style="width: 40px;">#</th>
                        <th class="align-middle" style="width: 150px;">Tanggal</th>
                        <th class="align-middle" style="width: 150px;">Nama Kemasan</th>
                        <th class="align-middle" style="width: 150px;">Input</th>
                        <th class="align-middle" style="width: 150px;">Output</th>
                        <th class="align-middle" style="width: 150px;">Opname</th>
                        <th class="align-middle" style="width: 150px;">Saldo</th>
                        {{-- <th class="align-middle" style="width: 40px;">Aksi</th> --}}
                    </tr>
                </thead>
                <tbody>
                    @forelse($datas as $data)
                        <tr>
                            <td>{{ ($datas->currentPage() - 1) * $datas->perPage() + $loop->iteration }}</td>
                            <td class="text-left">{{ $data->tanggal->translatedFormat('l, d F Y') }}</td>
                            <td class="text-left">{{ $data->nama_kemasan }}</td>
                            <td class="text-left">{{ $data->tipe == 'input'  ? $data->jumlah : '' }}</td>
                            <td class="text-left">{{ $data->tipe == 'output' ? $data->jumlah : '' }}</td>
                            <td class="text-left">{{ $data->tipe == 'opname' ? opname($data->jumlah) : '' }}</td>
                            <td class="text-left">{{ $data->saldo }}</td>
                            {{-- <td>
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('gudang-telur.kemasan-inventory.show', $data->kemasan_id) }}" class="btn btn-sm btn-warning text-white">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </div>
                            </td> --}}
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Data Inventory Kemasan tidak tersedia</td>
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
