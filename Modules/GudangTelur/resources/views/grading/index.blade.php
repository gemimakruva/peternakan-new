@extends('layouts.dashboard')

@section('title', 'Grading Telur')

@section('content_header')
<x-page-header title="Grading Telur" :breadcrumbs="['Grading Telur' => '']">
    <x-slot name="actions">
        <a href="{{ route('gudang-telur.telur-grading.create') }}" class="btn btn-primary">Tambah Grading Telur</a>
    </x-slot>
</x-page-header>
@endsection

@section('content')
<div class="mx-1000">
    <x-form-alert />

    <x-filter-panel action="{{ route('gudang-telur.telur-grading.index', request()->all()) }}" resetUrl="{{ route('gudang-telur.telur-grading.index') }}">
        <div class="col-12 col-md-4">
            <x-adminlte-select name="kandang_id" fgroup-class="mb-0">
                <x-adminlte-options :options="$listKandang" empty-option="Semua Kandang" :selected="request()->query('kandang_id')" />
            </x-adminlte-select>
        </div>
        <div class="col-12 col-md-4">
            <input type="search" name="search" class="form-control" placeholder="Pic User ..." value="{{ request()->query('search') }}">
        </div>
    </x-filter-panel>

    <div class="card desktop-table d-none d-md-block">
        <div class="card-body table-responsive p-0">
            <table class="table table-hover table-striped table-bordered text-center mb-0">
                <thead>
                    <tr>
                        <th class="align-middle" style="width: 40px;">#</th>
                        <x-sort-th class="align-middle" style="min-width: 150px;" label="Tanggal" name="tanggal" />
                        <x-sort-th class="align-middle" style="min-width: 150px;" label="Kandang" name="nama_kandang" />
                        <x-sort-th class="align-middle" style="min-width: 150px;" label="Pic User" name="nama_pic_user" />
                        <th class="align-middle" style="width: 40px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($datas as $data)
                        <tr>
                            <td>{{ ($datas->currentPage() - 1) * $datas->perPage() + $loop->iteration }}</td>
                            <td class="text-left">{{ $data->tanggal->translatedFormat('l, d F Y') }}</td>
                            <td class="text-left">{{ $data->nama_kandang }}</td>
                            <td class="text-left">{{ $data->nama_pic_user }}</td>
                            <td>
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('gudang-telur.telur-grading.edit', $data->id) }}" class="btn btn-sm btn-warning text-white">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form
                                        action="{{ route('gudang-telur.telur-grading.destroy', $data->id) }}"
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
                            <td colspan="5" class="text-center">Data Grading Telur tidak tersedia</td>
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
            <x-mobile-card title="{{ $data->tanggal->translatedFormat('l, d F Y') }}" subtitle="{{ $data->nama_kandang }}">
                <div class="data-row">
                    <span class="data-label">Pic User</span>
                    <span class="data-value">{{ $data->nama_pic_user }}</span>
                </div>
                <x-slot name="actions">
                    <a href="{{ route('gudang-telur.telur-grading.edit', $data->id) }}" class="btn btn-warning btn-sm text-white">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <form action="{{ route('gudang-telur.telur-grading.destroy', $data->id) }}" method="post" class="form-delete" data-tanggal="{{ $data->tanggal->translatedFormat('l, d F Y') }}">
                        @csrf
                        @method('delete')
                        <button class="btn btn-danger btn-sm"><i class="fas fa-trash"></i> Hapus</button>
                    </form>
                </x-slot>
            </x-mobile-card>
        @empty
            <x-empty-state icon="egg" title="Belum Ada Data" description="Data grading telur tidak tersedia." />
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
            title: `Hapus Data Grading Telur "${tanggal}"?`,
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