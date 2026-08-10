@extends('layouts.dashboard')

@section('title', 'Kemasan')

@section('content_header')
<x-page-header title="Kemasan" :breadcrumbs="['Kemasan' => '']">
    <x-slot name="actions">
        <a href="{{ route('gudang-telur.master-data.kemasan.create') }}" class="btn btn-primary">Tambah Kemasan</a>
    </x-slot>
</x-page-header>
@endsection

@section('content')
<div class="mx-1200">
    <x-form-alert />

    <x-filter-panel action="{{ route('gudang-telur.master-data.kemasan.index', request()->all()) }}">
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
                        <x-sort-th class="align-middle" style="min-width: 150px;" label="Kemasan" name="nama" />
                        <th class="align-middle" style="width: 40px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($datas as $data)
                        <tr>
                            <td>{{ ($datas->currentPage() - 1) * $datas->perPage() + $loop->iteration }}</td>
                            <td class="text-left">{{ $data->nama }}</td>
                            <td>
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('gudang-telur.master-data.kemasan.edit', $data->id) }}" class="btn btn-sm btn-warning text-white">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center">Data Kemasan tidak tersedia</td>
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
            <x-mobile-card title="{{ $data->nama }}">
                <x-slot name="actions">
                    <a href="{{ route('gudang-telur.master-data.kemasan.edit', $data->id) }}" class="btn btn-warning btn-sm text-white">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                </x-slot>
            </x-mobile-card>
        @empty
            <p class="text-center text-muted py-3">Data Kemasan tidak tersedia</p>
        @endforelse
        @if ($datas->hasPages())
            <div class="d-flex justify-content-end mt-2">
                {{ $datas->links('components.pagination') }}
            </div>
        @endif
    </div>
</div>
@endsection