@php
    $title = "Detail Baris - {$flock->nama}";
    $pipes = $flock->pipes;
@endphp

@extends('layouts.dashboard')

@section('title', $title)

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <div class="d-flex align-items-center gap-1">
                    <h1>{{ $title }}</h1>
                </div>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Master Data</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('master-data.flock.index') }}">Baris</a></li>
                    <li class="breadcrumb-item active">{{ $flock->nama }}</li>
                    <li class="breadcrumb-item active">Detail</li>
                </ol>
            </div>
        </div>
    </div>
@endsection

@section('content')
<div class="mx-900">
    <x-form-alert />

    <div class="row">
        <div class="col-md-9 col-12">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Daftar Pipa</h2>
                </div>

                <div class="card-body table-responsive p-0">
                    <table class="table table-hover table-striped table-bordered text-center mb-0">
                        <thead>
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
                                    <td>{{ $pipe->nama }}</td>
                                    <td>{{ number_format($pipe->kapasitas) }}</td>
                                    <td>
                                        <div class="d-flex justify-content-center gap-2" role="group">
                                            <a 
                                                href="{{ route('master-data.flock.pipe.edit', compact('flock', 'pipe')) }}"
                                                class="btn btn-warning text-white btn-sm" 
                                                title="Edit"
                                            >
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form 
                                                action="{{ route('master-data.flock.pipe.destroy', compact('flock', 'pipe')) }}" 
                                                method="POST" class="form-delete d-inline"
                                                data-nama="{{ $pipe->nama }}"
                                            >
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
            </div>
        </div>
        <div class="col-md-3 col-12">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Aksi</h2>
                </div>
                <div class="card-body">
                    <a href="{{ route('master-data.flock.index') }}" class="btn btn-outline-secondary btn-block">Kembali</a>
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
