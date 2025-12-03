@extends('adminlte::page')

@section('title', 'Baris')

@section('content_header')
<div class="mb-4 text-center d-flex flex-column align-items-center" style="max-width: 1200px;">
    <h2 class="h4 fw-bold text-dark">Jenis Pakan</h2>
    <span class="text-muted mb-0" style="max-width: 600px;">
        Halaman ini digunakan untuk mengelolah jenis pakan yang akan diberikan
        kepada hewan ternak peternakan
    </span>
</div>
@endsection

@section('content')
<div>
    <x-form-alert />
    <div style="max-width: 1200px;" class="card shadow-sm">
        <div class="card-header text-white d-flex justify-content-between align-items-center"
             style="background-color: #495057; border-color: #495057;">
            <form action="" 
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
                      <a href="{{ route('master-data.jenis-pakan.create') }}" 
                            class="btn btn-light btn-sm text-dark" title="Tambah Jenis Pakan">
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
                        <th>Nama Pakan</th>
                        <th style="width: 180px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($jenisPakan as $row)
                    <tr>
                        <td>{{ ($loop->index + 1) + ($jenisPakan->currentPage() - 1) * $jenisPakan->perPage() }}</td>
                        <td>{{ $row->nama ?? '-' }}</td>
                        <td>
                            <div style="gap: 6px" class="btn-group" role="group">
                                <a href="{{ route('master-data.jenis-pakan.edit',$row) }}"
                                 class="btn btn-warning text-white btn-sm" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                @can('Jenis Pakan')
                                <form action="{{ route('master-data.jenis-pakan.destroy', $row) }}" 
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
            {{ $jenisPakan->links('components.pagination') }}
        </div>
    </div>
</div>
@endsection

@push('js')
   <script>
    $(document).on('submit', '.form-delete', function(e) {
        e.preventDefault(); 
        let form = this;
        let nama = $(this).data('nama'); 

        Swal.fire({
            title: "Yakin ingin menghapus?",
            text: "Data \"" + nama + "\" akan dihapus permanen!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Ya, hapus!",
            cancelButtonText: "Batal"
        }).then((result) => {
            console.log(result)
            if (result.value) {
                form.submit(); 
            }
        });
    });
</script>

@endpush
