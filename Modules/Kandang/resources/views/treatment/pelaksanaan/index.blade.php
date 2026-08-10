@extends('layouts.dashboard')

@section('title', 'Pelaksanaan Treatment')

@section('content_header')
    <x-page-header title="Pelaksanaan Treatment" :breadcrumbs="['Pelaksanaan Treatment' => '']" />
@endsection

@section('content')
    <div class="mx-900">
        <x-form-alert />

        <div class="card desktop-table d-none d-md-block">
            <div class="card-body table-responsive p-0">
                <table class="table table-hover table-striped table-bordered">
                    <thead class="text-center">
                        <tr>
                            <th style="max-width: 40px;">#</th>
                            <th style="max-width: 180px;">Kandang</th>
                            <th style="max-width: 140px;">Bulan</th>
                            <th style="max-width: 180px;">Treatment Terjadwal</th>
                            <th style="max-width: 40px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($datas as $index => $row)
                            <tr>
                                <td class="text-right">{{ ($loop->index + 1) + (request()->get('page', 1) * 10 - 10) }}</td>
                                <td>{{ $row->nama_kandang }}</td>
                                <td>{{ $row->nama_bulan }}</td>
                                <td class="text-right">{{ $row->treatment_terjadwal }}</td>
                                <td>
                                    <div class="d-flex justify-content-center gap-1">
                                        <a href="{{ route('treatment-pelaksanaan.jadwal', [$row->id_kandang, $row->bulan]) }}" class="btn btn-primary btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-3">
                                    Tidak ada data treatment ditemukan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mobile-card-list d-md-none">
            @forelse($datas as $index => $row)
                <x-mobile-card
                    title="{{ $row->nama_kandang }}"
                    subtitle="{{ $row->nama_bulan }}"
                >
                    <div class="data-row">
                        <span class="data-label">Treatment Terjadwal</span>
                        <span class="data-value">{{ $row->treatment_terjadwal }}</span>
                    </div>
                    <x-slot name="actions">
                        <a href="{{ route('treatment-pelaksanaan.jadwal', [$row->id_kandang, $row->bulan]) }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-edit"></i> Jadwal
                        </a>
                    </x-slot>
                </x-mobile-card>
            @empty
                <div class="text-center text-muted p-4">Tidak ada data treatment ditemukan.</div>
            @endforelse
        </div>
    </div>
@endsection