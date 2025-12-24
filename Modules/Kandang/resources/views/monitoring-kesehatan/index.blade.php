@extends('adminlte::page')

@section('title', 'Monitoring Kesehatan')

@section('content_header')
    <div class="mb-4 text-center d-flex flex-column align-items-center" style="max-width: 1200px;">
        <h2 class="h4 fw-bold text-dark">List Monitoring Kesehatan</h2>
        <span class="text-muted mb-0" style="max-width: 600px;">
            Halaman ini digunakan untuk Menampilkan daftar Monitoring Kesehatan
        </span>
    </div>
@endsection

@section('content')
    <x-form-alert />
    <div class="card" style="max-width:1200px">
        <div class="card-header">
            <h3 class="card-title">Filter Data Pencatatan</h3>
        </div>

        <div class="card-body">
            <form action="" method="GET" class="row g-2 align-items-end">
                <div class="col-md-4 col-5">
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

                <div class="col-md-2 col-5">
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

                <div class="col-md-2 col-5">
                    <label class="form-label">Tim Pelaksana</label>
                    <input type="text" name="tim_pelaksana" value="{{ request('tim_pelaksana') }}" class="form-control" placeholder="Masukkan Tim Pelaksana...">
                </div>

                <div class="col-md-2 col-2">
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

    <div class="card mt-3" style="max-width:1200px">
        <div class="card-body table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead class="text-center" style="background-color: #495057; border-color: #495057; color: white;">
                    <tr>
                        <th>No</th>
                        <th>Tanggal Transaksi</th>
                        <th>Kandang</th>
                        <th>Total Populasi Ayam</th>
                        <th>Jenis Penyakit Ditemukan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($data as $item)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td class="text-center">{{ \Carbon\Carbon::parse($item->tanggal)
                ->translatedFormat('l, d F Y') }}</td>
                            <td>{{ $item->kandang->nama ?? '-' }}</td>
                            <td>{{ $item->total_populasi_ayam }}</td>
                            <td>{{ $item->detail_penyakit_ditemukan }}</td>
                            <td class="text-center">
                                <a href="{{ route('monitoring-kesehatan.edit', $item->id) }}" class="btn btn-info btn-sm">
                                    <i class="fa fa-pen"></i>
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

            <div class="d-flex justify-content-end mt-3">
                {{ $data->links() }}
            </div>
        </div>
    </div>
    </div>
@endsection
@push('js')
@endpush