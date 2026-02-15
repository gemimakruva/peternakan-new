@extends('layouts.dashboard')

@section('title', 'Produksi Telur')

@section('content_header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <div class="d-flex align-items-center gap-1">
                <h1>Produksi Telur</h1>
                @can('kandang.telur.create-produksi-telur')
                    <a href="{{ route('recording-telur.create') }}" class="btn btn-primary">Tambah Produksi Telur</a>
                @endcan
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
            <form action="{{ route('recording-telur.index') }}" method="GET" class="d-flex gap-3 align-items-end flex-column flex-sm-row">
                <x-adminlte-input
                    label="Tanggal"
                    type="date"
                    name="tanggal"
                    :value="request()->query('tanggal')"
                    fgroup-class="mb-0 w-100 mx-sm-200"
                />

                <x-adminlte-select name="kandang_id" fgroup-class="mb-0 w-100 mx-sm-200">
                    <x-adminlte-options
                        :options="$listKandang"
                        empty-option="Semua Kandang"
                        :selected="request()->query('kandang_id')"
                    />
                </x-adminlte-select>

                <input
                    type="text"
                    name="recorded_by"
                    value="{{ request('recorded_by') }}"
                    class="form-control w-100 mx-sm-200"
                    placeholder="Petugas Pencatat"
                />

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search"></i>
                    </button>

                    <a href="{{ route('recording-telur.index') }}" class="btn btn-secondary">
                        <i class="fas fa-undo"></i>
                    </a>
                </div>
            </form>
        </div>
    </div>
    <div class="card mt-3">
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
</div>
@endsection