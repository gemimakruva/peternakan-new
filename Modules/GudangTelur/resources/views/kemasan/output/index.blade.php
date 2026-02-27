@extends('layouts.dashboard')

@section('title', 'List Output Kemasan')

@section('content_header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <div class="d-flex align-items-center gap-1">
                <h1>List Output Kemasan</h1>
                <a href="{{ route('gudang-telur.kemasan-output.create') }}" class="btn btn-primary">Tambah Output Kemasan</a>
            </div>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">  
                <li class="breadcrumb-item"><a href="{{ route('gudang-telur.kemasan-inventory.index') }}">Kemasan</a></li>
                <li class="breadcrumb-item active">Output</li>
            </ol>
        </div>
    </div>
</div>
@endsection


@section('content')
<div class="mx-1000">
    <x-form-alert />

    <div class="card">
        <div class="card-header text-white d-flex justify-content-between align-items-center">
            <form action="{{ route('gudang-telur.kemasan-output.index', request()->all()) }}" method="get" class="w-100">
                <div class="d-flex gap-2 justify-content-start align-items-end">
                    <input 
                        type="search" 
                        name="search" 
                        class="form-control mx-sm-200" 
                        placeholder="Pic User ..."
                        value="{{ request()->query('search') }}"
                    >

                    <button class="btn btn-primary" title="Cari">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </form>
        </div>

        <div class="card-body table-responsive p-0">
            <table class="table table-hover table-striped table-bordered text-center mb-0">
                <thead>
                    <tr>
                        <th class="align-middle" style="width: 40px;">#</th>
                        <x-sort-th class="align-middle" style="min-width: 150px;" label="Tanggal" name="tanggal" />
                        <x-sort-th class="align-middle" style="min-width: 150px;" label="Pic User" name="nama_pic_user" />
                        <th class="align-middle" style="width: 40px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($datas as $data)
                        <tr>
                            <td>{{ ($datas->currentPage() - 1) * $datas->perPage() + $loop->iteration }}</td>
                            <td class="text-left">{{ $data->tanggal->translatedFormat('l, d F Y') }}</td>
                            <td class="text-left">{{ $data->nama_pic_user }}</td>
                            <td>
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('gudang-telur.kemasan-output.edit', $data->id) }}" class="btn btn-sm btn-warning text-white">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">Data Output Kemasan tidak tersedia</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($datas->hasPages())
            <div class="card-footer d-flex justify-content-end">
                {{ $datas->links('components.pagination') }}
            </div>
        @endif
    </div>
</div>
@endsection
