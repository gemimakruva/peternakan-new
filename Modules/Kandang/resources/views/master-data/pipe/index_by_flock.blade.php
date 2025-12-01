@extends('adminlte::page')

@section('title', 'Daftar Pipa')

@section('content_header')
<div class="mb-4 text-center d-flex flex-column align-items-center">

    <h2 class="h4 fw-bold text-dark">Manajemen Baris<h2 
        class="h4 fw-bold text-dark"> <span class="text-primary fw-bold">
         {{ $flock->nama }}
        </span>
    </h2>

    <span class="text-muted mb-0" style="max-width: 600px;">
        Halaman ini digunakan untuk menampilkan daftar pipa serta
        informasi kapasitas pada setiap pipa.
    </span>
</div>
@endsection

@section('content')
<div class="container-fluid px-2 px-md-4" style="max-width: 1200px;">
    <div class="row justify-content-center">
        <div class="col-lg-12">

            <div class="card shadow-sm border-0">
                <div class="card-header bg-light">
                    <h4 class="card-title m-0 fw-semibold text-secondary">
                        <i class="fas fa-tint me-2 text-muted"></i> Daftar Pipa
                    </h4>
                </div>

                <div class="card-body table-responsive">
                    <table class="table table-hover table-striped table-bordered text-center mb-0">
                        <thead class="table-secondary">
                            <tr>
                                <th style="width: 50px;">#</th>
                                <th>Nama Pipa</th>
                                <th>Kapasitas</th>
                                <th style="width: 150px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pipes as $pipe)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $pipe->nama ?? 'Pipe '.$pipe->id }}</td>
                                    <td>{{ number_format($pipe->kapasitas) }}</td>
                                    <td>
                                        <div style="gap: 6px"; class="btn-group" role="group">
                                            <a href="{{ route('master-data.pipe.edit',$pipe) }}" class="btn btn-warning text-white btn-sm" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form data-nama="{{ $pipe->nama }}" 
                                            action="{{ route('master-data.pipe.destroy',$pipe ) }}" 
                                            method="POST" class="form-delete d-inline" data-nama="
                                            {{ $pipe->name ?? 'Pipe '.$pipe->id }}">
                                                @csrf
                                                @method('delete')
                                                <button type="submit" class="btn btn-danger btn-sm" title="Hapus">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-muted">Belum ada pipa untuk baris ini.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="card-footer d-flex justify-content-end gap-2">
                    <a href="{{ route('master-data.flock.index') }}" class="btn btn-outline-secondary px-4">
                        <i class="fas fa-arrow-left me-2"></i> Kembali
                    </a>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
    $('.form-delete').on('submit', function(e) {
        e.preventDefault();
        Swal.fire({
            title: `Apakah kamu yakin akan menghapus ${$(this).data('nama')}?`,
            showCancelButton: true,
            confirmButtonText: "Ya, Hapus",
            cancelButtonText: "Batal"
        }).then((result) => {
            if (result.value) this.submit();
        });
    });
</script>
@endpush
