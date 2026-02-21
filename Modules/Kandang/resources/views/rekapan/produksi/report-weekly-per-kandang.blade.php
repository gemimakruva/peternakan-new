@extends('layouts.dashboard')

@php
    $title = "Laporan Mingguan";
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

@section('plugins.Summernote', true)

@section('content')
<div class="mx-1400">
    <x-form-alert />

    @include('kandang::rekapan.produksi._report_weekly_filter_header', ['routeName' => 'rekapan-produksi.report.weekly'])

    <form
        method="post"
        class="row mb-4"
        action="{{ route('rekapan-populasi-ayam.catatan.store') }}"
    >
        @csrf
        <input type="hidden" name="tipe" value="{{ \Modules\Kandang\Enums\CatatanLaporanTipe::MINGGUAN_PER_KANDANG->value }}" />
        <input type="hidden" name="kandang_id" value="{{ @$kandang->id ?? '' }}" />
        <input type="hidden" name="umur" value="{{ $umur }}">

        @include('kandang::rekapan.produksi.chart.weekly.per-kandang.chart-1-populasi-ayam')
        @include('kandang::rekapan.produksi.chart.weekly.per-kandang.chart-2-kematian-ayam')
        @include('kandang::rekapan.produksi.chart.weekly.per-kandang.chart-3-feed-intake')
        @include('kandang::rekapan.produksi.chart.weekly.per-kandang.chart-4-produksi-telur')
        @include('kandang::rekapan.produksi.chart.weekly.per-kandang.chart-5-kpi-produksi')

        <div class="col-12">
            <x-adminlte-text-editor
                label="Catatan Keseluruhan"
                name="catatan_keseluruhan"
                fgroup-class="mb-2"
                :config="config('adminlte.plugins.Summernote.defaultConfig')"
            >{{ old('catatan_keseluruhan', @$catatanLaporan->catatan_keseluruhan) }}</x-adminlte-text-editor>
            <div class="text-right">
                <button class="btn btn-primary px-4">Simpan</button>
            </div>
        </div>
    </form>

</div>
@endsection