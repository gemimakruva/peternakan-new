@extends('layouts.dashboard')

@section('title', 'Inventory Pakan Jadi')

@section('content_header')
    <x-page-header title="Inventory Pakan Jadi" :breadcrumbs="['Pakan Jadi' => '#', 'Inventory' => '']" />
@endsection

@section('content')
<div class="mx-1000">
    <x-form-alert />

    <x-filter-panel action="{{ route('gudang-pakan.pakan-finished-good-inventory.index') }}" resetUrl="{{ route('gudang-pakan.pakan-finished-good-inventory.index') }}">
        <div class="col-12 col-md-4">
            <input
                type="search"
                name="search"
                class="form-control"
                placeholder="Nama Formulasi ..."
                value="{{ request()->query('search') }}"
            >
        </div>
    </x-filter-panel>

    <div class="card desktop-table d-none d-md-block">
        <div class="card-body table-responsive p-0">
            <table class="table table-hover table-striped table-bordered text-center mb-0">
                <thead>
                    <tr>
                        <th class="align-middle" style="width: 40px;">#</th>
                        <x-sort-th class="align-middle" style="min-width: 150px;" label="Formulasi" name="nama_formulasi" />
                        <x-sort-th class="align-middle" style="min-width: 150px;" label="Jumlah" name="jumlah" />
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($datas as $data)
                        <tr>
                            <td>{{ ($datas->currentPage() - 1) * $datas->perPage() + $loop->iteration }}</td>
                            <td class="text-left">{{ $data->nama_formulasi }}</td>
                            <td class="text-right">{{ format_angka($data->jumlah) }}</td>
                            <td class="text-center">
                                <a href="{{ route('gudang-pakan.pakan-finished-good-inventory.show', $data->id) }}" class="btn btn btn-info btn-sm">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center">Data Inventory Pakan Jadi tidak tersedia</td>
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
            <x-mobile-card title="{{ $data->nama_formulasi }}">
                <div class="data-row">
                    <span class="data-label">Jumlah</span>
                    <span class="data-value">{{ format_angka($data->jumlah) }}</span>
                </div>
                <x-slot name="actions">
                    <a href="{{ route('gudang-pakan.pakan-finished-good-inventory.show', $data->id) }}" class="btn btn-info btn-sm">
                        <i class="fas fa-eye"></i> Detail
                    </a>
                </x-slot>
            </x-mobile-card>
        @empty
            <x-empty-state icon="box" title="Belum Ada Data" description="Data inventory pakan jadi tidak tersedia." />
        @endforelse
        @if ($datas->hasPages())
            <div class="d-flex justify-content-end mt-3">
                {{ $datas->links('components.pagination') }}
            </div>
        @endif
    </div>
</div>
@endsection
