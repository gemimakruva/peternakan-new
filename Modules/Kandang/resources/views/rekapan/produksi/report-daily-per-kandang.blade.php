@extends('layouts.dashboard')

@php
    $title = "Laporan Harian";
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
    @include('kandang::rekapan.produksi._report_filter_header', ['routeName' => 'rekapan-produksi.report.daily'])

    <div class="row">
        @include('kandang::rekapan.produksi.chart.daily.per-kandang.chart-1-populasi-ayam')
        @include('kandang::rekapan.produksi.chart.daily.per-kandang.chart-2-kematian-ayam')
        @include('kandang::rekapan.produksi.chart.daily.per-kandang.chart-3-feed-intake')
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