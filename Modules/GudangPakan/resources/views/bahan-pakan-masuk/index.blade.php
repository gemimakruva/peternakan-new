@extends('layouts.dashboard')

@section('title', 'Bahan Pakan Masuk')

@section('content_header')
    <x-page-header title="Bahan Pakan Masuk" :breadcrumbs="['Bahan Pakan Masuk' => '']">
        <x-slot name="actions">
            <a href="{{ route('gudang-pakan.bahan-pakan-masuk.create') }}" class="btn btn-primary">Tambah Bahan Pakan Masuk</a>
        </x-slot>
    </x-page-header>
@endsection


@section('content')
<div class="mx-1200">
    <x-form-alert />
    
    <x-filter-panel action="{{ route('gudang-pakan.bahan-pakan-masuk.index') }}" resetUrl="{{ route('gudang-pakan.bahan-pakan-masuk.index') }}">
        <div class="col-12 col-md-4">
            <x-adminlte-select name="supplier_id" fgroup-class="mb-0 w-100">
                <x-adminlte-options
                    :options="$listSupplier"
                    :selected="request()->query('supplier_id')"
                    empty-option="Semua Supplier"
                />
            </x-adminlte-select>
        </div>
        <div class="col-12 col-md-4">
            <x-adminlte-select name="asal" fgroup-class="mb-0 w-100">
                <x-adminlte-options
                    :options="$listAsal"
                    :selected="request()->query('asal')"
                    empty-option="Semua Asal"
                />
            </x-adminlte-select>
        </div>
        <div class="col-12 col-md-4">
            <input type="search" name="search" class="form-control" placeholder="Nama Pic ..." value="{{ request()->query('search') }}">
        </div>
    </x-filter-panel>

    <div class="card desktop-table d-none d-md-block">
        <div class="card-body table-responsive p-0">
            <table class="table table-hover table-striped table-bordered text-center mb-0">
                <thead>
                    <tr>
                        <th class="align-middle" style="width: 40px;">#</th>
                        <x-sort-th class="align-middle" style="min-width: 150px;" label="Pic" name="nama_pic_user" />
                        <x-sort-th class="align-middle" style="min-width: 150px;" label="Supplier" name="nama_supplier" />
                        <x-sort-th class="align-middle" style="min-width: 150px;" label="Tanggal" name="tanggal" />
                        <x-sort-th class="align-middle" style="min-width: 150px;" label="Asal" name="asal" />
                        <th class="align-middle" style="width: 40px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($datas as $data)
                        <tr>
                            <td>{{ ($datas->currentPage() - 1) * $datas->perPage() + $loop->iteration }}</td>
                            <td class="text-left">{{ $data->nama_pic_user }}</td>
                            <td class="text-left">{{ $data->nama_supplier }}</td>
                            <td class="text-left">{{ $data->tanggal->translatedFormat('l, d F Y') }}</td>
                            <td class="text-left">{{ $data->asal->title() }}</td>
                            <td>
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('gudang-pakan.bahan-pakan-masuk.edit', $data->id) }}" class="btn btn-sm btn-warning text-white">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form
                                        action="{{ route('gudang-pakan.bahan-pakan-masuk.destroy', $data->id) }}"
                                        method="post"
                                        class="form-delete"
                                        data-tanggal="{{ $data->tanggal->translatedFormat('l, d F Y') }}"
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
                            <td colspan="6" class="text-center">Data Bahan Pakan Masuk tidak tersedia</td>
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
            <x-mobile-card title="{{ $data->nama_pic_user }}" subtitle="{{ $data->tanggal->translatedFormat('l, d F Y') }}">
                <div class="data-row">
                    <span class="data-label">Supplier</span>
                    <span class="data-value">{{ $data->nama_supplier }}</span>
                </div>
                <div class="data-row">
                    <span class="data-label">Asal</span>
                    <span class="data-value">{{ $data->asal->title() }}</span>
                </div>
                <x-slot name="actions">
                    <a href="{{ route('gudang-pakan.bahan-pakan-masuk.edit', $data->id) }}" class="btn btn-warning btn-sm text-white">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <form action="{{ route('gudang-pakan.bahan-pakan-masuk.destroy', $data->id) }}" method="post" class="form-delete flex-1" data-tanggal="{{ $data->tanggal->translatedFormat('l, d F Y') }}">
                        @csrf
                        @method('delete')
                        <button class="btn btn-danger btn-sm w-100"><i class="fas fa-trash"></i> Hapus</button>
                    </form>
                </x-slot>
            </x-mobile-card>
        @empty
            <p class="text-center text-muted">Data Bahan Pakan Masuk tidak tersedia</p>
        @endforelse
        @if ($datas->hasPages())
            <div class="d-flex justify-content-end mt-3">{{ $datas->links('components.pagination') }}</div>
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
                title: `Hapus Bahan Pakan Masuk "${tanggal}"?`,
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
