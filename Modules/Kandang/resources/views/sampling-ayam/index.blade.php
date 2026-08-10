@extends('layouts.dashboard')

@section('title', 'Sampling Bobot Ayam')

@section('content_header')
<x-page-header title="Sampling Bobot Ayam" :breadcrumbs="['Sampling Bobot Ayam' => '']">
    <x-slot name="actions">
        @can('kandang.sampling.create-sampling-bobot-ayam')
            <a href="{{ route('sampling-ayam.create') }}" class="btn btn-primary">
                <i class="fas fa-plus d-sm-none"></i>
                <span class="d-none d-sm-inline">Tambah Sampling Bobot Ayam</span>
            </a>
        @endcan
    </x-slot>
</x-page-header>
@endsection

@section('content')
<div class="mx-1400">
    <x-form-alert />

    <x-filter-panel action="{{ route('sampling-ayam.index') }}" resetUrl="{{ route('sampling-ayam.index') }}">
        <div class="col-12 col-md-4">
            <x-adminlte-input
                type="date"
                name="tanggal"
                label="Tanggal"
                fgroup-class="mb-0"
                :value="request()->query('tanggal')"
            />
        </div>
        <div class="col-12 col-md-4">
            <x-adminlte-select
                name="kandang_id"
                fgroup-class="mb-0"
            >
                <x-adminlte-options
                    :options="$listKandang"
                    empty-option="Pilih Kandang ..."
                    :selected="request()->query('kandang_id')"
                />
            </x-adminlte-select>
        </div>
    </x-filter-panel>

    <div class="card mt-3 desktop-table d-none d-md-block">
        <div class="card-body table-responsive p-0">
            <table class="table table-bordered table-striped align-middle">
                <thead class="text-center">
                    <tr>
                        <th class="align-middle" style="min-width:40px">#</th>
                        <x-sort-th class="align-middle" style="min-width:200px" label="Tanggal" name="tanggal" />
                        <x-sort-th class="align-middle" style="min-width:160px" label="Petugas Pencatat" name="nama_pencatat" />
                        <x-sort-th class="align-middle" style="min-width:150px" label="Kandang" name="nama_kandang" />
                        <x-sort-th class="align-middle" style="min-width:100px" label="Jumlah Ayam(ekor)" name="jumlah_ayam" />
                        <x-sort-th class="align-middle" style="min-width:100px" label="Jumlah Sampling(ekor)" name="jumlah_sampling" />
                        <x-sort-th class="align-middle" style="min-width:100px" label="Umur Ayam" name="umur_ayam" />
                        <x-sort-th class="align-middle" style="min-width:120px" label="Standar Bobot(kg)" name="standar_bobot" />
                        <th class="align-middle" style="min-width:150px">Range Standar Bobot(kg)</th>
                        <x-sort-th class="align-middle" style="min-width:150px" label="Rata-rata sampling(kg)" name="realisasi_bobot" />
                        <th class="align-middle" style="min-width:150px">Range Sampling(kg)</th>
                        <x-sort-th class="align-middle" style="min-width:120px" label="Ayam Masuk Range" name="jumlah_masuk_range" />
                        <x-sort-th class="align-middle" style="min-width:100px" label="Uniformity(%)" name="uniformity" />
                        <th class="align-middle" style="min-width:100px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($datas as $item)
                        <tr>
                            <td class="text-right">{{ $datas->firstItem() + $loop->index }}</td>
                            <td class="text-left">{{ $item->tanggal->translatedFormat('l, d F Y') }}</td>
                            <td class="text-left">{{ $item->nama_pencatat }}</td>
                            <td class="text-left">{{ $item->nama_kandang }}</td>
                            <td class="text-right">{{ format_angka($item->jumlah_ayam) }}</td>
                            <td class="text-right">{{ format_angka($item->jumlah_sampling) }}</td>
                            <td class="text-right">{{ $item->umur_ayam }} Minggu</td>
                            <td class="text-right">{{ format_angka($item->standar_bobot) }}</td>
                            <td class="text-right">{{ format_angka($item->standar_bobot_min) }} - {{ format_angka($item->standar_bobot_max) }}</td>
                            <td class="text-right">{{ format_angka($item->realisasi_bobot) }}</td>
                            <td class="text-right">{{ format_angka($item->realisasi_bobot_min) }} - {{ format_angka($item->realisasi_bobot_max) }}</td>
                            <td class="text-right">{{ format_angka($item->jumlah_masuk_range) }}</td>
                            <td class="text-right">
                                <span class="badge {{ $item->uniformity >= .8 ? 'badge-success' : 'badge-warning' }}">
                                    {{ format_angka($item->uniformity*100) }}%
                                </span>
                            </td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center">
                                    @can('kandang.sampling.detail-sampling-bobot-ayam')
                                        <a href="{{ route('sampling-ayam.show', $item->id) }}"
                                        class="btn btn-info btn-sm mr-2 text-white"
                                        title="Edit">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    @endcan
                                    @can('kandang.sampling.edit-sampling-bobot-ayam')
                                        <a
                                            href="{{ route('sampling-ayam.edit', $item->id) }}"
                                            class="btn btn-warning btn-sm mr-2 text-white"
                                            title="Edit"
                                        >
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    @endcan
                                    @can('kandang.sampling.delete-sampling-bobot-ayam')
                                        <form action="{{ route('sampling-ayam.destroy', $item->id) }}"
                                            method="POST"
                                            class="form-delete m-0"
                                            data-tanggal="tanggal {{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('l, d F Y') }}"
                                        >
                                            @csrf
                                            @method('delete')
                                            <button
                                                type="submit"
                                                class="btn btn-danger btn-sm"
                                                title="Hapus"
                                            >
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="15" class="text-center text-muted">
                                Belum ada data sampling bobot ayam.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($datas->hasPages())
            <div class="card-footer d-flex justify-content-end">
                {{ $datas->links('components.pagination') }}
            </div>
        @endif
    </div>

    <div class="mobile-card-list d-md-none">
        @forelse ($datas as $item)
            <x-mobile-card
                title="{{ $item->nama_kandang }}"
                subtitle="{{ $item->tanggal->translatedFormat('l, d F Y') }}"
                badge="{{ format_angka($item->uniformity*100) }}%"
                badgeClass="{{ $item->uniformity >= .8 ? 'badge-success' : 'badge-warning' }}"
            >
                <div class="data-row">
                    <span class="data-label">Petugas</span>
                    <span class="data-value">{{ $item->nama_pencatat }}</span>
                </div>
                <div class="data-row">
                    <span class="data-label">Jumlah Ayam</span>
                    <span class="data-value">{{ format_angka($item->jumlah_ayam) }} ekor</span>
                </div>
                <div class="data-row">
                    <span class="data-label">Jumlah Sampling</span>
                    <span class="data-value">{{ format_angka($item->jumlah_sampling) }} ekor</span>
                </div>
                <div class="data-row">
                    <span class="data-label">Umur Ayam</span>
                    <span class="data-value">{{ $item->umur_ayam }} Minggu</span>
                </div>
                <div class="data-row">
                    <span class="data-label">Standar Bobot</span>
                    <span class="data-value">{{ format_angka($item->standar_bobot) }} kg</span>
                </div>
                <div class="data-row">
                    <span class="data-label">Rata-rata Sampling</span>
                    <span class="data-value">{{ format_angka($item->realisasi_bobot) }} kg</span>
                </div>
                <div class="data-row">
                    <span class="data-label">Ayam Masuk Range</span>
                    <span class="data-value">{{ format_angka($item->jumlah_masuk_range) }}</span>
                </div>
                <x-slot name="actions">
                    @can('kandang.sampling.detail-sampling-bobot-ayam')
                        <a href="{{ route('sampling-ayam.show', $item->id) }}" class="btn btn-info btn-sm text-white">
                            <i class="fas fa-eye"></i> Detail
                        </a>
                    @endcan
                    @can('kandang.sampling.edit-sampling-bobot-ayam')
                        <a href="{{ route('sampling-ayam.edit', $item->id) }}" class="btn btn-warning btn-sm text-white">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                    @endcan
                    @can('kandang.sampling.delete-sampling-bobot-ayam')
                        <form action="{{ route('sampling-ayam.destroy', $item->id) }}"
                            method="POST"
                            class="form-delete m-0 flex-1"
                            data-tanggal="tanggal {{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('l, d F Y') }}"
                        >
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-danger btn-sm w-100" title="Hapus">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                        </form>
                    @endcan
                </x-slot>
            </x-mobile-card>
        @empty
            <div class="text-center text-muted p-4">Belum ada data sampling bobot ayam.</div>
        @endforelse

        @if ($datas->hasPages())
            <div class="d-flex justify-content-end mt-3">
                {{ $datas->links('components.pagination') }}
            </div>
        @endif
    </div>
</div>



@push('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        $('.form-delete').on('submit', function(e) {
            e.preventDefault();
            const form = this;
            const tanggal = $(this).data('tanggal');

            Swal.fire({
                title: 'Apakah Anda yakin?',
                html: `Data sampling bobot ayam pada <strong>${tanggal}</strong> akan dihapus permanen!`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                reverseButtons: false
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>
@endpush
@endsection