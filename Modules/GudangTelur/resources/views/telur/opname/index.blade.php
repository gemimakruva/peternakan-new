@extends('layouts.dashboard')

@section('title', 'List Telur Opname')

@section('content_header')
<x-page-header title="List Telur Opname" :breadcrumbs="['Telur Inventory' => route('gudang-telur.telur-inventory.index'), 'Telur Opname' => '']">
    <x-slot name="actions">
        <a href="{{ route('gudang-telur.telur-opname.create') }}" class="btn btn-primary">Tambah Telur Opname</a>
    </x-slot>
</x-page-header>
@endsection

@section('content')
<div class="mx-1000">
    <x-form-alert />

    <x-filter-panel action="{{ route('gudang-telur.telur-opname.index', request()->all()) }}" resetUrl="{{ route('gudang-telur.telur-opname.index') }}">
        <div class="col-12 col-md-4">
            <x-adminlte-input label="Tanggal" type="date" name="tanggal" fgroup-class="mb-0" :value="request()->query('tanggal')" />
        </div>
        <div class="col-12 col-md-4">
            <input type="search" name="search" class="form-control" placeholder="Pic User, Asal Telur" value="{{ request()->query('search') }}">
        </div>
    </x-filter-panel>

    <div class="card desktop-table d-none d-md-block">
        <div class="card-body table-responsive p-0">
            <table class="table table-hover table-striped table-bordered text-center mb-0">
                <thead>
                    <tr>
                        <th class="align-middle" style="width: 40px;">#</th>
                        <x-sort-th class="align-middle" style="min-width: 150px;" label="Tanggal" name="tanggal" />
                        <x-sort-th class="align-middle" style="min-width: 150px;" label="Pic User" name="nama_pic_user" />
                        <th class="align-middle" style="width: 40px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($datas as $data)
                        <tr>
                            <td>{{ ($datas->currentPage() - 1) * $datas->perPage() + $loop->iteration }}</td>
                            <td class="text-left">{{ $data->tanggal->translatedFormat('l, d F Y') }}</td>
                            <td class="text-left">{{ $data->nama_pic_user }}</td>
                            <td>
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('gudang-telur.telur-opname.edit', $data->id) }}" class="btn btn-sm btn-warning text-white">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form
                                        action="{{ route('gudang-telur.telur-opname.destroy', $data->id) }}"
                                        method="post"
                                        class="form-delete"
                                        data-tanggal="{{ $data->tanggal->translatedFormat('l, d F Y') }}"
                                    >
                                        @csrf
                                        @method('delete')
                                        <button class="btn btn-danger btn-sm">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">Data Telur Opname tidak tersedia</td>
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
            <x-mobile-card title="{{ $data->tanggal->translatedFormat('l, d F Y') }}" subtitle="{{ $data->nama_pic_user }}">
                <x-slot name="actions">
                    <a href="{{ route('gudang-telur.telur-opname.edit', $data->id) }}" class="btn btn-warning btn-sm text-white">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <form action="{{ route('gudang-telur.telur-opname.destroy', $data->id) }}" method="post" class="form-delete" data-tanggal="{{ $data->tanggal->translatedFormat('l, d F Y') }}">
                        @csrf
                        @method('delete')
                        <button class="btn btn-danger btn-sm"><i class="fas fa-trash"></i> Hapus</button>
                    </form>
                </x-slot>
            </x-mobile-card>
        @empty
            <x-empty-state icon="egg" title="Belum Ada Data" description="Data opname telur tidak tersedia." />
        @endforelse
        @if ($datas->hasPages())
            <div class="d-flex justify-content-end mt-2">
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
            title: `Hapus Data Telur Opname "${tanggal}"?`,
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