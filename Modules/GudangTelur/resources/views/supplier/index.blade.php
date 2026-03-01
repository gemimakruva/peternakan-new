@extends('layouts.dashboard')

@section('title', 'Supplier')

@section('content_header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <div class="d-flex align-items-center gap-1">
                <h1>Supplier</h1>
                <a href="{{ route('gudang-telur.supplier.create') }}" class="btn btn-primary">Tambah Supplier</a>
            </div>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">  
                <li class="breadcrumb-item active">Supplier</li>
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
            <form action="{{ route('gudang-telur.supplier.index', request()->all()) }}" method="get" class="w-100">
                <div class="d-flex justify-content-end">
                    <div class="d-flex gap-2">
                        <input 
                            type="search" 
                            name="search" 
                            class="form-control" 
                            placeholder="Nama Supplier ..."
                            value="{{ request()->query('search') }}"
                        >

                        <button class="btn btn-primary" title="Cari">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <div class="card-body table-responsive p-0">
            <table class="table table-hover table-striped table-bordered text-center mb-0">
                <thead>
                    <tr>
                        <th class="align-middle" style="width: 40px;">#</th>
                        <x-sort-th class="align-middle" style="min-width: 150px;" label="Supplier" name="nama" />
                        <th class="align-middle" style="width: 40px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($datas as $data)
                        <tr>
                            <td>{{ ($datas->currentPage() - 1) * $datas->perPage() + $loop->iteration }}</td>
                            <td class="text-left">{{ $data->nama }}</td>
                            <td>
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('gudang-telur.supplier.edit', $data->id) }}" class="btn btn-sm btn-warning text-white">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center">Data Supplier tidak tersedia</td>
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
