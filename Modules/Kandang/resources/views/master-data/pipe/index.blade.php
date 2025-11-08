@extends('adminlte::page')

@section('title', 'Pipe')

@section('content_header')
    <h1>Pipe</h1>
@endsection

@section('content')
    <div style="max-width: 900px;">
        <x-form-alert />
        
        <div class="card">
            <div class="card-header">
                <form action="{{ route('master-data.pipe.index', request()->all()) }}" method="get">
                    <div class="d-flex justify-content-between align-items-center">
                        <h2 class="card-title">Daftar Pipe</h2>
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
                        <th>#</th>
                        <th>Nama</th>
                        <th>Aksi</th>
                    </thead>
                    <tbody>
                        @foreach($datas as $row)
                            <tr>
                                <td>{{ ($loop->index + 1) + (request()->get('page', 1) * 10 - 10) }}</td>
                                <td>{{ $row->nama }}</td>
                                <td>
                                    <div class="d-flex" style="gap: .5em">
                                        <a href="{{ route('master-data.pipe.edit', $row->id) }}" class="btn btn-primary btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('master-data.pipe.destroy', $row->id) }}" method="post" data-nama="{{ $row->nama }}" class="form-delete">
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
    <script>
        $('.form-delete').on('submit', function(e) {
            e.preventDefault()
            
            Swal.fire({
                title: `Apakah kamu yakin akan menghapus Pipe ${$(this).data('nama')}?`,
                showCancelButton: true,
                confirmButtonText: "Ya, Hapus",
                cancelButtonText: "Batal"
            }).then((result) => {
                if (result.value) {
                    this.submit()
                }
            });
        })
    </script>
@endpush