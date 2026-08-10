@extends('layouts.dashboard')

@section('title', 'Populasi Ayam')

@section('content_header')
    <x-page-header title="Populasi Ayam" :breadcrumbs="['Populasi Ayam' => '']" />
@endsection

@section('content')
    <div class="mx-1200">
        <div class="card desktop-table d-none d-md-block">
            <div class="card-body table-responsive p-0">
                <table class="table table-hover table-striped table-bordered text-center mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="align-middle" rowspan="2" width="40">#</th>
                            <th class="align-middle" rowspan="2" >Kandang</th>
                            <th class="align-middle" rowspan="2" >Tanggal Pengadaan</th>
                            <th class="align-middle" colspan="2">Umur Ayam</th>
                            <th class="align-middle" colspan="4">Total Ayam</th>
                            <th class="align-middle" rowspan="2" >Terakhir Diperbarui</th>
                            <th class="align-middle" rowspan="2" >Aksi</th>
                        </tr>
                        <tr>
                            <th class="align-middle">Awal</th>
                            <th class="align-middle">Saat Ini</th>
                            <th class="align-middle">Sehat</th>
                            <th class="align-middle">Mati</th>
                            <th class="align-middle">Masuk Karantina</th>
                            <th class="align-middle">Keluar Karantina</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($listKandang as $row)
                            <tr>
                                <td class="text-right">{{ ($listKandang->currentPage() - 1) * $listKandang->perPage() + $loop->iteration }}</td>
                                <td class="text-left">{{ $row['nama'] }}</td>
                                <td class="text-left">{{ @$row->latestPengadaanAyam->tanggal?->translatedFormat('l, d F Y') }}</td>
                                <td class="text-right">{{ number_format(@$row->latestPengadaanAyam->umur_ayam, 0, ',', '.') }}</td>
                                <td class="text-right">{{ number_format(@$row->latestPengadaanAyam->umur_ayam_saat_ini, 0, ',', '.') }}</td>
                                <td class="text-right">{{ number_format(@$row->ayam_sehat, 0, ',', '.') }}</td>
                                <td class="text-right">{{ number_format(@$row->ayam_mati, 0, ',', '.') }}</td>
                                <td class="text-right">{{ number_format(@$row->ayam_masuk_karantina, 0, ',', '.') }}</td>
                                <td class="text-right">{{ number_format(@$row->ayam_keluar_karantina, 0, ',', '.') }}</td>
                                <td class="text-left">{{ @$row->terakhir_diperharui->translatedFormat('l, d F Y') }}</td>
                                <td>
                                    <a href="{{ route('populasi-ayam.flock.index', $row->id)  }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="11" class="text-center">Data Populasi Ayam Kosong.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($listKandang->hasPages())
                <div class="card-footer d-flex justify-content-end">
                    {{ $listKandang->links('components.pagination') }}
                </div>
            @endif
        </div>

        <div class="mobile-card-list d-md-none">
            @forelse($listKandang as $row)
                <x-mobile-card
                    title="{{ $row['nama'] }}"
                    subtitle="{{ @$row->latestPengadaanAyam->tanggal?->translatedFormat('d M Y') ?? '-' }}"
                >
                    <div class="data-row">
                        <span class="data-label">Umur Awal</span>
                        <span class="data-value">{{ number_format(@$row->latestPengadaanAyam->umur_ayam, 0, ',', '.') }}</span>
                    </div>
                    <div class="data-row">
                        <span class="data-label">Umur Saat Ini</span>
                        <span class="data-value">{{ number_format(@$row->latestPengadaanAyam->umur_ayam_saat_ini, 0, ',', '.') }}</span>
                    </div>
                    <div class="data-row">
                        <span class="data-label">Sehat</span>
                        <span class="data-value">{{ number_format(@$row->ayam_sehat, 0, ',', '.') }}</span>
                    </div>
                    <div class="data-row">
                        <span class="data-label">Mati</span>
                        <span class="data-value">{{ number_format(@$row->ayam_mati, 0, ',', '.') }}</span>
                    </div>
                    <div class="data-row">
                        <span class="data-label">Masuk Karantina</span>
                        <span class="data-value">{{ number_format(@$row->ayam_masuk_karantina, 0, ',', '.') }}</span>
                    </div>
                    <div class="data-row">
                        <span class="data-label">Keluar Karantina</span>
                        <span class="data-value">{{ number_format(@$row->ayam_keluar_karantina, 0, ',', '.') }}</span>
                    </div>
                    <x-slot name="actions">
                        <a href="{{ route('populasi-ayam.flock.index', $row->id) }}" class="btn btn-info btn-sm">
                            <i class="fas fa-eye"></i> Detail
                        </a>
                    </x-slot>
                </x-mobile-card>
            @empty
                <div class="text-center text-muted p-4">Data Populasi Ayam Kosong.</div>
            @endforelse

            @if ($listKandang->hasPages())
                <div class="d-flex justify-content-end mt-3">
                    {{ $listKandang->links('components.pagination') }}
                </div>
            @endif
        </div>
    </div>
@endsection