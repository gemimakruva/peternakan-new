@extends('adminlte::page')

@section('title', 'Flock')

@section('content_header')
<div class="mb-4 text-center d-flex flex-column align-items-center pt-3" style="max-width: 1200px;">
    <h2 class="h4 fw-bold text-dark">Manajemen Pipe</h2>
    <span class="text-muted mb-0" style="max-width: 600px;">
        Halaman ini digunakan untuk menampilkan daftar pipe serta
        informasi kapasitas pada setiap pipe.
    </span>
</div>
@endsection

@section('content')
<div style="max-width: 1200px;">
    <x-form-alert />
    <div class="card shadow-sm">
        <div class="card-header text-white d-flex justify-content-between align-items-center"
             style="background-color: #495057; border-color: #495057;">
            <form action="{{ route('master-data.kandang.index', request()->all()) }}" method="get" class="w-100">
                <div class="d-flex justify-content-between align-items-center">
                    <h2 class="card-title mb-0">Daftar Pipe</h2>

                    <div class="d-flex" style="gap: .5em">
                        <input type="search" 
                               name="search" 
                               class="form-control form-control-sm" 
                               placeholder="Kandang atau Flock" 
                               value="{{ request()->query('search') }}">
                        <button class="btn btn-dark btn-sm" title="Cari">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <div class="card-body table-responsive p-0">
            <table class="table table-hover table-striped table-bordered text-center mb-0">
                <thead class="bg-light">
                  <tr>
                        <th>#</th>
                        <th>Nama</th>
                        <th>Kapasitas</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($datas as $row)
                    <tr>
                        <td>{{ ($loop->index + 1) + (request()->get('page', 1) - 1) * $datas->perPage() }}</td>
                        <td>{{ $row->nama }}</td>
                        <td>{{ $row->kapasitas }}</td>
                        <td class="text-center">
                        <div class="d-flex justify-content-center" style="gap: .5em">
                            <a href="{{ route('master-data.pipe.edit', $row) }}" class="btn btn-warning text-white btn-sm">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('master-data.pipe.destroy', $row->id) }}" 
                                method="post" 
                                data-nama="{{ $row->pipe_name }}" 
                                class="form-delete d-inline">
                                @csrf
                                @method('delete')
                                <button class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>

                    </tr>
                    @endforeach
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
                title: `Hapus Pipe "${nama}"?`,
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
