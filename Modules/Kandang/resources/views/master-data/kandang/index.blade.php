@extends('adminlte::page')

@section('title', 'Flock')

@section('content_header')
    <h1 class="font-weight-bold">Manajemen Kandang</h1>
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
                   <th style="width: 50px;">#</th>
                <th>Nama</th>
                <th>Alamat</th>
                <th>Total Flock</th>
                <th>Total Kapasitas Ayam</th>
                <th style="width: 150px;">Aksi</th>

                </thead>
                 <tbody>
            @forelse($datas as $row)
                <tr>
                    <td class="text-center">{{ ($loop->index + 1) + (request()->get('page', 1) * 10 - 10) }}</td>
                    <td>{{ $row->nama }}</td>
                    <td>{{ $row->alamat }}</td>
                    <td class="text-center">{{ count($row->flocks) ?? 0 }}</td>
                    <td class="text-center">{{ $row->flocks->sum('capacity') }}</td>
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
