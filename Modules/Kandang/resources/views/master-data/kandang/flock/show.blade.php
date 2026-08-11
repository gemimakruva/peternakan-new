@php
    $title = "Detail Flock - {$flock->nama}";
    $pipes = $flock->pipes()->orderByDesc('created_at')->get(['id', 'nama', 'kapasitas']);
@endphp

@extends('layouts.dashboard')

@section('title', $title)

@section('content_header')
    <x-page-header :title="$title" :breadcrumbs="[
        'Master Data' => '#',
        'Kandang' => route('master-data.kandang.index'),
        $kandang->nama => route('master-data.kandang.show', $kandang),
        $flock->nama => null,
    ]" />
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
                    <table class="w-100 desktop-table">
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
                    <div class="mobile-card-list">
                        <div class="data-row">
                            <span class="data-label">Nama Strain</span>
                            <span class="data-value">{{ $kandang->strain->nama }}</span>
                        </div>
                        <div class="data-row">
                            <span class="data-label">Nama Kandang</span>
                            <span class="data-value">{{ $kandang->nama }}</span>
                        </div>
                        <div class="data-row">
                            <span class="data-label">Nama Peternakan</span>
                            <span class="data-value">{{ $kandang->peternakan->nama }}</span>
                        </div>
                        <div class="data-row">
                            <span class="data-label">Nama Flock</span>
                            <span class="data-value">{{ $flock->nama }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Daftar Pipa pada Flock</h2>
                </div>

                <div class="card-body table-responsive p-0 desktop-table">
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

                <div class="card-body mobile-card-list">
                    @forelse($pipes as $pipe)
                        <x-mobile-card :title="$pipe->nama">
                            <div class="data-row">
                                <span class="data-label">Kapasitas</span>
                                <span class="data-value">{{ number_format($pipe->kapasitas) }}</span>
                            </div>
                            <div class="d-flex gap-2 mt-2">
                                <a href="{{ route('master-data.kandang.flock.pipe.edit', [$kandang, $flock, $pipe]) }}" class="btn btn-warning text-white btn-sm"><i class="fas fa-edit"></i> Edit</a>
                                <form action="{{ route('master-data.kandang.flock.pipe.destroy', [$kandang, $flock, $pipe]) }}" method="POST" class="form-delete d-inline" data-nama="{{ $pipe->nama }}">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i> Hapus</button>
                                </form>
                            </div>
                        </x-mobile-card>
                    @empty
                        <x-empty-state icon="box" title="Belum Ada Pipa" description="Belum ada pipa untuk flock ini." />
                    @endforelse
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
