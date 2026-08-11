@extends('layouts.dashboard')

@section('title', 'Rekapan Produksi')

@section('content_header')
    <x-page-header title="Rekapan Produksi" :breadcrumbs="['Rekapan Produksi' => '']" />
@endsection


@section('content')
<div class="mx-1400">
    <x-filter-panel action="{{ route('rekapan-produksi.index') }}" resetUrl="{{ route('rekapan-produksi.index') }}">
        <div class="col-12 col-sm-auto">
            <x-adminlte-select name="kandang_id" fgroup-class="mb-0">
                <x-adminlte-options :options="$listKandang" empty-option="Semua Kandang" :selected="request()->query('kandang_id')" />
            </x-adminlte-select>
        </div>
        <div class="col-12 col-sm-auto">
            <x-adminlte-input type="date" name="tanggal" fgroup-class="mb-0" :value="request()->query('tanggal')" />
        </div>
        <div class="col-12 col-sm-auto">
            <a href="{{ route('rekapan-produksi.index.export') }}" class="btn btn-primary">
                <i class="fas fa-file-excel"></i> Export
            </a>
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

                        <x-sort-th class="align-middle" style="min-width: 80px;" label="Pemberian" name="pemberian_kg" />
                        <x-sort-th class="align-middle" style="min-width: 80px;" label="Sisa" name="sisa_kg" />
                        <x-sort-th class="align-middle" style="min-width: 80px;" label="Konsumsi" name="feed_intake_kg" />
                        <x-sort-th class="align-middle" style="min-width: 80px;" label="Konsumsi per Ekor (realisasi)" name="feed_intake_per_ekor" />
                        <x-sort-th class="align-middle" style="min-width: 80px;" label="Konsumsi per Ekor (standar)" name="feed_intake_per_ekor_standar" />
                        <th class="align-middle" style="min-width: 80px;">Konsumsi per Kandang (realisasi)</th>
                        <th class="align-middle" style="min-width: 80px;">Konsumsi per Kandang (standar)</th>

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

                        <th style="min-width: 40px;">Aksi</th>
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

                            <td class="text-right">{{ format_angka($data->pemberian_kg) }}</td>
                            <td class="text-right">{{ format_angka($data->sisa_kg) }}</td>
                            <td class="text-right">{{ format_angka($data->feed_intake_kg) }}</td>
                            <td class="text-right">{{ format_angka($data->feed_intake_per_ekor) }}</td>
                            <td class="text-right">{{ format_angka($data->feed_intake_per_ekor_standar) }}</td>
                            <td class="text-right">{{ format_angka(($data->feed_intake_per_ekor * $data->jumlah_ayam)/1000) }}</td>
                            <td class="text-right">{{ format_angka(($data->feed_intake_per_ekor_standar * $data->jumlah_ayam)/1000) }}</td>

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

                            <td>
                                <div class="d-flex justify-content-between">
                                    <a
                                        href="{{ route('rekapan-produksi.detail', [ 'tanggal' => $data->tanggal->format('Y-m-d'), 'kandang_id' => $data->kandang_id ]) }}"
                                        class="btn btn-info btn-sm"
                                    >
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="39" class="text-center">Data rekapan ayam tidak tersedia.</td>
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
                    <span class="data-label">Afkir</span>
                    <span class="data-value">{{ format_angka($data->afkir) }}</span>
                </div>
                <div class="data-row">
                    <span class="data-label">Konsumsi (kg)</span>
                    <span class="data-value">{{ format_angka($data->feed_intake_kg) }}</span>
                </div>
                <div class="data-row">
                    <span class="data-label">Total Telur</span>
                    <span class="data-value">{{ format_angka($data->total_jumlah_telur) }}</span>
                </div>
                <div class="data-row">
                    <span class="data-label">Total Berat Telur</span>
                    <span class="data-value">{{ format_angka($data->total_berat_telur) }}</span>
                </div>
                <div class="data-row">
                    <span class="data-label">HDP</span>
                    <span class="data-value">{{ format_angka($data->hdp*100) }}%</span>
                </div>
                <div class="data-row">
                    <span class="data-label">FCR</span>
                    <span class="data-value">{{ format_angka($data->fcr) }}</span>
                </div>
                <x-slot name="actions">
                    <a
                        href="{{ route('rekapan-produksi.detail', [ 'tanggal' => $data->tanggal->format('Y-m-d'), 'kandang_id' => $data->kandang_id ]) }}"
                        class="btn btn-info btn-sm"
                    >
                        <i class="fas fa-eye"></i> Detail
                    </a>
                </x-slot>
            </x-mobile-card>
        @empty
            <div class="text-center text-muted p-4">Data rekapan ayam tidak tersedia.</div>
        @endforelse

        @if ($datas->hasPages())
            <div class="d-flex justify-content-end mt-3">
                {{ $datas->links('components.pagination') }}
            </div>
        @endif
    </div>
</div>
@endsection