@extends('layouts.dashboard')

@section('title', 'Inventory Kemasan')

@section('content_header')
<x-page-header title="Kemasan" :breadcrumbs="['Kemasan' => route('gudang-telur.kemasan-inventory.index'), 'Inventory' => '']" />
@endsection

@section('content')
<div class="mx-1000">
    <x-form-alert />

    <x-filter-panel action="{{ route('gudang-telur.kemasan-inventory.index', request()->all()) }}">
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
                        <x-sort-th class="align-middle" style="min-width: 150px;" label="Nama Kemasan" name="nama_kemasan" />
                        <x-sort-th class="align-middle" style="min-width: 150px;" label="Stok" name="stok" />
                        <x-sort-th class="align-middle" style="min-width: 150px;" label="Terakhir Diperbarui" name="tanggal" />
                        <th class="align-middle" style="width: 40px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($datas as $data)
                        <tr>
                            <td>{{ ($datas->currentPage() - 1) * $datas->perPage() + $loop->iteration }}</td>
                            <td class="text-left">{{ $data->nama_kemasan }}</td>
                            <td class="text-left">{{ $data->stok }}</td>
                            <td class="text-left">{{ $data->tanggal->translatedFormat('l, d F Y') }}</td>
                            <td>
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('gudang-telur.kemasan-inventory.show', $data->kemasan_id) }}" class="btn btn-sm btn-warning text-white">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">Data Supplier tidak tersedia</td>
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
                <div class="data-row">
                    <span class="data-label">Stok</span>
                    <span class="data-value">{{ $data->stok }}</span>
                </div>
                <x-slot name="actions">
                    <a href="{{ route('gudang-telur.kemasan-inventory.show', $data->kemasan_id) }}" class="btn btn-warning btn-sm text-white">
                        <i class="fas fa-eye"></i> Detail
                    </a>
                </x-slot>
            </x-mobile-card>
        @empty
            <x-empty-state icon="box" title="Belum Ada Data" description="Data inventory kemasan tidak tersedia." />
        @endforelse
        @if ($datas->hasPages())
            <div class="d-flex justify-content-end mt-2">
                {{ $datas->links('components.pagination') }}
            </div>
        @endif
    </div>
</div>
@endsection