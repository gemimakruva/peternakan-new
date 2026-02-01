@extends('layouts.dashboard')

@section('title', 'Pemberian Pakan Sisa Pakan')

@section('content_header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Pemberian Pakan Sisa Pakan</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item active">Pemberian Pakan</li>
                <li class="breadcrumb-item active">Pemberian Pakan Sisa Pakan</li>
            </ol>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="mx-1200">
    <x-form-alert />

    <div class="card">
        <div class="card-body table-responsive p-0">
            <table class="table table-hover table-striped table-bordered text-center">
                <thead class="bg-light">
                    <th style="width: 40px;">#</th>
                    <x-sort-th class="align-middle" label="Tanggal" name="tanggal_pemberian_pakan" />
                    <x-sort-th class="align-middle" label="Nama Kandang" name="nama_kandang" />
                    <x-sort-th class="align-middle" label="Jenis Pakan" name="nama_jenis_pakan" />
                    <x-sort-th class="align-middle" label="Pelaksana" name="nama_pelaksana" />
                    <x-sort-th class="align-middle" label="Pemberian Pakan (Kg)" name="pemberian_pakan_kg" />
                    <x-sort-th class="align-middle" label="Sisa Pakan (Kg)" name="sisa_pakan_kg" />
                    <th style="width: 150px;">Aksi</th>
                </thead>
                <tbody>
                    @forelse($datas as $row)
                        <tr>
                            <td class="text-center">{{ ($datas->currentPage() - 1) * $datas->perPage() + $loop->iteration }}</td>
                            <td class="text-left">{{ @$row->tanggal_pemberian_pakan?->translatedFormat('l, d F Y') }}</td>
                            <td class="text-left">{{ $row->nama_kandang }}</td>
                            <td class="text-left">{{ $row->nama_jenis_pakan }}</td>
                            <td class="text-left">{{ $row->nama_pelaksana }}</td>
                            <td class="text-right">{{ format_angka($row->pemberian_pakan_kg) ?? 0 }}</td>
                            <td class="text-right">{{ format_angka($row->sisa_pakan_kg) }}</td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('pemberian-pakan-sisa-pakan.edit', $row) }}" class="btn btn-sm btn-warning text-white" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center text-muted py-3">
                                Tidak ada data pemberian pakan sisa pakan ditemukan.
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