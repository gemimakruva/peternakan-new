@extends('layouts.dashboard')

@section('title', 'Peternakan')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <div class="d-flex align-items-center gap-1">
                    <h1>Peternakan</h1>
                    @can('Tambah Peternakan')
                        <a href="{{ route('master-data.peternakan.create') }}" class="btn btn-primary">Tambah Peternakan</a>
                    @endcan
                </div>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Master Data</a></li>
                    <li class="breadcrumb-item active">Peternakan</li>
                </ol>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="mx-1200">
        <x-form-alert />

        <div class="card">
            <div class="card-header text-white d-flex justify-content-between align-items-center" >
                <form action="{{ route('master-data.peternakan.index', request()->all()) }}" method="get" class="w-100">
                    <div class="d-flex justify-content-end align-items-center">
                        <div class="d-flex gap-2">
                            <input type="search" name="search" class="form-control" placeholder="Cari Peternakan..." value="{{ request()->query('search') }}">
                            <button class="btn btn-primary" title="Cari">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>

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
                                        @can('Edit Peternakan')
                                            <a href="{{ route('master-data.peternakan.edit', $row->id) }}" class="btn btn-sm btn-warning text-white" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        @endcan

                                        @if (auth()->user()->can('Hapus Peternakan') && !$row->kandang()->exists())
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
    </div>
@endsection
@push('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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