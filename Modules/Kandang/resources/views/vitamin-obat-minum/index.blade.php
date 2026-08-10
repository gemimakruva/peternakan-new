@extends('adminlte::page')

@section('title', 'Vitamin Obat Minum')

@section('content_header')
    <x-page-header title="Vitamin Obat Minum" :breadcrumbs="['Vitamin Obat Minum' => '']" />
@endsection

@section('content')
    <x-form-alert />
    <div class="card" style="max-width:1200px">
        <div class="card-header">
            <h3 class="card-title">Filter Data Pencatatan</h3>
        </div>

        <div class="card-body">
            <form action="" method="GET" class="row g-2 align-items-end">
                <div class="col-12 col-md-4">
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

                <div class="col-12 col-md-3">
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

                <div class="col-12 col-md-3">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search"></i>
                    </button>
                    <a href="{{ route('perhitungan-obat.vitamin-obat-minum.index') }}" class="btn btn-secondary">
                        <i class="fas fa-undo"></i>
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="card mt-3 desktop-table d-none d-md-block" style="max-width:1200px">
        <div class="card-body table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead class="text-center" style="background-color: #495057; border-color: #495057; color: white;">
                    <tr>
                        <th>No</th>
                        <th>Tanggal Transaksi</th>
                        <th>Kandang</th>
                        <th>Flock</th>
                        <th>Jumlah Ayam per Flock</th>
                        <th>Jumlah Air di Tong(liter) per Flock</th>
                        <th>Jumlah OVK per Flock</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($data as $item)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td class="text-center">{{ \Carbon\Carbon::parse($item->tanggal)
                ->translatedFormat('l, d F Y') }}</td>
                            <td>{{ $item->flock->kandang->nama ?? '-' }}</td>
                            <td>{{ $item->flock->nama ?? '-' }}</td>
                            <td>{{ $item->jumlah_ayam_per_flock }}</td>
                            <td>{{ $item->jumlah_air_di_tong_per_flock }}</td>
                            <td>{{ $item->jumlah_ovk_per_flock }}</td>
                            <td class="text-center">
                                <a href="{{ route('perhitungan-obat.vitamin-obat-minum.edit', $item->id) }}" class="btn btn-info btn-sm">
                                    <i class="fa fa-eye"></i> Edit
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="11" class="text-center text-muted">
                                Belum ada data Vitamin Obat Minum.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="d-flex justify-content-end mt-3">
                {{ $data->links() }}
            </div>
        </div>
    </div>

    <div class="mobile-card-list d-md-none">
        @forelse ($data as $item)
            <x-mobile-card
                title="{{ $item->flock->kandang->nama ?? '-' }}"
                subtitle="{{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d M Y') }}"
            >
                <div class="data-row">
                    <span class="data-label">Flock</span>
                    <span class="data-value">{{ $item->flock->nama ?? '-' }}</span>
                </div>
                <div class="data-row">
                    <span class="data-label">Jumlah Ayam</span>
                    <span class="data-value">{{ $item->jumlah_ayam_per_flock }}</span>
                </div>
                <div class="data-row">
                    <span class="data-label">Air di Tong (liter)</span>
                    <span class="data-value">{{ $item->jumlah_air_di_tong_per_flock }}</span>
                </div>
                <div class="data-row">
                    <span class="data-label">Jumlah OVK</span>
                    <span class="data-value">{{ $item->jumlah_ovk_per_flock }}</span>
                </div>
                <x-slot name="actions">
                    <a href="{{ route('perhitungan-obat.vitamin-obat-minum.edit', $item->id) }}" class="btn btn-info btn-sm">
                        <i class="fa fa-eye"></i> Edit
                    </a>
                </x-slot>
            </x-mobile-card>
        @empty
            <div class="text-center text-muted p-4">Belum ada data Vitamin Obat Minum.</div>
        @endforelse

        @if ($data->hasPages())
            <div class="d-flex justify-content-end mt-3">
                {{ $data->links() }}
            </div>
        @endif
    </div>
@endsection
@push('js')
@endpush