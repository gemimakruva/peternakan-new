@extends('layouts.dashboard')

@section('title', 'Detail Pemberian Pakan Sisa Pakan')

@section('content_header')
    <x-page-header title="Detail Pemberian Pakan Sisa Pakan" :breadcrumbs="[
        'Pemberian Pakan' => route('pemberian-pakan-sisa-pakan.index'),
        'Detail' => null,
    ]" />
@endsection

@php
$informations = [
    ['Tanggal Pemberian Pakan', $perhitunganPakan->tanggal_pemberian_pakan->translatedFormat('l, d F Y')],
    ['Kandang', $perhitunganPakan->kandang->nama],
    ['Pemberian Pagi', "{$perhitunganPakan->proporsi_pemberian_pagi}%, Jam {$perhitunganPakan->waktu_pemberian_pagi} WIB"],
    ['Pemberian Sore', "{$perhitunganPakan->proporsi_pemberian_sore}%, Jam {$perhitunganPakan->waktu_pemberian_sore} WIB"],
    ['Pencatat', $perhitunganPakan->userCreator->name],
    ['Pelaksana', $perhitunganPakan->userExecutor->name],
    ['Jenis Pakan', $perhitunganPakan->jenisPakan->nama],
    ['Catatan', $perhitunganPakan->catatan],
];
@endphp

@section('content')
<div class="mx-1200">
    <x-form-alert />

    <div class="row">
        <div class="col-12 col-lg-9">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Informasi Pemberian Pakan</h2>
                </div>
                <div class="card-body">
                    <div class="informations-wrapper d-none d-md-grid">
                        @foreach ($informations as $info)
                            <div class="item">
                                <span class="label">{{ $info[0] }}</span>
                                <span class="value">: {{ $info[1] }}</span>
                            </div>
                        @endforeach
                    </div>
                    <div class="mobile-card-list d-md-none">
                        @foreach ($informations as $info)
                            <div class="data-row">
                                <span class="data-label">{{ $info[0] }}</span>
                                <span class="data-value">{{ $info[1] }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            
            @include('kandang::pemberian-pakan-sisa-pakan._form', ['readonly' => true])
        </div>
        <div class="col-12 col-lg-3">
            <div class="card sticy-form-action">
                <div class="card-header">
                    <h2 class="card-title">Aksi</h2>
                </div>
                <div class="card-body d-flex gap-2">
                    <a href="{{ route('pemberian-pakan-sisa-pakan.index') }}" class="btn btn-outline-secondary flex-1">Kembali</a>
                    @can('kandang.pakan.edit-pemberian-pakan-dan-sisa-pakan')
                        <a href="{{ route('pemberian-pakan-sisa-pakan.edit', $perhitunganPakan->id) }}" class="btn btn-warning flex-1">Edit</a>
                    @endcan
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('css')
    <style>
        .informations-wrapper {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
        }
        .informations-wrapper .item {
            display: flex;
        }
        .informations-wrapper .item .label {
            font-weight: bold;
            flex: 1;
        }
        .informations-wrapper .item .value {
            flex: 1;
        }
    </style>
@endpush