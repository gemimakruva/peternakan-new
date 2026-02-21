@extends('layouts.print')

@php
    $title = "Laporan Mingguan";
@endphp

@section('title', $title)
@section('subtitle', 'Per Kandang')

@section('content')
<div class="print-container">
    {{-- Filter Info Display --}}
    <div class="print-filter-info">
        <div class="row">
            <div class="col-6">
                <strong>Kandang:</strong> {{ $kandang->nama_kandang ?? 'Semua Kandang' }}
            </div>
            <div class="col-6">
                <strong>Umur Ayam:</strong> {{ $umur }} minggu
            </div>
        </div>
    </div>

    {{-- Chart 1: Populasi Ayam --}}
    <div class="avoid-break">
        <h3>Data Populasi Ayam Minggu Ini</h3>
        <div class="row">
            @if(isset($chartImages['populasi-ayam-chart-per-kandang']))
            <div class="col-6">
                <div class="chart-container">
                    <img src="{{ $chartImages['populasi-ayam-chart-per-kandang'] }}" alt="Data Populasi Ayam per Kandang">
                </div>
            </div>
            @endif
            @if(isset($chartImages['populasi-ayam-chart-semua-kandang']))
            <div class="col-6">
                <div class="chart-container">
                    <img src="{{ $chartImages['populasi-ayam-chart-semua-kandang'] }}" alt="Data Populasi Semua Kandang">
                </div>
            </div>
            @endif
        </div>
        @if(@$catatanLaporan->catatan_populasi)
        <div class="catatan-section">
            <h4>Catatan Populasi</h4>
            <div class="catatan-content">
                {!! $catatanLaporan->catatan_populasi !!}
            </div>
        </div>
        @endif
    </div>

    {{-- Chart 2: Kematian Ayam --}}
    <div class="avoid-break page-break">
        <h3>Data Akumulasi Kematian Ayam</h3>
        <div class="row">
            @if(isset($chartImages['kematian-ayam-chart-per-kandang']))
            <div class="col-6">
                <div class="chart-container">
                    <img src="{{ $chartImages['kematian-ayam-chart-per-kandang'] }}" alt="Data Kematian Ayam per Kandang">
                </div>
            </div>
            @endif
            @if(isset($chartImages['kematian-ayam-chart-semua-kandang']))
            <div class="col-6">
                <div class="chart-container">
                    <img src="{{ $chartImages['kematian-ayam-chart-semua-kandang'] }}" alt="Data Kematian Ayam Semua Kandang">
                </div>
            </div>
            @endif
            @if(isset($chartImages['persentase-kematian-ayam-chart-per-kandang']))
            <div class="col-6">
                <div class="chart-container">
                    <img src="{{ $chartImages['persentase-kematian-ayam-chart-per-kandang'] }}" alt="Persentase Akumulasi Kematian per Kandang">
                </div>
            </div>
            @endif
        </div>
        @if(@$catatanLaporan->catatan_kematian)
        <div class="catatan-section">
            <h4>Catatan Kematian</h4>
            <div class="catatan-content">
                {!! $catatanLaporan->catatan_kematian !!}
            </div>
        </div>
        @endif
    </div>

    {{-- Chart 3: Feed Intake --}}
    <div class="avoid-break page-break">
        <h3>Data Konsumsi Ayam</h3>
        <div class="row">
            @if(isset($chartImages['feed-intake-ayam-chart-per-kandang']))
            <div class="col-12">
                <div class="chart-container">
                    <img src="{{ $chartImages['feed-intake-ayam-chart-per-kandang'] }}" alt="Konsumsi Rata-rata per Ekor Ayam per Kandang">
                </div>
            </div>
            @endif
        </div>
        @if(@$catatanLaporan->catatan_konsumsi)
        <div class="catatan-section">
            <h4>Catatan Konsumsi</h4>
            <div class="catatan-content">
                {!! $catatanLaporan->catatan_konsumsi !!}
            </div>
        </div>
        @endif
    </div>

    {{-- Chart 4: Produksi Telur --}}
    <div class="avoid-break page-break">
        <h3>Data Produksi Telur</h3>
        <div class="row">
            @if(isset($chartImages['produksi-butir-telur-pipe-chart-semua-kandang']))
            <div class="col-6">
                <div class="chart-container">
                    <img src="{{ $chartImages['produksi-butir-telur-pipe-chart-semua-kandang'] }}" alt="Data Produksi Telur per Kandang">
                </div>
            </div>
            @endif
            @if(isset($chartImages['produksi-berat-telur-pipe-chart-semua-kandang']))
            <div class="col-6">
                <div class="chart-container">
                    <img src="{{ $chartImages['produksi-berat-telur-pipe-chart-semua-kandang'] }}" alt="Data Produksi Telur Semua Kandang">
                </div>
            </div>
            @endif
            @if(isset($chartImages['produksi-butir-telur-pie-semua-kandang']))
            <div class="col-6">
                <div class="chart-container">
                    <img src="{{ $chartImages['produksi-butir-telur-pie-semua-kandang'] }}" alt="Data Produksi Telur Semua Kandang">
                </div>
            </div>
            @endif
            @if(isset($chartImages['produksi-berat-telur-pie-semua-kandang']))
            <div class="col-6">
                <div class="chart-container">
                    <img src="{{ $chartImages['produksi-berat-telur-pie-semua-kandang'] }}" alt="Data Produksi Telur Semua Kandang">
                </div>
            </div>
            @endif
        </div>
        @if(@$catatanLaporan->catatan_produksi_telur)
        <div class="catatan-section">
            <h4>Catatan Produksi Telur</h4>
            <div class="catatan-content">
                {!! $catatanLaporan->catatan_produksi_telur !!}
            </div>
        </div>
        @endif
    </div>

    {{-- Chart 5: KPI Produksi --}}
    <div class="avoid-break page-break">
        <h3>Data KPI Produksi</h3>
        <div class="row">
            @if(isset($chartImages['kpi-produksi-per-kandang']))
            <div class="col-12">
                <div class="chart-container">
                    <img src="{{ $chartImages['kpi-produksi-per-kandang'] }}" alt="KPI Produksi per Kandang">
                </div>
            </div>
            @endif
        </div>
    </div>

    {{-- Catatan Keseluruhan --}}
    @if(@$catatanLaporan->catatan_keseluruhan)
    <div class="catatan-section page-break">
        <h4>Catatan Keseluruhan</h4>
        <div class="catatan-content">
            {!! $catatanLaporan->catatan_keseluruhan !!}
        </div>
    </div>
    @endif

</div>
@endsection

@section('scripts')
<script>
    window.addEventListener('load', () => {
        window.print()
    })
</script>
@endsection