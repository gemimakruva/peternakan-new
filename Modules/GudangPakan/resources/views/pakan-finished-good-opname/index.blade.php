@extends('layouts.dashboard')

@section('title', 'Opname Pakan Jadi')

@section('content_header')
    <x-page-header title="Opname Pakan Jadi" :breadcrumbs="['Opname Pakan Jadi' => '']">
        <x-slot name="actions">
            <a href="{{ route('gudang-pakan.pakan-finished-good-opname.create') }}" class="btn btn-primary">
                <i class="fas fa-plus d-sm-none"></i>
                <span class="d-none d-sm-inline">Tambah Opname Pakan Jadi</span>
            </a>
        </x-slot>
    </x-page-header>
@endsection

@section('content')
<div class="mx-900">
    <x-form-alert />

    <x-filter-panel action="{{ route('gudang-pakan.pakan-finished-good-opname.index') }}" resetUrl="{{ route('gudang-pakan.pakan-finished-good-opname.index') }}">
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
                        <th class="align-middle" style="width: 40px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($datas as $data)
                        <tr>
                            <td>{{ ($datas->currentPage() - 1) * $datas->perPage() + $loop->iteration }}</td>
                            <td class="text-left">{{ $data->nama_pic_user }}</td>
                            <td class="text-left">{{ $data->tanggal->translatedFormat('l, d F Y') }}</td>
                            <td>
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('gudang-pakan.pakan-finished-good-opname.edit', $data->id) }}" class="btn btn-sm btn-warning text-white">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form
                                        action="{{ route('gudang-pakan.pakan-finished-good-opname.destroy', $data->id) }}"
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
                            <td colspan="4" class="text-center">Data Opname Pakan Jadi tidak tersedia</td>
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
                <x-slot name="actions">
                    <a href="{{ route('gudang-pakan.pakan-finished-good-opname.edit', $data->id) }}" class="btn btn-warning btn-sm text-white">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <form
                        action="{{ route('gudang-pakan.pakan-finished-good-opname.destroy', $data->id) }}"
                        method="post"
                        class="form-delete"
                        data-tanggal="{{ $data->tanggal->translatedFormat('l, d F Y') }}"
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
            <x-empty-state icon="box" title="Belum Ada Data" description="Data opname pakan jadi tidak tersedia." />
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
                title: `Hapus Opname Pakan Jadi "${tanggal}"?`,
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
