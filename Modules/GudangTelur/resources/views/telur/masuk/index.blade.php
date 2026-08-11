@extends('layouts.dashboard')

@section('title', 'List Telur Masuk')

@section('content_header')
<x-page-header title="List Telur Masuk" :breadcrumbs="['Telur Inventory' => route('gudang-telur.telur-inventory.index'), 'Telur Masuk' => '']">
    <x-slot name="actions">
        <a href="{{ route('gudang-telur.telur-masuk.create') }}" class="btn btn-primary">Tambah Telur Masuk</a>
    </x-slot>
</x-page-header>
@endsection

@section('content')
<div class="mx-1000">
    <x-form-alert />

    <x-filter-panel action="{{ route('gudang-telur.telur-masuk.index', request()->all()) }}" resetUrl="{{ route('gudang-telur.telur-masuk.index') }}">
        <div class="col-12 col-md-3">
            <x-adminlte-input label="Tanggal" type="date" name="date_start" fgroup-class="mb-0" :value="$dateStart" />
        </div>
        <div class="col-12 col-md-3">
            <x-adminlte-input type="date" name="date_end" fgroup-class="mb-0" :value="$dateEnd" />
        </div>
        <div class="col-12 col-md-3">
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
                        <x-sort-th class="align-middle" style="min-width: 150px;" label="Asal Telur" name="nama_telur_asal" />
                        <x-sort-th class="align-middle" style="min-width: 150px;" label="Jumlah" name="jumlah" />
                        <th class="align-middle" style="width: 40px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($datas as $data)
                        <tr>
                            <td>{{ ($datas->currentPage() - 1) * $datas->perPage() + $loop->iteration }}</td>
                            <td class="text-left">{{ $data->tanggal->translatedFormat('l, d F Y') }}</td>
                            <td class="text-left">{{ $data->nama_pic_user }}</td>
                            <td class="text-left">{{ $data->nama_telur_asal }}</td>
                            <td class="text-left">{{ $data->jumlah }}</td>
                            <td>
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('gudang-telur.telur-masuk.edit', $data->id) }}" class="btn btn-sm btn-warning text-white">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form
                                        action="{{ route('gudang-telur.telur-masuk.destroy', $data->id) }}"
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
                            <td colspan="6" class="text-center">Data Telur Masuk tidak tersedia</td>
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
                <div class="data-row">
                    <span class="data-label">Asal Telur</span>
                    <span class="data-value">{{ $data->nama_telur_asal }}</span>
                </div>
                <div class="data-row">
                    <span class="data-label">Jumlah</span>
                    <span class="data-value">{{ $data->jumlah }}</span>
                </div>
                <x-slot name="actions">
                    <a href="{{ route('gudang-telur.telur-masuk.edit', $data->id) }}" class="btn btn-warning btn-sm text-white">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <form action="{{ route('gudang-telur.telur-masuk.destroy', $data->id) }}" method="post" class="form-delete" data-tanggal="{{ $data->tanggal->translatedFormat('l, d F Y') }}">
                        @csrf
                        @method('delete')
                        <button class="btn btn-danger btn-sm"><i class="fas fa-trash"></i> Hapus</button>
                    </form>
                </x-slot>
            </x-mobile-card>
        @empty
            <x-empty-state icon="egg" title="Belum Ada Data" description="Data telur masuk tidak tersedia." />
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
            title: `Hapus Data Telur Masuk "${tanggal}"?`,
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