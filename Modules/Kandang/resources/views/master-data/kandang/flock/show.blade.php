@php
    $title = "Detail Flock - {$flock->nama}";
    $pipes = $flock->pipes()->orderByDesc('created_at')->get(['id', 'nama', 'kapasitas']);
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
                    <li class="breadcrumb-item"><a href="{{ route('master-data.kandang.index') }}">Kandang</a></li>
                    <li class="breadcrumb-item active">{{ $kandang->nama }}</li>
                    <li class="breadcrumb-item"><a href="{{ route('master-data.kandang.show', $kandang) }}">Detail</a></li>
                    <li class="breadcrumb-item active">{{ $flock->nama }}</li>
                    <li class="breadcrumb-item active">Detail</li>
                </ol>
            </div>
        </div>
    </div>
@endsection

@section('content')
<div class="mx-1200">
    <x-form-alert />

    <div class="row">
        <div class="col-md-9 col-12">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Informasi Kandang</h2>
                </div>
                <div class="card-body">
                    <table class="w-100">
                        <tbody>
                            <tr>
                                <td class="w-25">Nama Strain</td>
                                <td class="w-25">: {{ $kandang->strain->nama }}</td>
                                <td class="w-25">Nama Kandang</td>
                                <td class="w-25">: {{ $kandang->nama }}</td>
                            </tr>
                            <tr>
                                <td class="w-25">Nama Peternakan</td>
                                <td class="w-25">: {{ $kandang->peternakan->nama }}</td>
                                <td class="w-25">Nama Flock</td>
                                <td class="w-25">: {{ $flock->nama }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Daftar Pipa pada Flock</h2>
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
                                    <td class="text-left">{{ $pipe->nama }}</td>
                                    <td class="text-right">{{ number_format($pipe->kapasitas) }}</td>
                                    <td>
                                        <div class="d-flex justify-content-center gap-2" role="group">
                                            <a 
                                                href="{{ route('master-data.kandang.flock.pipe.edit', [$kandang, $flock, $pipe]) }}"
                                                class="btn btn-warning text-white btn-sm" 
                                                title="Edit"
                                            >
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form 
                                                action="{{ route('master-data.kandang.flock.pipe.destroy', [$kandang, $flock, $pipe]) }}" 
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
                                    <td colspan="5" class="text-muted">Belum ada pipa untuk flock ini.</td>
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
                    <div class="d-flex gap-3 mb-3">
                        <a href="{{ request()->query('back_uri', route('master-data.kandang.show', $kandang)) }}" class="btn btn-outline-secondary flex-1">Kembali</a>
                        <a href="{{ route('master-data.kandang.flock.edit', [$kandang, $flock]) }}" class="btn btn-warning flex-1">Edit</a>
                    </div>
                    <a href="{{ route('master-data.kandang.flock.pipe.create', [$kandang, $flock]) }}" class="btn btn-primary btn-block">Tambah Pipa</a>
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
