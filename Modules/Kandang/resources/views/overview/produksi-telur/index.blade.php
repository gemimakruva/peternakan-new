@extends('layouts.dashboard')

@section('title', 'Overview Produksi Telur')

@section('content_header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Overview Produksi Telur</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item active">Produksi Telur</li>
                <li class="breadcrumb-item active">Overview Produksi Telur</li>
            </ol>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="mx-1400">

    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Filter</h2>
        </div>
        <div class="card-body">
            <form
                action="{{ route('overview-produksi-telur') }}"
                method="get"
                class="d-flex gap-3 align-items-end flex-column flex-sm-row"
            >
                <x-adminlte-input
                    type="date"
                    name="tanggal"
                    label="Tanggal"
                    fgroup-class="mb-0 w-100 mx-sm-200"
                    :value="request()->query('tanggal')"
                />

                <x-adminlte-select
                    name="kandang_id"
                    fgroup-class="mb-0 w-100 mx-sm-200"
                >
                    <x-adminlte-options
                        :options="$listKandang"
                        empty-option="Semua Kandang"
                        :selected="request()->query('kandang_id')"
                    />
                </x-adminlte-select>

                <div class="d-flex gap-2">
                    <x-adminlte-button type="submit" theme="primary" icon="fas fa-search" />

                    <a href="{{ route('overview-produksi-telur') }}" class="btn btn-secondary">
                        <i class="fas fa-undo"></i>
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body table-responsive p-0">
            <table class="table table-hover table-striped table-bordered text-center mb-0">
                <thead>
                    <tr>
                        <th class="align-middle" style="width: 40px;">#</th>
                        <x-sort-th class="align-middle" style="min-width: 180px;" label="Kandang" name="nama_kandang" />
                        <x-sort-th class="align-middle" style="min-width: 200px;" label="Tanggal" name="tanggal" />
                        <x-sort-th class="align-middle" style="min-width: 80px;" label="Umur Ayam" name="umur_ayam" />
                        <x-sort-th class="align-middle" style="min-width: 80px;" label="Jumlah Ayam Pengadaan" name="jumlah_ayam_pengadaan" />
                        <x-sort-th class="align-middle" style="min-width: 80px;" label="Jumlah Ayam" name="jumlah_ayam" />
                        <x-sort-th class="align-middle" style="min-width: 80px;" label="Jumlah Telur Bagus" name="jumlah_telur_bagus" />
                        <x-sort-th class="align-middle" style="min-width: 80px;" label="Jumlah Telur Putih" name="jumlah_telur_putih" />
                        <x-sort-th class="align-middle" style="min-width: 80px;" label="Jumlah Telur Reject" name="jumlah_telur_reject" />
                        <x-sort-th class="align-middle" style="min-width: 80px;" label="Total Jumlah Telur" name="total_jumlah_telur" />
                        <x-sort-th class="align-middle" style="min-width: 80px;" label="Berat Telur Bagus" name="berat_telur_bagus" />
                        <x-sort-th class="align-middle" style="min-width: 80px;" label="Berat Telur Putih" name="berat_telur_putih" />
                        <x-sort-th class="align-middle" style="min-width: 80px;" label="Berat Telur Reject" name="berat_telur_reject" />
                        <x-sort-th class="align-middle" style="min-width: 80px;" label="Total Berat Telur" name="total_berat_telur" />
                        <x-sort-th class="align-middle" style="min-width: 80px;" label="HHP" name="hhp" />
                        <x-sort-th class="align-middle" style="min-width: 80px;" label="HDP" name="hdp" />
                        <x-sort-th class="align-middle" style="min-width: 80px;" label="FCR" name="fcr" />
                        <x-sort-th class="align-middle" style="min-width: 80px;" label="Egg Weight" name="egg_weight" />
                        <x-sort-th class="align-middle" style="min-width: 80px;" label="Egg Mass" name="egg_mass" />
                    </tr>
                </thead>
                <tbody>
                    @forelse($datas as $data)
                        <tr>
                            <td>{{ ($datas->currentPage() - 1) * $datas->perPage() + $loop->iteration }}</td>
                            <td class="text-left">{{ $data->nama_kandang }}</td>
                            <td class="text-left">{{ $data->tanggal->translatedFormat('l, d F Y') }}</td>
                            <td class="text-right">{{ format_angka($data->umur_ayam) }}</td>
                            <td class="text-right">{{ format_angka($data->jumlah_ayam_pengadaan) }}</td>
                            <td class="text-right">{{ format_angka($data->jumlah_ayam) }}</td>
                            <td class="text-right">{{ format_angka($data->jumlah_telur_bagus) }}</td>
                            <td class="text-right">{{ format_angka($data->jumlah_telur_putih) }}</td>
                            <td class="text-right">{{ format_angka($data->jumlah_telur_reject) }}</td>
                            <td class="text-right">{{ format_angka($data->total_jumlah_telur) }}</td>
                            <td class="text-right">{{ format_angka($data->berat_telur_bagus) }}</td>
                            <td class="text-right">{{ format_angka($data->berat_telur_putih) }}</td>
                            <td class="text-right">{{ format_angka($data->berat_telur_reject) }}</td>
                            <td class="text-right">{{ format_angka($data->total_berat_telur) }}</td>
                            <td class="text-right">{{ format_angka($data->hhp*100) }}%</td>
                            <td class="text-right">{{ format_angka($data->hdp*100) }}%</td>
                            <td class="text-right">{{ format_angka($data->fcr) }}</td>
                            <td class="text-right">{{ format_angka($data->egg_weight) }}</td>
                            <td class="text-right">{{ format_angka($data->egg_mass) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3">Data overview produksi telur tidak ditemukan.</td>
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

</div>
@endsection