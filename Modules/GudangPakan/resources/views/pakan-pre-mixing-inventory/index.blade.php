@extends('layouts.dashboard')

@section('title', 'Inventory Pre-Mixing')

@section('content_header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Inventory Pre-Mixing</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">  
                <li class="breadcrumb-item"><a href="{{ route('gudang-pakan.pakan-pre-mixing.index') }}">Pre-Mixing</a></li>
                <li class="breadcrumb-item active">Inventory</li>
            </ol>
        </div>
    </div>
</div>
@endsection


@section('content')
<div class="mx-1000">
    <x-form-alert />
    
    <div class="card">
        <div class="card-body">
            <form action="{{ route('gudang-pakan.pakan-pre-mixing-inventory.index', request()->all()) }}" method="get" class="w-100">                    
                <div class="d-flex gap-3 align-items-end">
                    <input 
                        type="search" 
                        name="search" 
                        class="form-control w-100 mx-sm-200" 
                        placeholder="Nama Formulasi ..."
                        value="{{ request()->query('search') }}"
                    >

                    <div class="d-flex gap-2">
                        <button class="btn btn-primary" title="Cari">
                            <i class="fas fa-search"></i>
                        </button>

                        <a href="{{ route('gudang-pakan.pakan-pre-mixing-inventory.index') }}" class="btn btn-secondary">
                            <i class="fas fa-undo"></i>
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body table-responsive p-0">
            <table class="table table-hover table-striped table-bordered text-center mb-0">
                <thead>
                    <tr>
                        <th class="align-middle" style="width: 40px;">#</th>
                        <x-sort-th class="align-middle" style="min-width: 150px;" label="Formulasi" name="nama_formulasi" />
                        <x-sort-th class="align-middle" style="min-width: 150px;" label="Jumlah" name="jumlah" />
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($datas as $data)
                        <tr>
                            <td>{{ ($datas->currentPage() - 1) * $datas->perPage() + $loop->iteration }}</td>
                            <td class="text-left">{{ $data->nama_formulasi }}</td>
                            <td class="text-right">{{ format_angka($data->jumlah) }}</td>
                            <td class="text-center">
                                <a href="{{ route('gudang-pakan.pakan-pre-mixing-inventory.show', $data->id) }}" class="btn btn btn-info btn-sm">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center">Data Inventory Pre Mixing tidak tersedia</td>
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