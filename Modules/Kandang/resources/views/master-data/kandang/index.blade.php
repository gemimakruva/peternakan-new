@extends('adminlte::page')

@section('title', 'Kandang')

@section('content_header')
    <h1>Kandang</h1>
@endsection

@section('content')
    <div>
        <x-form-alert />

        <div class="card shadow-sm">
            <div class="card-header text-white d-flex justify-content-between align-items-center"
                style="background-color: #495057; border-color: #495057;">
                <form action="{{ route('master-data.kandang.index', request()->all()) }}" method="get" class="w-100">
                    <div class="d-flex justify-content-between align-items-center">
                        <h2 class="card-title mb-0">Daftar Kandang</h2>

                        <div class="d-flex" style="gap: .5em">
                            <input type="search" 
                                   name="search" 
                                   class="form-control form-control-sm" 
                                   placeholder="Cari Nama Kandang" 
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

        <div class="card-body table-responsive">
    <table class="table table-striped table-bordered table-sm align-middle" style="border-top: 2px solid #ddd;">
        <thead class="text-center table-secondary">
            <tr>
                <th style="width: 50px;">#</th>
                <th>Nama</th>
                <th>Alamat</th>
                <th>Total Flock</th>
                <th>Total Kapasitas Ayam</th>
                <th style="width: 150px;">Aksi</th>
            </tr>
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
            title: `Apakah kamu yakin akan menghapus Kandang ${$(this).data('nama')}?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: "Ya, Hapus",
            cancelButtonText: "Batal",
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
        }).then((result) => {
            if (result.value) {
                this.submit()
            }
        });
    })
</script>
@endpush
