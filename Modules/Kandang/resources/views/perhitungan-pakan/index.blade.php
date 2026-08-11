@extends('layouts.dashboard')

@section('title', 'Perhitungan Pemberian Pakan')

@section('content_header')
<x-page-header title="Perhitungan Pemberian Pakan" :breadcrumbs="['Pemberian Pakan' => '#', 'Perhitungan Pemberian Pakan' => '']">
    <x-slot name="actions">
        @can('kandang.pakan.create-perhitungan-pemberian-pakan')
            <a href="{{ route('perhitungan-pakan.create') }}" class="btn btn-primary">
                <i class="fas fa-plus d-md-none"></i>
                <span class="d-none d-md-inline">Tambah Perhitungan</span>
            </a>
        @endcan
    </x-slot>
</x-page-header>
@endsection

@section('content')
<div class="mx-1200">
    <x-form-alert />

    <x-filter-panel action="{{ route('perhitungan-pakan.index') }}" resetUrl="{{ route('perhitungan-pakan.index') }}">
        <div class="col-12 col-md-4">
            <select name="kandang_id" class="form-control">
                <option value="" @selected(!request()->query('kandang_id'))>Semua Kandang</option>
                @foreach ($listKandang as $id => $nama)
                    <option value="{{ $id }}" @selected(request()->query('kandang_id') == $id)>{{ $nama }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-12 col-md-4">
            <select name="jenis_pakan_id" class="form-control">
                <option value="" @selected(!request()->query('jenis_pakan_id'))>Semua Jenis Pakan</option>
                @foreach ($listJenisPakan as $id => $nama)
                    <option value="{{ $id }}" @selected(request()->query('jenis_pakan_id') == $id)>{{ $nama }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-12 col-md-4">
            <input type="search" class="form-control" name="search" value="{{ request()->query('search') }}" placeholder="Pencatat, Pelaksana ..."/>
        </div>
    </x-filter-panel>

    <div class="card desktop-table d-none d-md-block">
        <div class="card-body table-responsive p-0">
            <table class="table table-hover table-striped table-bordered text-center">
                <thead class="bg-light">
                    <th style="width: 40px;">#</th>
                    <x-sort-th class="align-middle" label="Tanggal" name="tanggal_pemberian_pakan" />
                    <x-sort-th class="align-middle" label="Nama Kandang" name="nama_kandang" />
                    <x-sort-th class="align-middle" label="Pencatat" name="nama_pencatat" />
                    <x-sort-th class="align-middle" label="Pelaksana" name="nama_pelaksana" />
                    <x-sort-th class="align-middle" label="Jumlah Ayam" name="jumlah_ayam" />
                    <x-sort-th class="align-middle" label="Berat Pakan (Kg)" name="berat_pakan_gram" />
                    <x-sort-th class="align-middle" label="Jenis Pakan" name="nama_jenis_pakan" />
                    <th style="width: 150px;">Aksi</th>
                </thead>
                <tbody>
                    @forelse($datas as $row)
                        <tr>
                            <td class="text-center">{{ ($datas->currentPage() - 1) * $datas->perPage() + $loop->iteration }}</td>
                            <td class="text-left">{{ @$row->tanggal_pemberian_pakan?->translatedFormat('l, d F Y') }}</td>
                            <td class="text-left">{{ $row->nama_kandang }}</td>
                            <td class="text-left">{{ $row->nama_pencatat }}</td>
                            <td class="text-left">{{ $row->nama_pelaksana }}</td>
                            <td class="text-right">{{ format_angka($row->jumlah_ayam, 0) ?? 0 }}</td>
                            <td class="text-right">{{ format_angka($row->berat_pakan_gram/1000) }}</td>
                            <td class="text-left">{{ $row->nama_jenis_pakan }}</td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    @can('kandang.pakan.edit-perhitungan-pemberian-pakan')
                                        <a href="{{ route('perhitungan-pakan.edit', $row) }}" class="btn btn-sm btn-warning text-white" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    @endcan
                                    <a href="{{ route('perhitungan-pakan.show', $row) }}" class="btn btn-sm btn-info" title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center text-muted py-3">
                                Tidak ada data perhitungan pakan ditemukan.
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
                    <span class="data-label">Jumlah Ayam</span>
                    <span class="data-value">{{ format_angka($row->jumlah_ayam, 0) ?? 0 }}</span>
                </div>
                <div class="data-row">
                    <span class="data-label">Berat Pakan</span>
                    <span class="data-value">{{ format_angka($row->berat_pakan_gram/1000) }} Kg</span>
                </div>
                <div class="data-row">
                    <span class="data-label">Pencatat</span>
                    <span class="data-value">{{ $row->nama_pencatat }}</span>
                </div>
                <div class="data-row">
                    <span class="data-label">Pelaksana</span>
                    <span class="data-value">{{ $row->nama_pelaksana }}</span>
                </div>
                <x-slot name="actions">
                    @can('kandang.pakan.edit-perhitungan-pemberian-pakan')
                        <a href="{{ route('perhitungan-pakan.edit', $row) }}" class="btn btn-warning btn-sm text-white">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                    @endcan
                    <a href="{{ route('perhitungan-pakan.show', $row) }}" class="btn btn-info btn-sm text-white">
                        <i class="fas fa-eye"></i> Detail
                    </a>
                </x-slot>
            </x-mobile-card>
        @empty
            <x-empty-state icon="box" title="Belum Ada Data" description="Belum ada data perhitungan pakan." />
        @endforelse

        @if ($datas->hasPages())
            <div class="d-flex justify-content-end mt-3">
                {{ $datas->links('components.pagination') }}
            </div>
        @endif
    </div>
</div>
@endsection