@extends('layouts.dashboard')

@section('title', 'Ayam Karantina')

@section('content_header')
    <x-page-header title="Ayam Karantina" :breadcrumbs="['Ayam Karantina' => '']">
        <x-slot name="actions">
            <a href="{{ route('ayam-karantina.create') }}" class="btn btn-primary">Tambah Ayam Karantina</a>
        </x-slot>
    </x-page-header>
@endsection


@section('content')
    <div class="mx-1000">

        <x-form-alert />

        <x-filter-panel action="{{ route('ayam-karantina.index') }}" resetUrl="{{ route('ayam-karantina.index') }}">
            <div class="col-12 col-md-4">
                <x-adminlte-select name="kandang_id" fgroup-class="mb-0 w-100">
                    <x-adminlte-options
                        :options="$listKandang"
                        empty-option="Semua Kandang ..."
                        :selected="request()->query('kandang_id')"
                    />
                </x-adminlte-select>
            </div>

            <div class="col-12 col-md-4">
                <input
                    type="search"
                    name="search"
                    class="form-control"
                    placeholder="Nama Pencatat"
                    value="{{ request()->query('search') }}"
                >
            </div>
        </x-filter-panel>

        <div class="card desktop-table d-none d-md-block">
            <div class="card-body table-responsive p-0">
                <table class="table table-hover table-striped table-bordered text-center mb-0">
                    <thead>
                        <tr>
                            <th class="align-middle" style="width: 40px;">#</th>
                            <x-sort-th class="align-middle" style="width: 200px;" label="Tanggal" name="tanggal" />
                            <x-sort-th class="align-middle" style="width: 160px;" label="Kandang" name="nama_kandang" />
                            <x-sort-th class="align-middle" label="Nama Pencatat" name="nama_pic_user" />
                            <x-sort-th class="align-middle" label="Populasi" name="total_ayam_karantina" />
                            <x-sort-th class="align-middle" label="Ayam Mati" name="ayam_mati" />
                            <x-sort-th class="align-middle" label="Ayam Afkir" name="ayam_afkir" />
                            <th class="align-middle" style="width: 40px;">Aksi</th>
                        </tr>
                    </thead>
                <tbody>
                    @forelse($listKarantinaPopulasi as $item)
                    <tr>
                        <td class="text-right">{{ ($listKarantinaPopulasi->currentPage() - 1) * $listKarantinaPopulasi->perPage() + $loop->iteration }}</td>
                        <td class="text-left">{{ $item->tanggal->translatedFormat('l, d F Y') }}</td>
                        <td class="text-left">{{ $item->nama_kandang ?? '-' }}</td>
                        <td class="text-left">{{ $item->nama_pic_user ?? '-' }}</td>
                        <td class="text-right">{{ format_angka($item->total_ayam_karantina, 0) }}</td>
                        <td class="text-right">{{ format_angka($item->ayam_mati, 0) }}</td>
                        <td class="text-right">{{ format_angka($item->ayam_afkir, 0) }}</td>
                        <td>
                            <div class="d-flex justify-content-center gap-2">
                                <a href="{{ route('ayam-karantina.edit', $item->id) }}" class="btn btn-sm btn-warning text-white">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                        <tr>
                            <td colspan="18" class="text-center text-muted">Data Ayam Karantina belum tersedia</td>
                        </tr>
                    @endforelse
                </tbody>
                </table>
            </div>

            @if ($listKarantinaPopulasi->hasPages())
                <div class="card-footer d-flex justify-content-end">
                    {{ $listKarantinaPopulasi->links('components.pagination') }}
                </div>
            @endif
        </div>

        <div class="mobile-card-list d-md-none">
            @forelse($listKarantinaPopulasi as $item)
                <x-mobile-card
                    title="{{ $item->nama_kandang ?? '-' }}"
                    subtitle="{{ $item->tanggal->translatedFormat('d M Y') }}"
                >
                    <div class="data-row">
                        <span class="data-label">Pencatat</span>
                        <span class="data-value">{{ $item->nama_pic_user ?? '-' }}</span>
                    </div>
                    <div class="data-row">
                        <span class="data-label">Populasi</span>
                        <span class="data-value">{{ format_angka($item->total_ayam_karantina, 0) }}</span>
                    </div>
                    <div class="data-row">
                        <span class="data-label">Ayam Mati</span>
                        <span class="data-value">{{ format_angka($item->ayam_mati, 0) }}</span>
                    </div>
                    <div class="data-row">
                        <span class="data-label">Ayam Afkir</span>
                        <span class="data-value">{{ format_angka($item->ayam_afkir, 0) }}</span>
                    </div>
                    <x-slot name="actions">
                        <a href="{{ route('ayam-karantina.edit', $item->id) }}" class="btn btn-warning btn-sm text-white">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                    </x-slot>
                </x-mobile-card>
            @empty
                <div class="text-center text-muted p-4">Data Ayam Karantina belum tersedia.</div>
            @endforelse

            @if ($listKarantinaPopulasi->hasPages())
                <div class="d-flex justify-content-end mt-3">
                    {{ $listKarantinaPopulasi->links('components.pagination') }}
                </div>
            @endif
        </div>
    </div>
@endsection