@extends('layouts.dashboard')

@section('title', 'Distribusi Pakan Jadi')

@section('content_header')
    <x-page-header title="Distribusi Pakan Jadi" :breadcrumbs="['Distribusi Pakan Jadi' => '']">
        <x-slot name="actions">
            <a href="{{ route('gudang-pakan.pakan-finished-good-distribusi.create') }}" class="btn btn-primary">
                <i class="fas fa-plus d-sm-none"></i>
                <span class="d-none d-sm-inline">Tambah Distribusi Pakan Jadi</span>
            </a>
        </x-slot>
    </x-page-header>
@endsection

@section('content')
<div class="mx-1000">
    <x-form-alert />

    <x-filter-panel action="{{ route('gudang-pakan.pakan-finished-good-distribusi.index') }}" resetUrl="{{ route('gudang-pakan.pakan-finished-good-distribusi.index') }}">
        <div class="col-12 col-md-4">
            <input
                type="search"
                name="search"
                class="form-control"
                placeholder="Nama Formulasi ..."
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
                        <x-sort-th class="align-middle" style="min-width: 150px;" label="Formulasi" name="nama_formulasi" />
                        <x-sort-th class="align-middle" style="min-width: 150px;" label="Tanggal" name="tanggal" />
                        <x-sort-th class="align-middle" style="min-width: 150px;" label="Jumlah" name="jumlah" />
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($datas as $data)
                        <tr>
                            <td>{{ ($datas->currentPage() - 1) * $datas->perPage() + $loop->iteration }}</td>
                            <td class="text-left">{{ $data->nama_pic_user }}</td>
                            <td class="text-left">{{ $data->nama_formulasi }}</td>
                            <td class="text-left">{{ $data->tanggal->translatedFormat('l, d F Y - H:i') }}</td>
                            <td class="text-right">{{ format_angka($data->jumlah) }}</td>
                            <td>
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('gudang-pakan.pakan-finished-good-distribusi.edit', $data->id) }}" class="btn btn btn-info btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form
                                        action="{{ route('gudang-pakan.pakan-finished-good-distribusi.destroy', $data->id) }}"
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
                            <td colspan="6" class="text-center">Data Distribusi Pakan Jadi tidak tersedia</td>
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
            <x-mobile-card title="{{ $data->nama_formulasi }}" subtitle="{{ $data->tanggal->translatedFormat('l, d F Y - H:i') }}">
                <div class="data-row">
                    <span class="data-label">Pic</span>
                    <span class="data-value">{{ $data->nama_pic_user }}</span>
                </div>
                <div class="data-row">
                    <span class="data-label">Jumlah</span>
                    <span class="data-value">{{ format_angka($data->jumlah) }}</span>
                </div>
                <x-slot name="actions">
                    <a href="{{ route('gudang-pakan.pakan-finished-good-distribusi.edit', $data->id) }}" class="btn btn-info btn-sm">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <form
                        action="{{ route('gudang-pakan.pakan-finished-good-distribusi.destroy', $data->id) }}"
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
            <x-empty-state icon="box" title="Belum Ada Data" description="Data distribusi pakan jadi tidak tersedia." />
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
                title: `Hapus Formulasi Bahan Pakan "${nama}"?`,
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
