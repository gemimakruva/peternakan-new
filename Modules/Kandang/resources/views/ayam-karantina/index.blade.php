@extends('layouts.dashboard')

@section('title', 'Ayam Karantina')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <div class="d-flex align-items-center gap-1">
                    <h1>Ayam Karantina</h1>
                    <a href="{{ route('ayam-karantina.create') }}" class="btn btn-primary">Tambah Ayam Karantina</a>
                </div>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">  
                    <li class="breadcrumb-item active">Ayam Karantina</li>
                </ol>
            </div>
        </div>
    </div>
@endsection


@section('content')
    <div class="mx-1000">

        <x-form-alert />

        <div class="card">
            <div class="card-header">
                <h2 class="card-title">Filter</h2>
            </div>
            <div class="card-body">
                <form
                    action="{{ route('ayam-karantina.index') }}" 
                    method="get" 
                    class="w-100"
                >
                    <div class="d-flex gap-3 align-items-end flex-column flex-sm-row">
                        <x-adminlte-select name="kandang_id" fgroup-class="mb-0 w-100 mx-sm-200">
                            <x-adminlte-options 
                                :options="$listKandang"
                                empty-option="Semua Kandang ..."
                                :selected="request()->query('kandang_id')"
                            />
                        </x-adminlte-select>

                        <input 
                            type="search" 
                            name="search" 
                            class="form-control mx-sm-200" 
                            placeholder="Nama Pencatat"
                            value="{{ request()->query('search') }}"
                        >

                        <div class="d-flex gap-2">
                            <button class="btn btn-primary" title="Cari">
                                <i class="fas fa-search"></i>
                            </button>
    
                            <a href="{{ route('ayam-karantina.index') }}" class="btn btn-secondary">
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
                            <x-sort-th class="align-middle" style="width: 200px;" label="Tanggal" name="tanggal" />
                            <x-sort-th class="align-middle" style="width: 160px;" label="Kandang" name="nama_kandang" />
                            <x-sort-th class="align-middle" label="Nama Pencatat" name="nama_pic_user" />
                            <x-sort-th class="align-middle" label="Populasi" name="total_ayam_karantina" />
                            <x-sort-th class="align-middle" label="Ayam Mati" name="ayam_mati" />
                            <x-sort-th class="align-middle" label="Ayam Afkir" name="ayam_afkir" />
                            <th class="align-middle" style="width: 40px;">Aksi</th>
                        </tr>
                    </thead>
                <tbody>
                    @forelse($listKarantinaPopulasi as $item)
                    <tr>
                        <td class="text-right">{{ ($listKarantinaPopulasi->currentPage() - 1) * $listKarantinaPopulasi->perPage() + $loop->iteration }}</td>
                        <td class="text-left">{{ $item->tanggal->translatedFormat('l, d F Y') }}</td>
                        <td class="text-left">{{ $item->nama_kandang ?? '-' }}</td>
                        <td class="text-left">{{ $item->nama_pic_user ?? '-' }}</td>
                        <td class="text-right">{{ format_angka($item->total_ayam_karantina, 0) }}</td>
                        <td class="text-right">{{ format_angka($item->ayam_mati, 0) }}</td>
                        <td class="text-right">{{ format_angka($item->ayam_afkir, 0) }}</td>
                        <td>
                            <div class="d-flex justify-content-center gap-2">
                                <a href="{{ route('ayam-karantina.edit', $item->id) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                        <tr>
                            <td colspan="18" class="text-center text-muted">Data Ayam Karantina belum tersedia</td>
                        </tr>
                    @endforelse
                </tbody>
                </table>
            </div>

            @if ($listKarantinaPopulasi->hasPages())
                <div class="card-footer d-flex justify-content-end">
                    {{ $listKarantinaPopulasi->links('components.pagination') }}
                </div>
            @endif
        </div>
    </div>
@endsection