@extends('layouts.dashboard')

@section('title', 'Bahan Baku')

@section('content_header')
    <x-page-header title="Bahan Baku" :breadcrumbs="['Bahan Baku' => '']">
        <x-slot name="actions">
            <a href="{{ route('gudang-pakan.master-data.bahan-pakan.create') }}" class="btn btn-primary">Tambah Bahan Baku</a>
        </x-slot>
    </x-page-header>
@endsection


@section('content')
<div class="mx-1200">
    <x-form-alert />

    <x-filter-panel action="{{ route('gudang-pakan.master-data.bahan-pakan.index') }}" resetUrl="{{ route('gudang-pakan.master-data.bahan-pakan.index') }}">
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
                placeholder="Nama Bahan Baku ..."
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
                        <x-sort-th class="align-middle" style="min-width: 150px;" label="Tipe" name="tipe" />
                        <x-sort-th class="align-middle" style="min-width: 150px;" label="Nama" name="nama" />
                        <x-sort-th class="align-middle" style="min-width: 150px;" label="Harga Satuan" name="harga_satuan" />
                        <th class="align-middle" style="width: 40px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($datas as $data)
                        <tr>
                            <td>{{ ($datas->currentPage() - 1) * $datas->perPage() + $loop->iteration }}</td>
                            <td class="text-left">{{ $data->tipe_enum?->title() }}</td>
                            <td class="text-left">{{ $data->nama }}</td>
                            <td class="text-right">{{ format_angka($data->harga_satuan) }}</td>
                            <td>
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('gudang-pakan.master-data.bahan-pakan.edit', $data->id) }}" class="btn btn-sm btn-warning text-white">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form
                                        action="{{ route('gudang-pakan.master-data.bahan-pakan.destroy', $data->id) }}"
                                        method="post"
                                        class="form-delete"
                                        data-nama="{{ $data->nama }}"
                                    >
                                        @csrf
                                        @method('delete')
                                        <button class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">Data Bahan Pakan tidak tersedia</td>
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
            <x-mobile-card title="{{ $data->nama }}" subtitle="{{ $data->tipe_enum?->title() }}">
                <div class="data-row">
                    <span class="data-label">Harga Satuan</span>
                    <span class="data-value">{{ format_angka($data->harga_satuan) }}</span>
                </div>
                <x-slot name="actions">
                    <a href="{{ route('gudang-pakan.master-data.bahan-pakan.edit', $data->id) }}" class="btn btn-warning btn-sm text-white">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <form
                        action="{{ route('gudang-pakan.master-data.bahan-pakan.destroy', $data->id) }}"
                        method="post"
                        class="form-delete"
                        data-nama="{{ $data->nama }}"
                    >
                        @csrf
                        @method('delete')
                        <button class="btn btn-sm btn-danger">
                            <i class="fas fa-trash"></i> Hapus
                        </button>
                    </form>
                </x-slot>
            </x-mobile-card>
        @empty
            <x-empty-state icon="box" title="Belum Ada Data" description="Data bahan pakan tidak tersedia." />
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
            const nama = $(this).data('nama');

            Swal.fire({
                title: `Hapus Bahan Baku "${nama}"?`,
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
