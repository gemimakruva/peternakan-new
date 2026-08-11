@extends('layouts.dashboard')

@section('title', 'Strain Ayam')

@section('content_header')
    <x-page-header title="Strain Ayam" :breadcrumbs="['Master Data' => '#', 'Strain Ayam' => '']" />
@endsection

@section('content')
<div class="mx-1200">
    <div class="card">
        <div class="card-header">
            <div class="d-flex flex-wrap justify-content-left gap-2">
                @foreach ($strains as $strain)
                    <a
                        href="{{ route('master-data.strain-ayam.index', ['strain_id' => $strain->id]) }}"
                        class="btn text-bold {{ $filterStrainId == $strain->id ? 'text-primary' : 'text-secondary' }}"
                    >
                        {{ $strain->nama }}
                    </a>
                @endforeach
            </div>
        </div>

        <div class="card-body table-responsive p-0 desktop-table d-none d-md-block">
            <table class="table table-hover table-striped table-bordered text-center">
                <thead class="bg-light">
                    <tr>
                        <th>#</th>
                        <th>Umur Minggu</th>
                        <th>BB Bawah</th>
                        <th>BB Atas</th>
                        <th>BB Rata-rata</th>
                        <th>% Kematian</th>
                        <th>Feed Intake</th>
                        <th>FCR</th>
                        <th>HDP</th>
                        <th>HHP</th>
                        <th>Berat Telur</th>
                        <th>Egg Mass</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($strainMetrics as $row)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td class="text-right">{{ format_angka($row->umur) }}</td>
                            <td class="text-right">{{ format_angka($row->berat_badan_min) }}</td>
                            <td class="text-right">{{ format_angka($row->berat_badan_max) }}</td>
                            <td class="text-right">{{ format_angka($row->berat_badan) }}</td>
                            <td class="text-right">{{ format_angka($row->persentase_kematian) }}</td>
                            <td class="text-right">{{ format_angka($row->feed_intake) }}</td>
                            <td class="text-right">{{ format_angka($row->fcr) }}</td>
                            <td class="text-right">{{ format_angka($row->hdp) }}</td>
                            <td class="text-right">{{ format_angka($row->hhp) }}</td>
                            <td class="text-right">{{ format_angka($row->egg_weight) }}</td>
                            <td class="text-right">{{ format_angka($row->egg_mass) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="12">Data tidak tersedia</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mobile-card-list d-md-none">
            @forelse ($strainMetrics as $row)
                <x-mobile-card title="Minggu {{ format_angka($row->umur) }}">
                    <div class="data-row">
                        <span class="data-label">BB Bawah</span>
                        <span class="data-value">{{ format_angka($row->berat_badan_min) }}</span>
                    </div>
                    <div class="data-row">
                        <span class="data-label">BB Atas</span>
                        <span class="data-value">{{ format_angka($row->berat_badan_max) }}</span>
                    </div>
                    <div class="data-row">
                        <span class="data-label">BB Rata-rata</span>
                        <span class="data-value">{{ format_angka($row->berat_badan) }}</span>
                    </div>
                    <div class="data-row">
                        <span class="data-label">% Kematian</span>
                        <span class="data-value">{{ format_angka($row->persentase_kematian) }}</span>
                    </div>
                    <div class="data-row">
                        <span class="data-label">Feed Intake</span>
                        <span class="data-value">{{ format_angka($row->feed_intake) }}</span>
                    </div>
                    <div class="data-row">
                        <span class="data-label">FCR</span>
                        <span class="data-value">{{ format_angka($row->fcr) }}</span>
                    </div>
                    <div class="data-row">
                        <span class="data-label">HDP</span>
                        <span class="data-value">{{ format_angka($row->hdp) }}</span>
                    </div>
                    <div class="data-row">
                        <span class="data-label">HHP</span>
                        <span class="data-value">{{ format_angka($row->hhp) }}</span>
                    </div>
                    <div class="data-row">
                        <span class="data-label">Berat Telur</span>
                        <span class="data-value">{{ format_angka($row->egg_weight) }}</span>
                    </div>
                    <div class="data-row">
                        <span class="data-label">Egg Mass</span>
                        <span class="data-value">{{ format_angka($row->egg_mass) }}</span>
                    </div>
                </x-mobile-card>
            @empty
                <x-empty-state icon="clipboard" title="Belum Ada Data" description="Data strain ayam tidak tersedia." />
            @endforelse
        </div>
    </div>
</div>
@endsection
