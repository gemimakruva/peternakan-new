@extends('layouts.dashboard')

@section('title', 'Detail Inventory Telur')

@section('content_header')
<x-page-header title="Detail Inventory Telur" :breadcrumbs="['Telur' => route('gudang-telur.telur-inventory.index'), 'Detail' => '']" />
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

    <x-filter-panel action="{{ route('gudang-telur.telur-inventory.index', request()->all()) }}" resetUrl="{{ route('gudang-telur.telur-inventory.index') }}">
        <div class="col-12 col-md-3">
            <x-adminlte-input type="date" label="Tanggal Awal" name="date_start" :value="$dateStart" fgroup-class="mb-0" />
        </div>
        <div class="col-12 col-md-3">
            <x-adminlte-input type="date" label="Tanggal Akhir" name="date_end" :value="$dateEnd" fgroup-class="mb-0" />
        </div>
        <div class="col-12 col-md-3">
            <input type="search" name="search" class="form-control" placeholder="Pic User ..." value="{{ request()->query('search') }}">
        </div>
    </x-filter-panel>

    <div class="card desktop-table d-none d-md-block">
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
                            <td colspan="7" class="text-center">Data Inventory Telur tidak tersedia</td>
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
            <x-mobile-card title="{{ $data->nama_jenis_telur }}" subtitle="{{ $data->tanggal->translatedFormat('l, d F Y') }}">
                @if($data->tipe == 'masuk')
                    <div class="data-row">
                        <span class="data-label">Masuk</span>
                        <span class="data-value">{{ $data->jumlah }}</span>
                    </div>
                @elseif($data->tipe == 'keluar')
                    <div class="data-row">
                        <span class="data-label">Keluar</span>
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
            <x-empty-state icon="egg" title="Belum Ada Data" description="Data inventory telur tidak tersedia." />
        @endforelse
        @if ($datas->hasPages())
            <div class="d-flex justify-content-end mt-2">
                {{ $datas->links('components.pagination') }}
            </div>
        @endif
    </div>
</div>
@endsection