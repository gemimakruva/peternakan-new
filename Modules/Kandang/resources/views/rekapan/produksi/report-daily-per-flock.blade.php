@extends('layouts.dashboard')

@php
    $title = "Laporan Harian $kandang->nama";
@endphp

@section('title', $title)

@section('content_header')
    <x-page-header :title="$title" :breadcrumbs="[
        'Rekapan Produksi' => route('rekapan-produksi.index'),
        $title => null,
    ]" />
@endsection

@section('plugins.Summernote', true)

@section('content')
<div class="mx-1400">
    <x-form-alert />

    @include('kandang::rekapan.produksi._report_daily_filter_header', [
        'routeName' => 'rekapan-produksi.report.daily', 
        'umurAyam' => @$rekapanKandang->umur ?? 0
    ])

    <form
        method="post"
        class="row mb-4"
        action="{{ route('rekapan-populasi-ayam.catatan.store') }}"
    >
        @csrf
        <input type="hidden" name="tipe" value="{{ \Modules\Kandang\Enums\CatatanLaporanTipe::HARIAN_PER_FLOCK->value }}" />
        <input type="hidden" name="kandang_id" value="{{ @$kandang->id ?? '' }}" />
        <input type="hidden" name="tanggal" value="{{ $tanggal->format('Y-m-d') }}">

        @include('kandang::rekapan.produksi.chart.daily.per-flock.chart-1-populasi-ayam')
        @include('kandang::rekapan.produksi.chart.daily.per-flock.chart-2-kematian-ayam')
        @include('kandang::rekapan.produksi.chart.daily.per-flock.chart-3-feed-intake')
        @include('kandang::rekapan.produksi.chart.daily.per-flock.chart-4-produksi-telur')
        @include('kandang::rekapan.produksi.chart.daily.per-flock.chart-5-kpi-produksi')

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