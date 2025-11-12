@extends('adminlte::page')

@section('title', 'Pipe')

@section('content_header')
    <h1> Management Pipe</h1>
@endsection

@section('content')
<div>
    <x-form-alert />

    <div class="card">
        <div class="card-header">
            <form action="{{ route('master-data.pipe.index', request()->all()) }}" method="get">
                <div class="d-flex justify-content-between align-items-center">
                    <h2 class="card-title">Daftar Seluruh Pipe</h2>
                    <div class="d-flex" style="gap: .5em">
                        <input type="search" name="search" class="form-control form-control-sm" placeholder="Cari Nama Pipe" value="{{ request()->query('search') }}">
                        <button class="btn btn-primary btn-sm">
                            <i class="fas fa-search"></i>
                        </button>
                        <a href="{{ route('master-data.pipe.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i>
                        </a>
                    </div>
                </div>
            </form>
        </div>

        <div class="card-body table-responsive">
            <table class="table table-striped table-bordered table-sm" style="border-top: 2px solid #ddd;">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama</th>
                        <th>Capacity</th>
                        <th>Initial Population</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($datas as $row)
                    <tr>
                        <td>{{ ($loop->index + 1) + (request()->get('page', 1) - 1) * $datas->perPage() }}</td>
                        <td>{{ $row->pipe_name }}</td>
                        <td>{{ $row->capacity }}</td>
                        <td>{{ $row->initial_population }}</td>
                        <td>
                            <div class="d-flex" style="gap: .5em">
                                <a href="{{ route('master-data.pipe.edit', $row->id) }}" class="btn btn-primary btn-sm">
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

            <div class="d-flex justify-content-end pt-2">
                {{ $datas->links('components.pagination') }}
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
    {{-- SweetAlert2 CDN --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- Konfirmasi Delete --}}
    <script>
        $(function() {
            $(document).on('submit', '.form-delete', function(e) {
                e.preventDefault();
                const nama = $(this).data('nama');

                Swal.fire({
                    title: `Apakah kamu yakin akan menghapus Pipe "${nama}"?`,
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
        });
    </script>
@endpush
