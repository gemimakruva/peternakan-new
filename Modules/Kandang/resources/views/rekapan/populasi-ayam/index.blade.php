@extends('layouts.dashboard')

@section('title', 'Rekapan Populasi Ayam')

@section('content_header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Rekapan Populasi Ayam</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">  
                <li class="breadcrumb-item active">Rekapan Populasi Ayam</li>
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
            <form action="{{ route('rekapan-produksi.index') }}" method="get" class="d-flex gap-2">
                <x-adminlte-select
                    name="kandang_id"
                    class="mx-200"
                    fgroup-class="mb-0"
                    placeholder="Semua Kandang"
                >
                    <x-adminlte-options
                        :options="$listKandang->toArray()"
                        empty-option="Semua Kandang"
                        :selected="request()->query('kandang_id')"
                    />
                </x-adminlte-select>
                <x-adminlte-button icon="fas fa-search" type="submit" theme="primary"  />
                <a href="{{ route('rekapan-produksi.index') }}">
                    <x-adminlte-button icon="fas fa-undo" />
                </a>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body table-responsive p-0">
            <table class="table table-hover table-striped table-bordered text-center mb-0">
                <thead>
                    <tr>
                        <th class="align-middle" style="min-width: 40px;">#</th>
                        <x-sort-th class="align-middle" style="min-width: 150px;" label="Kandang" name="nama_kandang" />
                        <x-sort-th class="align-middle" style="min-width: 200px;" label="Tanggal" name="tanggal" />
                        <th class="align-middle" style="min-width: 80px;">Umur</th>
                        <th class="align-middle" style="min-width: 80px;">Mati</th>
                        <th class="align-middle" style="min-width: 80px;">Akumulasi Kematian (ekor)</th>
                        <th class="align-middle" style="min-width: 80px;">Persentase Kematian (realisasi)</th>
                        <th class="align-middle" style="min-width: 80px;">Afkir</th>
                        <th class="align-middle" style="min-width: 80px;">Akumulasi Afkir (ekor)</th>
                        <th class="align-middle" style="min-width: 80px;">Persentase Afkir (realisasi)</th>
                        <th class="align-middle" style="min-width: 80px;">Akumulasi Kematian + Afkir (ekor)</th>
                        <th class="align-middle" style="min-width: 80px;">Persentase Kematian + Afkir (realisasi)</th>
                        <th class="align-middle" style="min-width: 80px;">Persentase Kematian + Afkir (standar)</th>
                        <th class="align-middle" style="min-width: 80px;">Masuk Karantina</th>
                        <th class="align-middle" style="min-width: 80px;">Keluar Karantina</th>
                        <th class="align-middle" style="min-width: 80px;">Sehat</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($datas as $data)
                        <tr>
                            <td>{{ ($datas->currentPage() - 1) * $datas->perPage() + $loop->iteration }}</td>
                            <td class="text-left">{{ $data->nama_kandang }}</td>
                            <td class="text-left">{{ $data->tanggal->translatedFormat('l, d F Y') }}</td>
                            <td class="text-right">{{ format_angka($data->umur) }}</td>
                            <td class="text-right">{{ format_angka($data->mati) }}</td>
                            <td class="text-right">{{ format_angka($data->akumulasi_mati) }}</td>
                            <td class="text-right">{{ format_angka($data->persen_mati*100) }}%</td>
                            <td class="text-right">{{ format_angka($data->afkir) }}</td>
                            <td class="text-right">{{ format_angka($data->akumulasi_afkir) }}</td>
                            <td class="text-right">{{ format_angka($data->persen_afkir*100) }}%</td>
                            <td class="text-right">{{ format_angka($data->akumulasi_mati_afkir) }}</td>
                            <td class="text-right">{{ format_angka($data->persen_mati_afkir*100) }}%</td>
                            <td class="text-right">{{ format_angka($data->standar_mati_afkir) }}</td>
                            <td class="text-right">{{ format_angka($data->masuk_karantina) }}</td>
                            <td class="text-right">{{ format_angka($data->keluar_karantina) }}</td>
                            <td class="text-right">{{ format_angka($data->sehat) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">Data rekapan ayam tidak tersedia.</td>
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