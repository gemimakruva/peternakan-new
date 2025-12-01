@extends('adminlte::page')

@section('title', 'Baris')

@section('content_header')
<div class="mb-4 text-center d-flex flex-column align-items-center" style="max-width: 1200px;">
    <h2 class="h4 fw-bold text-dark">Manajemen Baris</h2>
    <span class="text-muted mb-0" style="max-width: 600px;">
        Halaman ini digunakan untuk mengelola data Baris, termasuk penambahan,
         pembaruan, dan penghapusan data.
    </span>
</div>
@endsection

@section('content')
<div>
    <x-form-alert />
    <div style="max-width: 1200px;" class="card shadow-sm">
        <div class="card-header text-white d-flex justify-content-between align-items-center"
             style="background-color: #495057; border-color: #495057;">
            <form action="{{ route('master-data.flock.index', request()->all()) }}" 
                method="get" class="w-100">
                <div class="d-flex justify-content-between align-items-center">
                    <h2 class="card-title mb-0">Daftar Baris</h2>
                    <div class="d-flex" style="gap: .5em">
                        <input type="search" 
                               name="search" 
                               class="form-control form-control-sm" 
                               placeholder="Cari baris..." 
                               value="{{ request()->query('search') }}">
                        <button class="btn btn-dark btn-sm" title="Cari">
                            <i class="fas fa-search"></i>
                        </button>

                        @can('Tambah Baris')
                        <a href="{{ route('master-data.flock.create') }}" 
                        class="btn btn-light btn-sm text-dark" title="Tambah Kandang">
                            <i class="fas fa-plus"></i>
                        </a>
                        @endcan
                    </div>
                </div>
            </form>
        </div>

        <div class="card-body table-responsive p-0">
            <table class="table table-hover table-striped table-bordered text-center mb-0">
                <thead class="bg-light">
                    <tr>
                        <th style="width: 50px;">#</th>
                        <th>Nama Kandang</th>
                        <th>Nama Baris</th>
                        <th style="width: 180px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($datas as $row)
                    <tr>
                        <td>{{ ($loop->index + 1) + ($datas->currentPage() - 1) * $datas->perPage() }}</td>
                        <td>{{ $row->kandang->nama ?? '-' }}</td>
                        <td>{{ $row->nama }}</td>
                        <td>
                            <div style="gap: 6px" class="btn-group" role="group">
                                <a href="{{ route('master-data.pipe.byFlock',
                                 $row) }}" class="btn btn-info btn-sm" title="Lihat Detail">
                                    <i class="fas fa-eye"></i>
                                </a>

                                <a href="{{ route('master-data.flock.edit',
                                 $row) }}" class="btn btn-warning text-white btn-sm" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                @can('Hapus Flock')
                                <form action="{{ route('master-data.flock.destroy', 
                                $row) }}" 
                                      method="post" 
                                      data-nama="{{ $row->nama }}" 
                                      class="form-delete d-inline">
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
                        <td colspan="6" class="text-muted">Belum ada data baris.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="card-footer d-flex justify-content-end">
            {{ $datas->links('components.pagination') }}
        </div>
    </div>
</div>
@endsection

{{-- @push('js')
    <script>
        $(document).on('submit', '.form-delete', function(e) {
            e.preventDefault();
            const nama = $(this).data('nama');
            Swal.fire({
                title: `Hapus Baris "${nama}"?`,
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
@endpush --}}
