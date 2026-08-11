@extends('layouts.dashboard')

@section('title', 'Populasi Ayam')

@section('content_header')
<x-page-header title="Populasi Ayam" :breadcrumbs="['Populasi Ayam' => '']">
    <x-slot name="actions">
        <a href="{{ route('populasi-ayam-2.create') }}" class="btn btn-primary">Tambah Populasi Ayam</a>
    </x-slot>
</x-page-header>
@endsection

@section('content')
<div class="mx-1200">
    <x-filter-panel action="{{ route('populasi-ayam-2.index') }}" resetUrl="{{ route('populasi-ayam-2.index') }}">
        <div class="col-12 col-sm-auto">
            <x-adminlte-select name="kandang_id" fgroup-class="mb-0">
                <x-adminlte-options
                    :options="$listKandang"
                    empty-option="Semua Kandang"
                    :selected="request()->query('kandang_id')"
                />
            </x-adminlte-select>
        </div>
    </x-filter-panel>

    <div class="card desktop-table d-none d-md-block">
        <div class="card-body table-responsive p-0">
            <table class="table table-hover table-striped table-bordered text-center mb-0">
                <thead>
                    <tr>
                        <th class="align-middle" rowspan="2" style="min-width: 40px;">#</th>
                        <th class="align-middle" rowspan="2" style="min-width: 180px;">Kandang</th>
                        <th class="align-middle" rowspan="2" style="min-width: 180px;">Tanggal</th>
                        <th class="align-middle" rowspan="2" style="min-width: 60px;">Umur Ayam</th>
                        <th class="align-middle" colspan="5">Total Ayam</th>
                        <th class="align-middle" rowspan="2" style="min-width: 40px;">Aksi</th>
                    </tr>
                    <tr>
                        <th class="align-middle" style="min-width: 60px;">Sehat</th>
                        <th class="align-middle" style="min-width: 60px;">Mati</th>
                        <th class="align-middle" style="min-width: 60px;">Afkir</th>
                        <th class="align-middle" style="min-width: 60px;">Masuk Karantina</th>
                        <th class="align-middle" style="min-width: 60px;">Keluar Karantina</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($datas as $row)
                        <tr>
                            <td class="text-right">{{ ($datas->currentPage() - 1) * $datas->perPage() + $loop->iteration }}</td>
                            <td class="text-left">{{ $row->nama_kandang }}</td>
                            <td class="text-left">{{ $row->tanggal->translatedFormat('l, d F Y') }}</td>
                            <td class="text-right">{{ format_angka(@$row->umur_ayam) }}</td>
                            <td class="text-right">{{ format_angka(@$row->ayam_sehat) }}</td>
                            <td class="text-right">{{ format_angka(@$row->ayam_mati) }}</td>
                            <td class="text-right">{{ format_angka(@$row->ayam_afkir) }}</td>
                            <td class="text-right">{{ format_angka(@$row->ayam_masuk_karantina) }}</td>
                            <td class="text-right">{{ format_angka(@$row->ayam_keluar_karantina) }}</td>
                            <td>
                                <div class="d-flex gap-2 justify-content-center">
                                    <a href="{{ route('populasi-ayam-2.edit', [$row->id_kandang, $row->tanggal->format('Y-m-d')])  }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @if (@$row->is_editable)
                                        <form
                                            action="{{ route('populasi-ayam-2.destroy', [$row->id_kandang, $row->tanggal->format('Y-m-d')]) }}"
                                            method="post"
                                            class="form-delete"
                                            data-tanggal="{{ $row->tanggal->translatedFormat('l, d F Y') }}"
                                        >
                                            @csrf
                                            @method('delete')
                                            <button class="btn btn-sm btn-danger">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center">Data Populasi Ayam Kosong.</td>
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
        @forelse($datas as $row)
            <x-mobile-card
                title="{{ $row->nama_kandang }}"
                subtitle="{{ $row->tanggal->translatedFormat('l, d F Y') }}"
            >
                <div class="data-row">
                    <span class="data-label">Umur Ayam</span>
                    <span class="data-value">{{ format_angka(@$row->umur_ayam) }}</span>
                </div>
                <div class="data-row">
                    <span class="data-label">Sehat</span>
                    <span class="data-value">{{ format_angka(@$row->ayam_sehat) }}</span>
                </div>
                <div class="data-row">
                    <span class="data-label">Mati</span>
                    <span class="data-value">{{ format_angka(@$row->ayam_mati) }}</span>
                </div>
                <div class="data-row">
                    <span class="data-label">Afkir</span>
                    <span class="data-value">{{ format_angka(@$row->ayam_afkir) }}</span>
                </div>
                <div class="data-row">
                    <span class="data-label">Masuk Karantina</span>
                    <span class="data-value">{{ format_angka(@$row->ayam_masuk_karantina) }}</span>
                </div>
                <div class="data-row">
                    <span class="data-label">Keluar Karantina</span>
                    <span class="data-value">{{ format_angka(@$row->ayam_keluar_karantina) }}</span>
                </div>
                <x-slot name="actions">
                    <a href="{{ route('populasi-ayam-2.edit', [$row->id_kandang, $row->tanggal->format('Y-m-d')]) }}" class="btn btn-info btn-sm text-white">
                        <i class="fas fa-eye"></i> Detail
                    </a>
                    @if (@$row->is_editable)
                        <form
                            action="{{ route('populasi-ayam-2.destroy', [$row->id_kandang, $row->tanggal->format('Y-m-d')]) }}"
                            method="post"
                            class="form-delete flex-1"
                            data-tanggal="{{ $row->tanggal->translatedFormat('l, d F Y') }}"
                        >
                            @csrf
                            @method('delete')
                            <button class="btn btn-danger btn-sm w-100">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                        </form>
                    @endif
                </x-slot>
            </x-mobile-card>
        @empty
            <x-empty-state icon="chicken" title="Belum Ada Data" description="Data populasi ayam kosong." />
        @endforelse

        @if ($datas->hasPages())
            <div class="d-flex justify-content-end mt-3">
                {{ $datas->links('components.pagination') }}
            </div>
        @endif
    </div>
</div>
@endsection

@push('js')
    <script>
        $(document).on('submit', '.form-delete', function (e) {
            e.preventDefault();
            const tanggal = $(this).data('tanggal');

            Swal.fire({
                title: `Hapus Populasi Ayam tanggal "${tanggal}"?`,
                text: "Data yang dihapus tidak dapat dikembalikan.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Ya, Hapus",
                cancelButtonText: "Batal"
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit();
                }
            });
        });
    </script>
@endpush
