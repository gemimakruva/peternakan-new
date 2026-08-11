@extends('layouts.dashboard')

@section('title', 'Bahan Pakan Keluar')

@section('content_header')
    <x-page-header title="Bahan Pakan Keluar" :breadcrumbs="['Bahan Pakan Keluar' => '']">
        <x-slot name="actions">
            <a href="{{ route('gudang-pakan.bahan-pakan-keluar.create') }}" class="btn btn-primary">Tambah Bahan Pakan Keluar</a>
        </x-slot>
    </x-page-header>
@endsection


@section('content')
<div class="mx-1000">
    <x-form-alert />
    
    <x-filter-panel action="{{ route('gudang-pakan.bahan-pakan-keluar.index') }}" resetUrl="{{ route('gudang-pakan.bahan-pakan-keluar.index') }}">
        <div class="col-12 col-md-4">
            <x-adminlte-select
                name="tujuan"
                fgroup-class="mb-0 w-100"
            >
                <x-adminlte-options
                    :options="$listTujuan"
                    :selected="request()->query('tujuan')"
                    empty-option="Semua Tujuan"
                />
            </x-adminlte-select>
        </div>
        <div class="col-12 col-md-4">
            <input
                type="search"
                name="search"
                class="form-control"
                placeholder="Nama Pic ..."
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
                        <x-sort-th class="align-middle" style="min-width: 150px;" label="Pic" name="nama_pic_user" />
                        <x-sort-th class="align-middle" style="min-width: 150px;" label="Tanggal" name="tanggal" />
                        <x-sort-th class="align-middle" style="min-width: 150px;" label="Tujuan" name="tujuan" />
                        <th class="align-middle" style="width: 40px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($datas as $data)
                        <tr>
                            <td>{{ ($datas->currentPage() - 1) * $datas->perPage() + $loop->iteration }}</td>
                            <td class="text-left">{{ $data->nama_pic_user }}</td>
                            <td class="text-left">{{ $data->tanggal->translatedFormat('l, d F Y') }}</td>
                            <td class="text-left">{{ $data->tujuan->title() }}</td>
                            <td>
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('gudang-pakan.bahan-pakan-keluar.edit', $data->id) }}" class="btn btn-sm btn-warning text-white">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form
                                        action="{{ route('gudang-pakan.bahan-pakan-keluar.destroy', $data->id) }}"
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
                            <td colspan="6" class="text-center">Data Bahan Pakan Keluar tidak tersedia</td>
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
            <x-mobile-card title="{{ $data->nama_pic_user }}" subtitle="{{ $data->tanggal->translatedFormat('d F Y') }}">
                <div class="data-row">
                    <span class="data-label">Tujuan</span>
                    <span class="data-value">{{ $data->tujuan->title() }}</span>
                </div>
                <x-slot name="actions">
                    <a href="{{ route('gudang-pakan.bahan-pakan-keluar.edit', $data->id) }}" class="btn btn-sm btn-warning text-white">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <form
                        action="{{ route('gudang-pakan.bahan-pakan-keluar.destroy', $data->id) }}"
                        method="post"
                        class="form-delete flex-1"
                        data-tanggal="{{ $data->tanggal->translatedFormat('l, d F Y') }}"
                    >
                        @csrf
                        @method('delete')
                        <button class="btn btn-sm btn-danger w-100">
                            <i class="fas fa-trash"></i> Hapus
                        </button>
                    </form>
                </x-slot>
            </x-mobile-card>
        @empty
            <x-empty-state icon="box" title="Belum Ada Data" description="Data bahan pakan keluar tidak tersedia." />
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
                title: `Hapus Bahan Pakan Keluar "${tanggal}"?`,
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
