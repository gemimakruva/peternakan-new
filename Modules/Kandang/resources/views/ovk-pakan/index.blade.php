@extends('adminlte::page')

@section('title', 'Pencatatan OVK & Pakan')

@section('content_header')
    <div class="mb-4 text-center d-flex flex-column align-items-center" style="max-width: 1200px;">
        <h2 class="h4 fw-bold text-dark">List Pencatatan OVK & Pakan</h2>
        <span class="text-muted mb-0" style="max-width: 600px;">
            Halaman ini digunakan untuk menampilkan data pencatatan OVK dan kebutuhan pakan
        </span>
    </div>
@endsection

@section('content')
    <x-form-alert />

    {{-- Filter --}}
    <div class="card" style="max-width:1200px">
        <div class="card-header">
            <h3 class="card-title">Filter Data</h3>
        </div>

        <div class="card-body">
            <form action={{ route("ovk-pakan.index") }} method="GET" class="row g-2 align-items-end">
                <div class="col-md-4 col-6">
                    <label class="form-label">Range Tanggal</label>
                    <div class="row">
                        <div class="col-6">
                            <input type="date" name="start_date"
                                value="{{ request('start_date') }}"
                                class="form-control">
                        </div>
                        <div class="col-6">
                            <input type="date" name="end_date"
                                value="{{ request('end_date') }}"
                                class="form-control">
                        </div>
                    </div>
                </div>

                <div class="col-md-3 col-4">
                    <label class="form-label">Kandang</label>
                    <select name="kandang_id" class="form-control">
                        <option value="">Semua Kandang</option>
                        @foreach ($kandang as $item)
                            <option value="{{ $item->id }}"
                                {{ request('kandang_id') == $item->id ? 'selected' : '' }}>
                                {{ $item->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3 col-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search"></i>
                    </button>
                    <a href="{{ route('ovk-pakan.index') }}" class="btn btn-secondary">
                        <i class="fas fa-undo"></i>
                    </a>
                </div>
            </form>
        </div>
    </div>
   

    {{-- Table --}}
    <div class="card mt-3" style="max-width:1200px">
        <div class="card-body table-responsive">
           <table class="table table-bordered table-striped align-middle">
    <thead class="text-center bg-dark text-white">
        <tr>
            <th style="width:5%">No</th>
            <th>Tanggal</th>
            <th>Kandang</th>
            <th>Baris / Flock</th>
            <th>Total Kebutuhan Pakan</th>
            <th>Dosis OVK</th>
            <th>Waktu Pemberian Pakan</th>
            <th>Perhitungan Kebutuhan OVK</th>
            <th style="width:20%">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($data as $item)
        <tr>
            <td class="text-center">
                {{ $loop->iteration + ($data->currentPage() - 1) * $data->perPage() }}
            </td>
            <td>{{ \Carbon\Carbon::parse($item->tanggal)->locale('id')->translatedFormat('d F Y') }}</td>
            <td>{{ $item->flock->kandang->nama ?? '-' }}</td>
            <td>{{ $item->flock->nama ?? '-' }}</td>
            <td>{{ number_format($item->total_kebutuhan_pakan, 2) }}</td>
            <td>{{ number_format($item->Dosis_OVK, 2) }}</td>
            <td>{{ $item->waktu_pemberian_pakan ?? '-' }}</td>
            <td>{{ number_format($item->perhitungan_kebutuhan_ovk, 2) }}</td>
            <td class="text-center">
                <!-- Tombol Edit -->
                <a href="{{ route('ovk-pakan.edit', $item->id) }}" class="btn btn-warning btn-sm">
                    <i class="fas fa-edit"></i>
                </a>

                <!-- Tombol Hapus -->
                <form action="{{ route('ovk-pakan.destroy', $item->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus data?')">
                        <i class="fas fa-trash"></i>
                    </button>
                </form>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="9" class="text-center text-muted">Data belum tersedia</td>
        </tr>
        @endforelse
    </tbody>
</table>

            <!-- Pagination -->
            <div class="d-flex justify-content-end mt-3">
                {{ $data->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>

@endsection
