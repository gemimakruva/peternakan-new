@extends('layouts.dashboard')

@php
    $title = "Laporan Harian $kandang->nama";
@endphp

@section('title', $title)

@section('content_header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>{{ $title }}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">  
                <li class="breadcrumb-item">
                    <a href="{{ route('rekapan-produksi.index') }}">Rekapan Produksi</a>
                </li>
                <li class="breadcrumb-item active">{{ $title }}</li>
            </ol>
        </div>
    </div>
</div>
@endsection


@section('content')
<div class="mx-1400">
    <h2 class="h4">Filter</h2>
    <div class="card">
        <div class="card-body">
            <form action="{{ route('rekapan-produksi.report') }}" class="row">
                <x-adminlte-input
                    name="tanggal"
                    label="Tanggal"
                    type="date"
                    :value="$tanggal->format('Y-m-d')"
                    fgroup-class="mb-0 col-12 col-lg-3"
                />

                <x-adminlte-select
                    name="kandang_id"
                    label="Kandang"
                    fgroup-class="mb-0 col-12 col-lg-3"
                >
                    <x-adminlte-options
                        :options="$listKandang"
                        empty-option="Semua Kandang"
                        :selected="$kandang->id"
                    />
                </x-adminlte-select>

                <div class="col-12 col-lg-3 d-flex gap-2 align-items-end">
                    <button class="btn btn-primary">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>

@if (false)
    <h2 class="h4">Data Populasi Ayam</h2>
    <div class="row">
        <div class="col-12 col-lg-8">
            <div class="card">
                <div class="card-body p-0 table-responsive">
                    <table class="table table-hover table-striped table-bordered text-center mb-0">
                        <thead>
                            <tr>
                                <th class="align-middle">Nama Flock</th>
                                <th class="align-middle">Ayam Sehat (Fit)</th>
                                <th class="align-middle">Ayam Sakit</th>
                                <th class="align-middle">Ayam Afkir</th>
                                <th class="align-middle">Ayam Masuk Karantina</th>
                                <th class="align-middle">Ayam Keluar Karantina</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($kandang->flocks as $flock)
                                <tr>
                                    <td>{{ $flock->nama }}</td>
                                    <td>{{ fake()->numberBetween(1,100) }}</td>
                                    <td>{{ fake()->numberBetween(1,100) }}</td>
                                    <td>{{ fake()->numberBetween(1,100) }}</td>
                                    <td>{{ fake()->numberBetween(1,100) }}</td>
                                    <td>{{ fake()->numberBetween(1,100) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-4">
            <div class="card">
                <div class="card-body">
                    <canvas id="populasi-ayam-chart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <h2 class="h4">Data Kematian Ayam</h2>
    <div class="row">
        <div class="col-12 col-lg-8">
            <div class="card">
                <div class="card-body p-0 table-responsive">
                    <table class="table table-hover table-striped table-bordered text-center mb-0">
                        <thead>
                            <tr>
                                <th class="align-middle">Nama Flock</th>
                                <th>Akumulasi Kematian</th>
                                <th>Persentase Kematian</th>
                                <th>Akumulasi Afkir</th>
                                <th>Persentase Afkir</th>
                                <th>Akumulasi Kematian + Afkir</th>
                                <th>Persentase Kematian + Afkir</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($kandang->flocks as $flock)
                                @php
                                    $base   = 3000/6;
                                    $mati   = (fake()->numberBetween(1, 10) / 100) * $base;
                                    $afkir  = (fake()->numberBetween(1, 5) / 100) * $base;
                                @endphp
                                <tr>
                                    <td>{{ $flock->nama }}</td>
                                    <td>{{ $mati }}</td>
                                    <td>{{ $mati/$base*100 }}%</td>
                                    <td>{{ $afkir }}</td>
                                    <td>{{ $afkir/$base*100 }}%</td>
                                    <td>{{ ($mati+$afkir) }}</td>
                                    <td>{{ ($mati+$afkir)/$base*100 }}%</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-4">
            <div class="card">
                <div class="card-body">
                    <canvas id=""></canvas>
                </div>
            </div>
        </div>
    </div>
@endif

    <div class="row">
        @include('kandang::rekapan.produksi.chart.chart-1-populasi-ayam')
        @include('kandang::rekapan.produksi.chart.chart-2-kematian-ayam')
        @include('kandang::rekapan.produksi.chart.chart-3-feed-intake')
        @include('kandang::rekapan.produksi.chart.chart-4-produksi-telur')
        @include('kandang::rekapan.produksi.chart.chart-5-kpi-produksi')
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <x-adminlte-textarea 
                        label="Catatan SPV Kandang"
                        name="catatan_spv_kandang"
                    />
                    <div class="text-right">
                        <button class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection