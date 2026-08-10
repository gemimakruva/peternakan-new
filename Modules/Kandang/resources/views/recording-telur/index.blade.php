@extends('layouts.dashboard')

@section('title', 'Produksi Telur')

@section('content_header')
<x-page-header title="Produksi Telur" :breadcrumbs="['Produksi Telur' => '']">
    <x-slot name="actions">
        @can('kandang.telur.create-produksi-telur')
            <a href="{{ route('recording-telur.create') }}" class="btn btn-primary">Tambah Produksi Telur</a>
        @endcan
    </x-slot>
</x-page-header>
@endsection

@section('content')
<div class="mx-1200">
    <x-filter-panel action="{{ route('recording-telur.index') }}" resetUrl="{{ route('recording-telur.index') }}">
        <div class="col-12 col-md-4">
            <x-adminlte-input
                label="Tanggal"
                type="date"
                name="tanggal"
                :value="request()->query('tanggal')"
                fgroup-class="mb-0"
            />
        </div>
        <div class="col-12 col-md-4">
            <x-adminlte-select name="kandang_id" fgroup-class="mb-0">
                <x-adminlte-options
                    :options="$listKandang"
                    empty-option="Semua Kandang"
                    :selected="request()->query('kandang_id')"
                />
            </x-adminlte-select>
        </div>
        <div class="col-12 col-md-4">
            <label>Petugas Pencatat</label>
            <input
                type="text"
                name="recorded_by"
                value="{{ request('recorded_by') }}"
                class="form-control"
                placeholder="Petugas Pencatat"
            />
        </div>
    </x-filter-panel>

    <div class="card mt-3 desktop-table d-none d-md-block">
        <div class="card-body table-responsive p-0">
            <table class="table table-bordered table-striped">
                <thead class="text-center">
                    <tr>
                        <th class="align-middle" style="min-width:40px">#</th>
                        <x-sort-th class="align-middle" style="min-width:200px" label="Tanggal Transaksi" name="tanggal" />
                        <x-sort-th class="align-middle" style="min-width:160px" label="Petugas Pencatat" name="" />
                        <x-sort-th class="align-middle" style="min-width:160px" label="Kandang" name="nama_kandang" />
                        <x-sort-th class="align-middle" style="min-width:80px" label="Umur Ayam" name="umur_telur" />
                        <x-sort-th class="align-middle" style="min-width:80px" label="Telur Bagus" name="jumlah_telur_bagus" />
                        <x-sort-th class="align-middle" style="min-width:80px" label="Berat Telur Bagus (kg)" name="berat_telur_bagus" />
                        <x-sort-th class="align-middle" style="min-width:80px" label="Telur Putih" name="jumlah_telur_putih" />
                        <x-sort-th class="align-middle" style="min-width:80px" label="Berat Telur Putih (kg)" name="berat_telur_putih" />
                        <x-sort-th class="align-middle" style="min-width:80px" label="Telur Reject" name="jumlah_telur_reject" />
                        <x-sort-th class="align-middle" style="min-width:80px" label="Berat Telur Reject (kg)" name="berat_telur_reject" />
                        <x-sort-th class="align-middle" style="min-width:80px" label="Total Butir Telur" name="total_jumlah_telur" />
                        <x-sort-th class="align-middle" style="min-width:80px" label="Total Berat Telur (kg)" name="total_berat_telur" />
                        <th class="align-middle" style="min-width:100px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($listProduksiTelur as $item)
                        <tr>
                            <td class="text-right">{{ $listProduksiTelur->firstItem() + $loop->index }}</td>
                            <td>{{ $item->tanggal->translatedFormat('l, d F Y') }}</td>
                            <td>{{ $item->nama_pic_user ?? '-' }}</td>
                            <td>{{ $item->nama_kandang ?? '-' }}</td>
                            <td class="text-right">{{ $item->umur_ayam }}</td>
                            <td class="text-right">{{ format_angka($item->jumlah_telur_bagus, 0) }}</td>
                            <td class="text-right">{{ format_angka($item->berat_telur_bagus) }}</td>
                            <td class="text-right">{{ format_angka($item->jumlah_telur_putih, 0) }}</td>
                            <td class="text-right">{{ format_angka($item->berat_telur_putih) }}</td>
                            <td class="text-right">{{ format_angka($item->jumlah_telur_reject, 0) }}</td>
                            <td class="text-right">{{ format_angka($item->berat_telur_reject) }}</td>
                            <td class="text-right">{{ format_angka($item->total_jumlah_telur, 0) }}</td>
                            <td class="text-right">{{ format_angka($item->total_berat_telur) }}</td>
                            <td class="text-right">
                                <div class="d-flex justify-content-center gap-1">
                                    @can('kandang.telur.edit-produksi-telur')
                                        <a href="{{ route('recording-telur.edit', $item->id) }}"
                                        class="btn btn-warning btn-sm text-white"
                                        title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    @endcan
                                    @can('kandang.telur.detail-produksi-telur')
                                        <a
                                            href="{{ route('recording-telur.show', $item->id) }}"
                                            class="btn btn-info btn-sm text-white"
                                            title="Detail"
                                        >
                                            <div class="fas fa-eye"></div>
                                        </a>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="15" class="text-center text-muted">
                                Belum ada data Pencatatan Telur.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($listProduksiTelur->hasPages())
            <div class="card-footer d-flex justify-content-end">
                {{ $listProduksiTelur->links('components.pagination') }}
            </div>
        @endif
    </div>

    <div class="mobile-card-list d-md-none">
        @forelse ($listProduksiTelur as $item)
            <x-mobile-card
                title="{{ $item->nama_kandang ?? '-' }}"
                subtitle="{{ $item->tanggal->translatedFormat('l, d F Y') }}"
            >
                <div class="data-row">
                    <span class="data-label">Petugas</span>
                    <span class="data-value">{{ $item->nama_pic_user ?? '-' }}</span>
                </div>
                <div class="data-row">
                    <span class="data-label">Umur Ayam</span>
                    <span class="data-value">{{ $item->umur_ayam }}</span>
                </div>
                <div class="data-row">
                    <span class="data-label">Telur Bagus</span>
                    <span class="data-value">{{ format_angka($item->jumlah_telur_bagus, 0) }} ({{ format_angka($item->berat_telur_bagus) }} kg)</span>
                </div>
                <div class="data-row">
                    <span class="data-label">Telur Putih</span>
                    <span class="data-value">{{ format_angka($item->jumlah_telur_putih, 0) }} ({{ format_angka($item->berat_telur_putih) }} kg)</span>
                </div>
                <div class="data-row">
                    <span class="data-label">Telur Reject</span>
                    <span class="data-value">{{ format_angka($item->jumlah_telur_reject, 0) }} ({{ format_angka($item->berat_telur_reject) }} kg)</span>
                </div>
                <div class="data-row">
                    <span class="data-label">Total</span>
                    <span class="data-value">{{ format_angka($item->total_jumlah_telur, 0) }} ({{ format_angka($item->total_berat_telur) }} kg)</span>
                </div>
                <x-slot name="actions">
                    @can('kandang.telur.edit-produksi-telur')
                        <a href="{{ route('recording-telur.edit', $item->id) }}" class="btn btn-warning btn-sm text-white">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                    @endcan
                    @can('kandang.telur.detail-produksi-telur')
                        <a href="{{ route('recording-telur.show', $item->id) }}" class="btn btn-info btn-sm text-white">
                            <i class="fas fa-eye"></i> Detail
                        </a>
                    @endcan
                </x-slot>
            </x-mobile-card>
        @empty
            <div class="text-center text-muted p-4">Belum ada data Pencatatan Telur.</div>
        @endforelse
        @if ($listProduksiTelur->hasPages())
            <div class="d-flex justify-content-end mt-2">
                {{ $listProduksiTelur->links('components.pagination') }}
            </div>
        @endif
    </div>
</div>
@endsection