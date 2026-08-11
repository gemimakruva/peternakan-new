@extends('layouts.dashboard')

@section('title', 'Pemberian Pakan Sisa Pakan')

@section('content_header')
<x-page-header title="Pemberian Pakan Sisa Pakan" :breadcrumbs="[
    'Pemberian Pakan' => '#',
    'Pemberian Pakan Sisa Pakan' => '',
]" />
@endsection

@section('content')
<div class="mx-1200">
    <x-form-alert />

    <x-filter-panel
        action="{{ route('pemberian-pakan-sisa-pakan.index') }}"
        resetUrl="{{ route('pemberian-pakan-sisa-pakan.index') }}"
    >
        <div class="col-12 col-md-4">
            <x-adminlte-select
                name="kandang_id"
                fgroup-class="mb-0 w-100"
            >
                <x-adminlte-options
                    :options="$listKandang"
                    empty-option="Semua Kandang"
                    :selected="request()->query('kandang_id')"
                />
            </x-adminlte-select>
        </div>

        <div class="col-12 col-md-4">
            <x-adminlte-select
                name="jenis_pakan_id"
                fgroup-class="mb-0 w-100"
            >
                <x-adminlte-options
                    :options="$listJenisPakan"
                    empty-option="Semua Jenis Pakan"
                    :selected="request()->query('jenis_pakan_id')"
                />
            </x-adminlte-select>
        </div>
    </x-filter-panel>

    <div class="card desktop-table d-none d-md-block">
        <div class="card-body table-responsive p-0">
            <table class="table table-hover table-striped table-bordered text-center">
                <thead class="bg-light">
                    <th style="width: 40px;">#</th>
                    <x-sort-th class="align-middle" label="Tanggal" name="tanggal_pemberian_pakan" />
                    <x-sort-th class="align-middle" label="Nama Kandang" name="nama_kandang" />
                    <x-sort-th class="align-middle" label="Jenis Pakan" name="nama_jenis_pakan" />
                    <x-sort-th class="align-middle" label="Pelaksana" name="nama_pelaksana" />
                    <x-sort-th class="align-middle" label="Pemberian Pakan (Kg)" name="pemberian_pakan_kg" />
                    <x-sort-th class="align-middle" label="Sisa Pakan (Kg)" name="sisa_pakan_kg" />
                    <th style="width: 150px;">Aksi</th>
                </thead>
                <tbody>
                    @forelse($datas as $row)
                        <tr>
                            <td class="text-center">{{ ($datas->currentPage() - 1) * $datas->perPage() + $loop->iteration }}</td>
                            <td class="text-left">{{ @$row->tanggal_pemberian_pakan?->translatedFormat('l, d F Y') }}</td>
                            <td class="text-left">{{ $row->nama_kandang }}</td>
                            <td class="text-left">{{ $row->nama_jenis_pakan }}</td>
                            <td class="text-left">{{ $row->nama_pelaksana }}</td>
                            <td class="text-right">{{ format_angka($row->pemberian_pakan_kg) ?? 0 }}</td>
                            <td class="text-right">{{ format_angka($row->sisa_pakan_kg) }}</td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-1">
                                    @can('kandang.pakan.edit-pemberian-pakan-dan-sisa-pakan')
                                        <a href="{{ route('pemberian-pakan-sisa-pakan.edit', $row) }}" class="btn btn-sm btn-warning text-white" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    @endcan
                                    @can('kandang.pakan.detail-pemberian-pakan-dan-sisa-pakan')
                                        <a href="{{ route('pemberian-pakan-sisa-pakan.show', $row) }}" class="btn btn-sm btn-info text-white" title="Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center text-muted py-3">
                                Tidak ada data pemberian pakan sisa pakan ditemukan.
                            </td>
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
        @forelse($datas as $row)
            <x-mobile-card
                title="{{ $row->nama_kandang }}"
                subtitle="{{ @$row->tanggal_pemberian_pakan?->translatedFormat('d M Y') }}"
            >
                <div class="data-row">
                    <span class="data-label">Jenis Pakan</span>
                    <span class="data-value">{{ $row->nama_jenis_pakan }}</span>
                </div>
                <div class="data-row">
                    <span class="data-label">Pelaksana</span>
                    <span class="data-value">{{ $row->nama_pelaksana }}</span>
                </div>
                <div class="data-row">
                    <span class="data-label">Pemberian (Kg)</span>
                    <span class="data-value">{{ format_angka($row->pemberian_pakan_kg) ?? 0 }}</span>
                </div>
                <div class="data-row">
                    <span class="data-label">Sisa (Kg)</span>
                    <span class="data-value">{{ format_angka($row->sisa_pakan_kg) }}</span>
                </div>
                <x-slot name="actions">
                    @can('kandang.pakan.edit-pemberian-pakan-dan-sisa-pakan')
                        <a href="{{ route('pemberian-pakan-sisa-pakan.edit', $row) }}" class="btn btn-sm btn-warning text-white">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                    @endcan
                    @can('kandang.pakan.detail-pemberian-pakan-dan-sisa-pakan')
                        <a href="{{ route('pemberian-pakan-sisa-pakan.show', $row) }}" class="btn btn-sm btn-info text-white">
                            <i class="fas fa-eye"></i> Detail
                        </a>
                    @endcan
                </x-slot>
            </x-mobile-card>
        @empty
            <x-empty-state icon="box" title="Belum Ada Data" description="Belum ada data pemberian pakan." />
        @endforelse

        @if ($datas->hasPages())
            <div class="d-flex justify-content-end mt-3">
                {{ $datas->links('components.pagination') }}
            </div>
        @endif
    </div>
</div>
@endsection