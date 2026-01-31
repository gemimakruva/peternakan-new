@extends('layouts.dashboard')

@section('title', 'Perhitungan Pemberian Pakan')

@section('content_header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <div class="d-flex align-items-center gap-1">
                <h1>Perhitungan Pemberian Pakan</h1>
                <a href="{{ route('perhitungan-pakan.create') }}" class="btn btn-primary">Tambah Perhitungan</a>
            </div>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item active">Pemberian Pakan</li>
                <li class="breadcrumb-item active">Perhitungan Pemberian Pakan</li>
            </ol>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="mx-1200">
    <x-form-alert />

    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Filter</h2>
        </div>
        <div class="card-body">
            <form action="{{ route('perhitungan-pakan.index') }}" method="get" class="d-flex gap-2">
                <select 
                    name="kandang_id" 
                    class="form-control mx-200"
                >
                    <option value="" @selected(!request()->query('kandang_id'))>Semua Kandang</option>
                    @foreach ($listKandang as $id => $nama)
                        <option value="{{ $id }}" @selected(request()->query('kandang_id') == $id)>{{ $nama }}</option>
                    @endforeach
                </select>

                <select 
                    name="jenis_pakan_id"
                    class="form-control mx-200"
                >
                    <option value="" @selected(!request()->query('jenis_pakan_id'))>Semua Jenis Pakan</option>
                    @foreach ($listJenisPakan as $id => $nama)
                        <option value="{{ $id }}" @selected(request()->query('jenis_pakan_id') == $id)>{{ $nama }}</option>
                    @endforeach
                </select>

                <input type="search" class="form-control mx-200" name="search" value="{{ request()->query('search') }}" placeholder="Kandang, Pencatat, Pelaksana ...">

                <button class="btn btn-primary" type="submit">
                    <i class="fas fa-search"></i>
                </button>

                <a href="{{ route('perhitungan-pakan.index') }}" class="btn btn-secondary">
                    <i class="fas fa-undo"></i>
                </a>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body table-responsive p-0">
            <table class="table table-hover table-striped table-bordered text-center">
                <thead class="bg-light">
                    <th style="width: 40px;">#</th>
                    <x-sort-th class="align-middle" label="Tanggal" name="tanggal_pemberian_pakan" />
                    <x-sort-th class="align-middle" label="Nama Kandang" name="nama_kandang" />
                    <x-sort-th class="align-middle" label="Pencatat" name="nama_pencatat" />
                    <x-sort-th class="align-middle" label="Pelaksana" name="nama_pelaksana" />
                    <x-sort-th class="align-middle" label="Jumlah Ayam" name="jumlah_ayam" />
                    <x-sort-th class="align-middle" label="Berat Pakan (Kg)" name="berat_pakan_gram" />
                    <x-sort-th class="align-middle" label="Jenis Pakan" name="nama_jenis_pakan" />
                    <th style="width: 150px;">Aksi</th>
                </thead>
                <tbody>
                    @forelse($datas as $row)
                        <tr>
                            <td class="text-center">{{ ($datas->currentPage() - 1) * $datas->perPage() + $loop->iteration }}</td>
                            <td class="text-left">{{ @$row->tanggal_pemberian_pakan?->translatedFormat('l, d F Y') }}</td>
                            <td class="text-left">{{ $row->nama_kandang }}</td>
                            <td class="text-left">{{ $row->nama_pencatat }}</td>
                            <td class="text-left">{{ $row->nama_pelaksana }}</td>
                            <td class="text-right">{{ format_angka($row->jumlah_ayam, 0) ?? 0 }}</td>
                            <td class="text-right">{{ format_angka($row->berat_pakan_gram/1000) }}</td>
                            <td class="text-left">{{ $row->nama_jenis_pakan }}</td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('perhitungan-pakan.edit', $row) }}" class="btn btn-sm btn-warning text-white" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center text-muted py-3">
                                Tidak ada data perhitungan pakan ditemukan.
                            </td>
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