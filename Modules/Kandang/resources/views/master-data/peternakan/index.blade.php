@extends('layouts.dashboard')

@section('title', 'Peternakan')

@section('content_header')
    <x-page-header title="Peternakan" :breadcrumbs="['Master Data' => '#', 'Peternakan' => '']">
        <x-slot name="actions">
            <a href="{{ route('master-data.peternakan.create') }}" class="btn btn-primary">Tambah Peternakan</a>
        </x-slot>
    </x-page-header>
@endsection

@section('content')
    <div class="mx-1200">
        <x-form-alert />

        <x-filter-panel action="{{ route('master-data.peternakan.index', request()->all()) }}" resetUrl="{{ route('master-data.peternakan.index') }}">
            <div class="col-12 col-md-4">
                <input type="search" name="search" class="form-control" placeholder="Cari Peternakan..." value="{{ request()->query('search') }}">
            </div>
        </x-filter-panel>

        <div class="card desktop-table d-none d-md-block">
            <div class="card-body table-responsive p-0">
                <table class="table table-hover table-striped table-bordered text-center">
                    <thead class="bg-light">
                        <th style="width: 50px;">#</th>
                        <x-sort-th label="Nama Peternakan" name="nama"></x-sort-th>
                        <th>Lokasi</th>
                        <th style="width: 150px;">Aksi</th>
                    </thead>
                    <tbody>
                        @forelse($datas as $row)
                            <tr>
                                <td class="text-center">{{ ($loop->index + 1) + (request()->get('page', 1) * 10 - 10) }}</td>
                                <td class="text-left">{{ $row->nama }}</td>
                                <td class="text-left">{{ $row->lokasi }}</td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center" style="gap: .5em">
                                        <a href="{{ route('master-data.peternakan.edit', $row->id) }}" class="btn btn-sm btn-warning text-white" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        @if (!$row->kandang()->exists())
                                            <form action="{{ route('master-data.peternakan.destroy', $row->id) }}" method="post"
                                                data-nama="{{ $row->nama }}" class="form-delete">
                                                @csrf
                                                @method('delete')
                                                <button class="btn btn-sm btn-danger" title="Hapus">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-3">
                                    Tidak ada data peternakan ditemukan.
                                </td>
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
                <x-mobile-card title="{{ $row->nama }}" subtitle="{{ $row->lokasi }}">
                    <x-slot name="actions">
                        <a href="{{ route('master-data.peternakan.edit', $row->id) }}" class="btn btn-warning btn-sm text-white">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        @if (!$row->kandang()->exists())
                            <form action="{{ route('master-data.peternakan.destroy', $row->id) }}" method="post"
                                data-nama="{{ $row->nama }}" class="form-delete d-inline">
                                @csrf
                                @method('delete')
                                <button class="btn btn-sm btn-danger">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </form>
                        @endif
                    </x-slot>
                </x-mobile-card>
            @empty
                <div class="text-center text-muted p-4">Tidak ada data peternakan ditemukan.</div>
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
                title: `Hapus Peternakan "${nama}"?`,
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