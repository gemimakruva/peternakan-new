@extends('adminlte::page')

@section('title', 'Flock')

@section('content_header')
<div class="mb-4 text-center d-flex flex-column align-items-center">
    <h2 class="h4 fw-bold text-dark">Manajemen Kandang</h2>
    <span class="text-muted mb-0" style="max-width: 600px;">
        Halaman ini digunakan untuk mengelola data kandang, termasuk penambahan, pembaruan, dan penghapusan data.
    </span>
</div>

@endsection


@section('content')
<div>
    <x-form-alert />
    <div class="card shadow-sm" style="max-width: 1200px;">
        <div class="card-header text-white d-flex justify-content-between align-items-center"
             style="background-color: #495057; border-color: #495057;">
            <form action="{{ route('master-data.kandang.index', request()->all()) }}" method="get" class="w-100">
                <div class="d-flex justify-content-between align-items-center">
                    <h2 class="card-title mb-0 text-center">Daftar Kandang</h2>

                    <div class="d-flex" style="gap: .5em">
                        <input type="search" 
                               name="search" 
                               class="form-control form-control-sm" 
                               placeholder="Cari kandang..." 
                               value="{{ request()->query('search') }}">
                        <button class="btn btn-dark btn-sm" title="Cari">
                            <i class="fas fa-search"></i>
                        </button>

                        @can('Tambah Kandang')
                        <a href="{{ route('master-data.kandang.create') }}" class="btn btn-light btn-sm text-dark" title="Tambah Kandang">
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
                   <th style="width: 50px;">#</th>
                <th>Nama</th>
                <th>Nama Peternakan</th>
                <th style="width: 150px;">Aksi</th>

                </thead>
                 <tbody>
            @forelse($kandang as $row)
                <tr>
                    <td class="text-center">{{ ($loop->index + 1) + (request()->get('page', 1) * 10 - 10) }}</td>
                    <td>{{ $row->nama }}</td>
                    <td>{{ $row->peternakan->nama }}</td>
                    <td class="text-center">
                        <div class="d-flex justify-content-center" style="gap: .5em">
                            @can('Edit Kandang')
                            <a href="{{ route('master-data.kandang.edit', $row->id) }}" 
                               class="btn btn-sm btn-warning text-white" 
                               title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            @endcan

                            @can('Hapus Kandang')
                            <form action="{{ route('master-data.kandang.destroy', $row->id) }}" 
                                  method="post" 
                                  data-nama="{{ $row->nama }}" 
                                  class="form-delete">
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
                    <td colspan="6" class="text-center text-muted py-3">
                        Tidak ada data kandang ditemukan.
                    </td>
                </tr>
            @endforelse
        </tbody>
            </table>
        </div>

        <div class="card-footer d-flex justify-content-end">
            {{ $kandang->links('components.pagination') }}
        </div>
    </div>
</div>
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).on('submit', '.form-delete', function(e) {
            e.preventDefault();
            const nama = $(this).data('nama');

            Swal.fire({
                title: `Hapus Kandang "${nama}"?`,
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
