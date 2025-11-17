@extends('adminlte::page')

@section('title', 'Flock')

@section('content_header')
    <h1 class="font-weight-bold">Manajemen Flock</h1>
@endsection

@section('content')
<div>
    <x-form-alert />

    <div class="card shadow-sm">
        <div class="card-header text-white d-flex justify-content-between align-items-center"
             style="background-color: #495057; border-color: #495057;">
            <form action="{{ route('master-data.kandang.index', request()->all()) }}" method="get" class="w-100">
                <div class="d-flex justify-content-between align-items-center">
                    <h2 class="card-title mb-0">Daftar Flock</h2>

                    <div class="d-flex" style="gap: .5em">
                        <input type="search" 
                               name="search" 
                               class="form-control form-control-sm" 
                               placeholder="Kandang atau Flock" 
                               value="{{ request()->query('search') }}">
                        <button class="btn btn-dark btn-sm" title="Cari">
                            <i class="fas fa-search"></i>
                        </button>

                        @can('Tambah Flock')
                        <a href="{{ route('master-data.flock.create') }}" class="btn btn-light btn-sm text-dark" title="Tambah Kandang">
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
                        <th>Nama Flock</th>
                        <th>Nama Kandang</th>
                        <th>Tanggal Masuk</th>
                        <th>Kapasitas</th>
                        <th style="width: 180px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($datas as $row)
                    <tr>
                        <td>{{ ($loop->index + 1) + ($datas->currentPage() - 1) * $datas->perPage() }}</td>
                        <td>{{ $row->flock_name }}</td>
                        <td>{{ $row->kandang->nama ?? '-' }}</td>
                        <td>{{ \Carbon\Carbon::parse($row->date_in)->format('d M Y') }}</td>
                        <td>{{ $row->pipes->sum('capacity') }}</td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('master-data.pipe.byFlock', $row->id) }}" class="btn btn-info btn-sm" title="Lihat Detail">
                                    <i class="fas fa-eye"></i>
                                </a>

                                <a href="{{ route('master-data.flock.edit', $row) }}" class="btn btn-primary btn-sm" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>

                                @can('Hapus Flock')
                                <form action="{{ route('master-data.flock.destroy', $row) }}" 
                                      method="post" 
                                      data-nama="{{ $row->flock_name }}" 
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
                        <td colspan="6" class="text-muted">Belum ada data flock.</td>
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

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).on('submit', '.form-delete', function(e) {
            e.preventDefault();
            const nama = $(this).data('nama');

            Swal.fire({
                title: `Hapus Flock "${nama}"?`,
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
