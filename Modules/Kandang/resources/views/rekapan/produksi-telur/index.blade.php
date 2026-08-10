@extends('layouts.dashboard')

@section('title', 'Rekapan Produksi Telur')

@section('content_header')
    <x-page-header title="Rekapan Produksi Telur" :breadcrumbs="['Produksi Telur' => '#', 'Rekapan Produksi Telur' => '']" />
@endsection

@section('content')
<div class="mx-1400">

    <x-filter-panel action="{{ route('overview-produksi-telur') }}" resetUrl="{{ route('overview-produksi-telur') }}">
        <div class="col-12 col-md-4">
            <x-adminlte-input
                type="date"
                name="tanggal"
                label="Tanggal"
                fgroup-class="mb-0 w-100"
                :value="request()->query('tanggal')"
            />
        </div>

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
    </x-filter-panel>

    <div class="card desktop-table d-none d-md-block">
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
                            <td colspan="19">Data Rekapan produksi telur tidak ditemukan.</td>
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
                    <span class="data-label">Umur Ayam</span>
                    <span class="data-value">{{ format_angka($data->umur_ayam) }}</span>
                </div>
                <div class="data-row">
                    <span class="data-label">Jumlah Ayam</span>
                    <span class="data-value">{{ format_angka($data->jumlah_ayam) }}</span>
                </div>
                <div class="data-row">
                    <span class="data-label">Telur Bagus</span>
                    <span class="data-value">{{ format_angka($data->jumlah_telur_bagus) }}</span>
                </div>
                <div class="data-row">
                    <span class="data-label">Telur Putih</span>
                    <span class="data-value">{{ format_angka($data->jumlah_telur_putih) }}</span>
                </div>
                <div class="data-row">
                    <span class="data-label">Telur Reject</span>
                    <span class="data-value">{{ format_angka($data->jumlah_telur_reject) }}</span>
                </div>
                <div class="data-row">
                    <span class="data-label">Total Telur</span>
                    <span class="data-value">{{ format_angka($data->total_jumlah_telur) }}</span>
                </div>
                <div class="data-row">
                    <span class="data-label">Total Berat</span>
                    <span class="data-value">{{ format_angka($data->total_berat_telur) }}</span>
                </div>
                <div class="data-row">
                    <span class="data-label">HHP</span>
                    <span class="data-value">{{ format_angka($data->hhp*100) }}%</span>
                </div>
                <div class="data-row">
                    <span class="data-label">HDP</span>
                    <span class="data-value">{{ format_angka($data->hdp*100) }}%</span>
                </div>
                <div class="data-row">
                    <span class="data-label">FCR</span>
                    <span class="data-value">{{ format_angka($data->fcr) }}</span>
                </div>
                <div class="data-row">
                    <span class="data-label">Egg Weight</span>
                    <span class="data-value">{{ format_angka($data->egg_weight) }}</span>
                </div>
                <div class="data-row">
                    <span class="data-label">Egg Mass</span>
                    <span class="data-value">{{ format_angka($data->egg_mass) }}</span>
                </div>
            </x-mobile-card>
        @empty
            <div class="text-center text-muted p-4">Data Rekapan produksi telur tidak ditemukan.</div>
        @endforelse

        @if ($datas->hasPages())
            <div class="d-flex justify-content-end mt-3">
                {{ $datas->links('components.pagination') }}
            </div>
        @endif
    </div>

</div>
@endsection