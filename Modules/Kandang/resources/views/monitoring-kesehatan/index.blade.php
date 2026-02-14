@extends('layouts.dashboard')

@section('title', 'Monitoring Kesehatan')

@section('content_header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <div class="d-flex align-items-center gap-1">
                <h1>Monitoring Kesehatan</h1>
                <a href="{{ route('monitoring-kesehatan.create') }}" class="btn btn-primary">Tambah Monitoring Kesehatan</a>
            </div>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Monitoring Kesehatan</a></li>
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
            <form action="{{ route('monitoring-kesehatan.index') }}" method="GET" class="row g-2 align-items-end">
                <div class="col-md-4 col-sm-5 col-12 mb-2 mb-sm-0">
                    <label class="form-label">Range Tanggal</label>
                    <div class="row">
                        <div class="col-6">
                            <input type="date" name="start_date" value="{{ request('start_date') }}" class="form-control">
                        </div>
                        <div class="col-6">
                            <input type="date" name="end_date" value="{{ request('end_date') }}" class="form-control">
                        </div>
                    </div>
                </div>

                <div class="col-md-2 col-sm-5 col-12 mb-2 mb-sm-0">
                    <label class="form-label">Kandang</label>
                    <select name="kandang_id" class="form-control">
                        <option selected disabled>Pilih Kandang...</option>
                        @foreach ($kandang as $item)
                            <option value="{{ $item->id }}" {{ $item->id == request('kandang_id') ? 'selected' : '' }}>
                                {{ $item->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2 col-sm-5 col-12 mb-2 mb-sm-0">
                    <label class="form-label">Tim Pelaksana</label>
                    <input
                        type="text"
                        name="tim_pelaksana"
                        value="{{ request('tim_pelaksana') }}"
                        class="form-control"
                        placeholder="Tim Pelaksana..."
                    />
                </div>

                <div class="col-md-2 col-sm-2 col-12 d-flex gap-2 justify-content-end justify-content-sm-start">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search"></i>
                    </button>
                    <a href="{{ route('monitoring-kesehatan.index') }}" class="btn btn-secondary">
                        <i class="fas fa-undo"></i>
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="card mt-3">
        <div class="card-body table-responsive p-0">
            <table class="table table-bordered table-striped align-middle">
                <thead class="text-center">
                    <tr>
                        <th>No</th>
                        <th>Tanggal Transaksi</th>
                        <th>Kandang</th>
                        <th>Tim Pelaksana</th>
                        <th>Total Populasi Ayam</th>
                        <th>Jenis Penyakit Ditemukan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($data as $item)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td class="text-center">{{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('l, d F Y') }}</td>
                            <td>{{ $item->kandang->nama ?? '-' }}</td>
                            <td>{{ $item->tim_pelaksana }}</td>
                            <td>{{ $item->total_populasi_ayam }}</td>
                            <td>{{ $item->detail_penyakit_ditemukan }}</td>
                            <td class="text-center">
                                <a href="{{ route('monitoring-kesehatan.edit', $item->id) }}" class="btn btn-warning btn-sm">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <a href="{{ route('monitoring-kesehatan.show', $item->id) }}" class="btn btn-info btn-sm">
                                    <i class="fa fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="11" class="text-center text-muted">
                                Belum ada data Monitoring Kesehatan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($data->hasPages())
            <div class="card-footer d-flex justify-content-end">
                {{ $data->links('components.pagination') }}
            </div>
        @endif
    </div>
</div>
@endsection