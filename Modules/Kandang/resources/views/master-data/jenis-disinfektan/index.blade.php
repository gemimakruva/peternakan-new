@extends('layouts.dashboard')

@section('title', 'Jenis Disinfektan')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <div class="d-flex align-items-center gap-1">
                    <h1>Jenis Disinfektan</h1>
                    @can('Tambah Jenis Disinfektan')
                        <a href="{{ route('master-data.jenis-disinfektan.create') }}" class="btn btn-primary">Tambah Jenis Disinfektan</a>
                    @endcan
                </div>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Master Data</a></li>
                    <li class="breadcrumb-item active">Jenis Disinfektan</li>
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
                <form action="{{ route('master-data.jenis-disinfektan.index', request()->all()) }}" method="get" class="w-100">
                    <div class="d-flex justify-content-end align-items-center">
                        <div class="d-flex gap-2">
                            <input type="search" name="search" class="form-control" placeholder="Cari Jenis Disinfektan..." value="{{ request()->query('search') }}">
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
                        <th>Nama Disinfektan</th>
                        <th style="width: 150px;">Aksi</th>
                    </thead>
                    <tbody>
                        @forelse($jenisDisinfektan as $row)
                            <tr>
                                <td class="text-center">{{ ($loop->index + 1) + ($jenisDisinfektan->currentPage() - 1) * $jenisDisinfektan->perPage() }}</td>
                                <td class="text-left">{{ $row->nama }}</td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center" style="gap: .5em">
                                        @can('Edit Jenis Disinfektan')
                                            <a href="{{ route('master-data.jenis-disinfektan.edit', $row) }}" class="btn btn-sm btn-warning text-white" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        @endcan

                                        @can('Hapus Jenis Disinfektan')
                                            <form action="{{ route('master-data.jenis-disinfektan.destroy', $row) }}" method="post"
                                                data-nama="{{ $row->nama }}" class="form-delete">
                                                @csrf
                                                @method('delete')
                                                <button class="btn btn-sm btn-danger" title="Hapus">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center text-muted py-3">
                                    Tidak ada data jenis disinfektan ditemukan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($jenisDisinfektan->hasPages())
                <div class="card-footer d-flex justify-content-end">
                    {{ $jenisDisinfektan->links('components.pagination') }}
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
                title: `Hapus Jenis Disinfektan "${nama}"?`,
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