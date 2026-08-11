@extends('layouts.dashboard')

@section('title', 'Monitoring Kesehatan')

@section('content_header')
<x-page-header title="Monitoring Kesehatan" :breadcrumbs="['Monitoring Kesehatan' => '#']">
    <x-slot name="actions">
        @can('kandang.monitoring.create-monitoring-kesehatan')
            <a href="{{ route('monitoring-kesehatan.create') }}" class="btn btn-primary">
                <i class="fas fa-plus d-md-none"></i>
                <span class="d-none d-md-inline">Tambah Monitoring Kesehatan</span>
            </a>
        @endcan
    </x-slot>
</x-page-header>
@endsection

@section('content')
<div class="mx-1200">
    <x-form-alert />

    <x-filter-panel action="{{ route('monitoring-kesehatan.index') }}" resetUrl="{{ route('monitoring-kesehatan.index') }}">
        <div class="col-12 col-md-4 mb-2 mb-md-0">
            <label class="form-label">Range Tanggal</label>
            <div class="row">
                <div class="col-6">
                    <input type="date" name="start_date" value="{{ request('start_date') }}" class="form-control">
                </div>
                <div class="col-6">
                    <input type="date" name="end_date" value="{{ request('end_date') }}" class="form-control">
                </div>
            </div>
        </div>

        <div class="col-12 col-md-3 mb-2 mb-md-0">
            <label class="form-label">Kandang</label>
            <select name="kandang_id" class="form-control">
                <option selected disabled>Pilih Kandang...</option>
                @foreach ($kandang as $item)
                    <option value="{{ $item->id }}" {{ $item->id == request('kandang_id') ? 'selected' : '' }}>
                        {{ $item->nama }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-12 col-md-3 mb-2 mb-md-0">
            <label class="form-label">Tim Pelaksana</label>
            <input type="text" name="tim_pelaksana" value="{{ request('tim_pelaksana') }}" class="form-control" placeholder="Tim Pelaksana..." />
        </div>
    </x-filter-panel>

    <div class="card mt-3 desktop-table d-none d-md-block">
        <div class="card-body table-responsive p-0">
            <table class="table table-bordered table-striped align-middle">
                <thead class="text-center">
                    <tr>
                        <th>No</th>
                        <th>Tanggal Transaksi</th>
                        <th>Kandang</th>
                        <th>Tim Pelaksana</th>
                        <th>Total Populasi Ayam</th>
                        <th>Jenis Penyakit Ditemukan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($data as $item)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td class="text-center">{{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('l, d F Y') }}</td>
                            <td>{{ $item->kandang->nama ?? '-' }}</td>
                            <td>{{ $item->tim_pelaksana }}</td>
                            <td>{{ $item->total_populasi_ayam }}</td>
                            <td>{{ $item->detail_penyakit_ditemukan }}</td>
                            <td class="text-center">
                                @can('kandang.monitoring.edit-monitoring-kesehatan')
                                    <a href="{{ route('monitoring-kesehatan.edit', $item->id) }}" class="btn btn-warning btn-sm">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                @endcan
                                @can('kandang.monitoring.detail-monitoring-kesehatan')
                                    <a href="{{ route('monitoring-kesehatan.show', $item->id) }}" class="btn btn-info btn-sm">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                @endcan
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="11" class="text-center text-muted">
                                Belum ada data Monitoring Kesehatan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($data->hasPages())
            <div class="card-footer d-flex justify-content-end">
                {{ $data->links('components.pagination') }}
            </div>
        @endif
    </div>

    <div class="mobile-card-list d-md-none">
        @forelse ($data as $item)
            <x-mobile-card
                title="{{ $item->kandang->nama ?? '-' }}"
                subtitle="{{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('l, d F Y') }}"
            >
                <div class="data-row">
                    <span class="data-label">Tim Pelaksana</span>
                    <span class="data-value">{{ $item->tim_pelaksana }}</span>
                </div>
                <div class="data-row">
                    <span class="data-label">Total Populasi</span>
                    <span class="data-value">{{ $item->total_populasi_ayam }}</span>
                </div>
                <div class="data-row">
                    <span class="data-label">Penyakit</span>
                    <span class="data-value">{{ Str::limit($item->detail_penyakit_ditemukan, 40) }}</span>
                </div>
                <x-slot name="actions">
                    @can('kandang.monitoring.edit-monitoring-kesehatan')
                        <a href="{{ route('monitoring-kesehatan.edit', $item->id) }}" class="btn btn-warning btn-sm text-white">
                            <i class="fa fa-edit"></i> Edit
                        </a>
                    @endcan
                    @can('kandang.monitoring.detail-monitoring-kesehatan')
                        <a href="{{ route('monitoring-kesehatan.show', $item->id) }}" class="btn btn-info btn-sm text-white">
                            <i class="fa fa-eye"></i> Detail
                        </a>
                    @endcan
                </x-slot>
            </x-mobile-card>
        @empty
            <x-empty-state icon="chicken" title="Belum Ada Data" description="Belum ada data monitoring kesehatan." />
        @endforelse

        @if ($data->hasPages())
            <div class="d-flex justify-content-end mt-2">
                {{ $data->links('components.pagination') }}
            </div>
        @endif
    </div>
</div>
@endsection