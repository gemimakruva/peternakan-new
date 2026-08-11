@extends('layouts.dashboard')

@section('title', 'Inventory Bahan Pakan')

@section('content_header')
    <x-page-header title="Inventory Bahan Pakan" :breadcrumbs="['Inventory Bahan Pakan' => '']" />
@endsection


@section('content')
<div class="mx-900">
    <x-form-alert />
    
    <x-filter-panel action="{{ route('gudang-pakan.bahan-pakan-inventory.index') }}" resetUrl="{{ route('gudang-pakan.bahan-pakan-inventory.index') }}">
        <div class="col-12 col-md-4">
            <x-adminlte-select
                name="tipe"
                fgroup-class="mb-0 w-100"
            >
                <x-adminlte-options
                    :options="$listTipe"
                    :selected="request()->query('tipe')"
                    empty-option="Semua Tipe"
                />
            </x-adminlte-select>
        </div>
        <div class="col-12 col-md-4">
            <input
                type="search"
                name="search"
                class="form-control"
                placeholder="Nama Bahan Pakan ..."
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
                        <th class="align-middle" style="width: 150px;">Tipe</th>
                        <x-sort-th class="align-middle" style="min-width: 150px;" label="Nama Bahan Pakan" name="nama_bahan_pakan" />
                        <x-sort-th class="align-middle" style="min-width: 100px;" label="Jumlah" name="jumlah" />
                        <th class="align-middle" style="width: 50px;">Satuan</th>
                        <th class="align-middle" style="width: 100px;">Harga Satuan</th>
                        <th class="align-middle" style="width: 40px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($datas as $data)
                        <tr>
                            <td>{{ ($datas->currentPage() - 1) * $datas->perPage() + $loop->iteration }}</td>
                            <td class="text-left">{{ $data->tipe }}</td>
                            <td class="text-left">{{ $data->nama_bahan_pakan }}</td>
                            <td class="text-right">{{ format_angka($data->jumlah) }}</td>
                            <td class="text-left">{{ $data->nama_satuan }}</td>
                            <td class="text-right">{{ format_angka($data->harga_satuan) }}</td>
                            <td>
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('gudang-pakan.bahan-pakan-inventory.show', $data?->id ?? 0) }}" class="btn btn-sm btn-warning text-white">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">Data Inventory Bahan Pakan tidak tersedia</td>
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
        @forelse($datas as $data)
            <x-mobile-card title="{{ $data->nama_bahan_pakan }}" subtitle="{{ $data->tipe }}">
                <div class="data-row">
                    <span class="data-label">Jumlah</span>
                    <span class="data-value">{{ format_angka($data->jumlah) }} {{ $data->nama_satuan }}</span>
                </div>
                <div class="data-row">
                    <span class="data-label">Harga Satuan</span>
                    <span class="data-value">{{ format_angka($data->harga_satuan) }}</span>
                </div>
                <x-slot name="actions">
                    <a href="{{ route('gudang-pakan.bahan-pakan-inventory.show', $data?->id ?? 0) }}" class="btn btn-sm btn-warning text-white">
                        <i class="fas fa-eye"></i> Detail
                    </a>
                </x-slot>
            </x-mobile-card>
        @empty
            <x-empty-state icon="box" title="Belum Ada Data" description="Data inventory bahan pakan tidak tersedia." />
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
                title: `Hapus Pembelian Bahan Pakan "${tanggal}"?`,
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
