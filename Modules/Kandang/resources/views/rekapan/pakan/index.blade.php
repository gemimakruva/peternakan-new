@extends('layouts.dashboard')

@section('title', 'Rekapan Pakan Harian')

@section('content_header')
    <x-page-header title="Rekapan Pakan Harian" :breadcrumbs="['Pemberian Pakan' => '#', 'Rekapan Pakan Harian' => '']" />
@endsection

@section('content')
<div class="mx-1200">

    <x-filter-panel action="{{ route('overview-pakan-harian') }}" resetUrl="{{ route('overview-pakan-harian') }}">
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
                        <x-sort-th class="align-middle" style="min-width: 200px;" label="Tanggal" name="tanggal_pemberian_pakan" />
                        <x-sort-th class="align-middle" style="min-width: 80px;" label="Umur Ayam" name="umur_ayam" />
                        <x-sort-th class="align-middle" style="min-width: 80px;" label="Jumlah Ayam" name="jumlah_ayam" />
                        <x-sort-th class="align-middle" style="min-width: 80px;" label="Pemberian" name="pemberian_kg" />
                        <x-sort-th class="align-middle" style="min-width: 80px;" label="Sisa" name="sisa_kg" />
                        <x-sort-th class="align-middle" style="min-width: 80px;" label="Konsumsi" name="feed_intake_kg" />
                        <x-sort-th class="align-middle" style="min-width: 80px;" label="Konsumsi per Ekor (realisasi)" name="feed_intake_per_ekor" />
                        <x-sort-th class="align-middle" style="min-width: 80px;" label="Konsumsi per Ekor (standar)" name="feed_intake_per_ekor_standar" />
                        <th class="align-middle" style="min-width: 80px;">Konsumsi per Kandang (realisasi)</th>
                        <th class="align-middle" style="min-width: 80px;">Konsumsi per Kandang (standar)</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($datas as $data)
                        <tr>
                            <td>{{ ($datas->currentPage() - 1) * $datas->perPage() + $loop->iteration }}</td>
                            <td class="text-left">{{ $data->nama_kandang }}</td>
                            <td class="text-left">{{ $data->tanggal_pemberian_pakan->translatedFormat('l, d F Y') }}</td>
                            <td class="text-right">{{ format_angka($data->umur_ayam) }}</td>
                            <td class="text-right">{{ format_angka($data->jumlah_ayam) }}</td>
                            <td class="text-right">{{ format_angka($data->pemberian_kg) }}</td>
                            <td class="text-right">{{ format_angka($data->sisa_kg) }}</td>
                            <td class="text-right">{{ format_angka($data->feed_intake_kg) }}</td>
                            <td class="text-right">{{ format_angka($data->feed_intake_per_ekor) }}</td>
                            <td class="text-right">{{ format_angka($data->feed_intake_per_ekor_standar) }}</td>
                            <td class="text-right">{{ format_angka(($data->feed_intake_per_ekor * $data->jumlah_ayam)/1000) }}</td>
                            <td class="text-right">{{ format_angka(($data->feed_intake_per_ekor_standar * $data->jumlah_ayam)/1000) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="12">Data rekapan pakan harian tidak ditemukan.</td>
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
                subtitle="{{ $data->tanggal_pemberian_pakan->translatedFormat('d M Y') }}"
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
                    <span class="data-label">Pemberian (kg)</span>
                    <span class="data-value">{{ format_angka($data->pemberian_kg) }}</span>
                </div>
                <div class="data-row">
                    <span class="data-label">Sisa (kg)</span>
                    <span class="data-value">{{ format_angka($data->sisa_kg) }}</span>
                </div>
                <div class="data-row">
                    <span class="data-label">Konsumsi (kg)</span>
                    <span class="data-value">{{ format_angka($data->feed_intake_kg) }}</span>
                </div>
                <div class="data-row">
                    <span class="data-label">Konsumsi/Ekor (real)</span>
                    <span class="data-value">{{ format_angka($data->feed_intake_per_ekor) }}</span>
                </div>
                <div class="data-row">
                    <span class="data-label">Konsumsi/Ekor (std)</span>
                    <span class="data-value">{{ format_angka($data->feed_intake_per_ekor_standar) }}</span>
                </div>
            </x-mobile-card>
        @empty
            <x-empty-state icon="chart" title="Belum Ada Data" description="Data rekapan pakan harian tidak ditemukan." />
        @endforelse

        @if ($datas->hasPages())
            <div class="d-flex justify-content-end mt-3">
                {{ $datas->links('components.pagination') }}
            </div>
        @endif
    </div>

</div>
@endsection