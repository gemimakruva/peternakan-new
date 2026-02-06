@extends('layouts.dashboard')

@section('title', 'Produksi Telur')

@section('content_header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <div class="d-flex align-items-center gap-1">
                <h1>Produksi Telur</h1>
                <a href="{{ route('recording-telur.create') }}" class="btn btn-primary">Tambah Produksi Telur</a>
            </div>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">  
                <li class="breadcrumb-item active">Produksi Telur</li>
            </ol>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="mx-1200">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Filter</h3>
        </div>
    
        <div class="card-body">
            <form action="{{ route('recording-telur.index') }}" method="GET" class="d-flex gap-2 align-items-end">
                <div>
                    <label class="form-label">Range Tanggal</label>
                    <div class="d-flex">
                        <input type="date" name="tanggal_mulai" value="{{ request('tanggal_mulai') }}" class="form-control">
                        <span class="mx-2 align-self-center">s/d</span>
                        <input type="date" name="tanggal_selesai" value="{{ request('tanggal_selesai') }}" class="form-control">
                    </div>
                </div>

                <x-adminlte-select name="kandang_id" fgroup-class="mb-0 mx-200">
                    <x-adminlte-options
                        :options="$listKandang"
                        empty-option="Semua Kandang"
                        :selected="request()->query('kandang_id')"
                    />
                </x-adminlte-select>

                <input type="text" name="recorded_by" value="{{ request('recorded_by') }}" class="form-control mx-200" placeholder="Nama Pencatat">

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-search"></i>
                </button>

                <a href="{{ route('recording-telur.index') }}" class="btn btn-secondary">
                    <i class="fas fa-undo"></i>
                </a>
            </form>
        </div>
    </div>
    <div class="card mt-3">
        <div class="card-body table-responsive p-0">
            <table class="table table-bordered table-striped">
                <thead class="text-center">
                    <tr>
                        <th class="align-middle" style="min-width:40px">#</th>
                        <th class="align-middle" style="min-width:200px">Tanggal Transaksi</th>
                        <th class="align-middle" style="min-width:160px">Petugas Pencatat</th>
                        <th class="align-middle" style="min-width:160px">Kandang</th>
                        <th class="align-middle" style="min-width:80px">Umur Ayam</th>
                        <th class="align-middle" style="min-width:80px">Telur Bagus</th>
                        <th class="align-middle" style="min-width:80px">Berat Telur Bagus (kg)</th>
                        <th class="align-middle" style="min-width:80px">Telur Putih</th>
                        <th class="align-middle" style="min-width:80px">Berat Telur Putih (kg)</th>
                        <th class="align-middle" style="min-width:80px">Telur Reject</th>
                        <th class="align-middle" style="min-width:80px">Berat Telur Reject (kg)</th>
                        <th class="align-middle" style="min-width:80px">Total Butir Telur</th>
                        <th class="align-middle" style="min-width:80px">Total Berat Telur (kg)</th>
                        <th class="align-middle" style="min-width:100px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($listProduksiTelur as $item)
                        <tr>
                            <td class="text-right">{{ $listProduksiTelur->firstItem() + $loop->index }}</td>
                            <td>{{ $item->tanggal->translatedFormat('l, d F Y') }}</td>
                            <td>{{ $item->picUser->name ?? '-' }}</td>
                            <td>{{ $item->kandang->nama ?? '-' }}</td>
                            <td class="text-right">{{ $item->umur_ayam }}</td>
                            <td class="text-right">{{ format_angka($item->produksiTelurItems->sum('jumlah_telur_bagus'), 0) }}</td>
                            <td class="text-right">{{ format_angka($item->produksiTelurItems->sum('berat_telur_bagus')) }}</td>
                            <td class="text-right">{{ format_angka($item->produksiTelurItems->sum('jumlah_telur_putih'), 0) }}</td>
                            <td class="text-right">{{ format_angka($item->produksiTelurItems->sum('berat_telur_putih')) }}</td>
                            <td class="text-right">{{ format_angka($item->produksiTelurItems->sum('jumlah_telur_reject'), 0) }}</td>
                            <td class="text-right">{{ format_angka($item->produksiTelurItems->sum('berat_telur_reject')) }}</td>
                            <td class="text-right">
                                {{format_angka(
                                    $item->produksiTelurItems->sum('jumlah_telur_bagus')
                                    + $item->produksiTelurItems->sum('jumlah_telur_putih')
                                    + $item->produksiTelurItems->sum('jumlah_telur_reject')
                                    , 0
                                )}}
                            </td>
                            <td class="text-right">
                                {{format_angka(
                                    $item->produksiTelurItems->sum('berat_telur_bagus')
                                    + $item->produksiTelurItems->sum('berat_telur_putih')
                                    + $item->produksiTelurItems->sum('berat_telur_reject')
                                    , 0
                                )}}
                            </td>
                            <td class="text-right">
                                <div class="d-flex justify-content-center">
                                    <a href="{{ route('recording-telur.edit', $item->id) }}" 
                                       class="btn btn-warning btn-sm mr-2 text-white" 
                                       title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
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
</div>
@endsection