@extends('layouts.dashboard')

@section('title', 'Detail Inventory Kemasan')

@section('content_header')
<x-page-header title="Detail Inventory Kemasan" :breadcrumbs="['Kemasan' => route('gudang-telur.kemasan-inventory.index'), 'Detail' => '']" />
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

    <x-filter-panel action="{{ route('gudang-telur.kemasan-inventory.show', array_merge(['kemasanId' => @$data->id], request()->all())) }}">
        <div class="col-12 col-md-4">
            <input type="search" name="search" class="form-control" placeholder="Nama Kemasan ..." value="{{ request()->query('search') }}">
        </div>
    </x-filter-panel>

    <div class="card desktop-table d-none d-md-block">
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
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">Data Inventory Kemasan tidak tersedia</td>
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

    <div class="mobile-card-list d-md-none">
        @forelse($datas as $data)
            <x-mobile-card title="{{ $data->nama_kemasan }}" subtitle="{{ $data->tanggal->translatedFormat('l, d F Y') }}">
                @if($data->tipe == 'input')
                    <div class="data-row">
                        <span class="data-label">Input</span>
                        <span class="data-value">{{ $data->jumlah }}</span>
                    </div>
                @elseif($data->tipe == 'output')
                    <div class="data-row">
                        <span class="data-label">Output</span>
                        <span class="data-value">{{ $data->jumlah }}</span>
                    </div>
                @elseif($data->tipe == 'opname')
                    <div class="data-row">
                        <span class="data-label">Opname</span>
                        <span class="data-value">{{ opname($data->jumlah) }}</span>
                    </div>
                @endif
                <div class="data-row">
                    <span class="data-label">Saldo</span>
                    <span class="data-value">{{ $data->saldo }}</span>
                </div>
            </x-mobile-card>
        @empty
            <p class="text-center text-muted py-3">Data Inventory Kemasan tidak tersedia</p>
        @endforelse
        @if ($datas->hasPages())
            <div class="d-flex justify-content-end mt-2">
                {{ $datas->links('components.pagination') }}
            </div>
        @endif
    </div>
</div>
@endsection