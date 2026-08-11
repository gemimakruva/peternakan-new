@extends('layouts.dashboard')

@section('title', 'Rekapan Populasi Ayam')

@section('content_header')
    <x-page-header title="Rekapan Populasi Ayam" :breadcrumbs="['Rekapan Populasi Ayam' => '']" />
@endsection


@section('content')
<div class="mx-1400">
    <x-filter-panel action="{{ route('rekapan-populasi-ayam.index') }}" resetUrl="{{ route('rekapan-produksi.index') }}">
        <div class="col-12 col-md-4">
            <x-adminlte-select
                name="kandang_id"
                fgroup-class="mb-0 w-100"
                placeholder="Semua Kandang"
            >
                <x-adminlte-options
                    :options="$listKandang->toArray()"
                    empty-option="Semua Kandang"
                    :selected="request()->query('kandang_id')"
                />
            </x-adminlte-select>
        </div>
    </x-filter-panel>

    <div class="card desktop-table d-none d-md-block">
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
                            <td colspan="16" class="text-center">Data rekapan ayam tidak tersedia.</td>
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
            <x-mobile-card
                title="{{ $data->nama_kandang }}"
                subtitle="{{ $data->tanggal->translatedFormat('d M Y') }}"
            >
                <div class="data-row">
                    <span class="data-label">Umur</span>
                    <span class="data-value">{{ format_angka($data->umur) }}</span>
                </div>
                <div class="data-row">
                    <span class="data-label">Sehat</span>
                    <span class="data-value">{{ format_angka($data->sehat) }}</span>
                </div>
                <div class="data-row">
                    <span class="data-label">Mati</span>
                    <span class="data-value">{{ format_angka($data->mati) }}</span>
                </div>
                <div class="data-row">
                    <span class="data-label">Akumulasi Mati</span>
                    <span class="data-value">{{ format_angka($data->akumulasi_mati) }}</span>
                </div>
                <div class="data-row">
                    <span class="data-label">% Kematian</span>
                    <span class="data-value">{{ format_angka($data->persen_mati*100) }}%</span>
                </div>
                <div class="data-row">
                    <span class="data-label">Afkir</span>
                    <span class="data-value">{{ format_angka($data->afkir) }}</span>
                </div>
                <div class="data-row">
                    <span class="data-label">Masuk Karantina</span>
                    <span class="data-value">{{ format_angka($data->masuk_karantina) }}</span>
                </div>
                <div class="data-row">
                    <span class="data-label">Keluar Karantina</span>
                    <span class="data-value">{{ format_angka($data->keluar_karantina) }}</span>
                </div>
            </x-mobile-card>
        @empty
            <x-empty-state icon="chart" title="Belum Ada Data" description="Data rekapan ayam tidak tersedia." />
        @endforelse

        @if ($datas->hasPages())
            <div class="d-flex justify-content-end mt-3">
                {{ $datas->links('components.pagination') }}
            </div>
        @endif
    </div>
</div>
@endsection