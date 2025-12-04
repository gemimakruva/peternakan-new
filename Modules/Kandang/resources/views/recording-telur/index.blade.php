@extends('layouts.dashboard')

@section('title', 'Recording Telur')

@section('content_header')
<div class="mb-4 text-center d-flex flex-column align-items-center">
    <h2 class="h4 fw-bold text-dark">Recording Telur</h2>
    <span class="text-muted mb-0" style="max-width: 600px;">
        Halaman ini digunakan untuk Melakukan Pencatatan Telur Harian
    </span>
</div>
@endsection
@include('components.snackbar')
@section('content')
<div class="card" style="max-width:1200px">
    <div class="card-header">
        <h3 class="card-title">Filter Data</h3>
    </div>

    <div class="card-body">
        <form action="" method="GET" class="row g-2 align-items-end">
            <div class="col-md-4 col-7">
                <label class="form-label">Tanggal Pencatatan</label>
                <div class="d-flex">
                    <input type="date" name="tanggal_mulai" value="{{ request('tanggal_mulai') }}" class="form-control">
                    <span class="mx-2 align-self-center">s/d</span>
                    <input type="date" name="tanggal_selesai" value="{{ request('tanggal_selesai') }}" class="form-control">
                </div>
            </div>

            <div class="col-md-3 col-5">
                <x-adminlte-select name="kandang_id" label="Pilih Kandang" class="select-nama-berkas"
                igroup-size="md" fgroup-class="mb-0">
                    <x-slot name="prependSlot">
                        <div class="input-group-text bg-white">
                            <i class="fas fa-feather-alt text-muted"></i>
                        </div>
                    </x-slot>
                    <option selected disabled>Pilih Kandang...</option>
                    @foreach ($listKandang as $kandang)
                        <option value="{{ $kandang->id }}"
                            {{ request('kandang_id') == $kandang->id ? 'selected' : '' }}>
                            {{ $kandang->nama }}
                        </option>
                    @endforeach
                </x-adminlte-select>
            </div>

            <div class="col-md-3 col-5">
                <label class="form-label">Dicatat Oleh</label>
                <input type="text" name="recorded_by" value="{{ request('recorded_by') }}" class="form-control" placeholder="Nama Pencatat">
            </div>

            <div class="col-md-2 col-2">
                <button type="submit" class="btn btn-primary btn-lg">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </form>
    </div>
</div>

<div class="card mt-3" style="max-width:1200px">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title m-0">Data Recording Telur</h3>
    </div>
    <div class="card-body table-responsive">
        <table class="table table-bordered table-striped align-middle">
            <thead  class="text-center"   style="background-color: #495057; border-color: #495057; color: white;">
                <tr>
                    <th style="width:40px">No</th>
                    <th style="width:400px">Tanggal Transaksi</th>
                    <th style="width:160px">Petugas Pencatat</th>
                    <th style="width:200px">Kandang</th>
                    <th style="width:200px">Baris</th>
                    <th style="width:150px">Umur Ayam</th>
                    <th style="width:150px">Telur Bagus</th>
                    <th style="width:150px">Berat Telur Bagus (kg)</th>
                    <th style="width:120px">Telur Putih</th>
                    <th style="width:120px">Berat Telur Putih (kg)</th>
                    <th style="width:120px">Telur Reject</th>
                    <th style="width:120px">Berat Telur Reject (kg)</th>
                    <th style="width:120px">Total Butir Telur</th>
                    <th style="width:120px">Total Berat Telur (kg)</th>
                    <th style="width:100px">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($listProduksiTelur as $item)
                    <tr>
                        <td class="text-center">{{ $listProduksiTelur->firstItem() + $loop->index }}</td>
                        <td class="text-center">{{ \Carbon\Carbon::parse($item->tanggal)
                        ->translatedFormat('l, d F Y') }}</td>
                        <td>{{ $item->picUser->name ?? '-' }}</td>
                        <td>{{ $item->flock->kandang->nama ?? '-' }}</td>
                        <td>{{ $item->flock->nama ?? '-' }}</td>
                        <td>{{ $item->usia_ayam }} minggu</td>
                        <td class="text-center">{{ number_format($item->jumlah_telur_bagus) }}</td>
                        <td class="text-center">{{ number_format($item->berat_telur_bagus) }}</td>
                        <td class="text-center">{{ number_format($item->jumlah_telur_putih) }}</td>
                        <td class="text-center">{{ number_format($item->berat_telur_putih) }}</td>
                        <td class="text-center">{{ number_format($item->jumlah_telur_reject) }}</td>
                        <td class="text-center">{{ number_format($item->berat_telur_reject) }}</td>
                        <td class="text-center">{{ number_format($item->total_jumlah_telur) }}</td>
                        <td class="text-center">{{ number_format($item->total_berat_telur) }}</td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center">
                                <a href="{{ route('recording-telur.edit', $item->id) }}" 
                                   class="btn btn-warning btn-sm mr-2 text-white" 
                                   title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('recording-telur.destroy', $item) }}"
                                    method="POST"
                                    class="form-delete m-0"
                                    data-tanggal="tanggal {{ \Carbon\Carbon::parse($item->tanggal)
                                    ->translatedFormat('l, d F Y') }}">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" 
                                            class="btn btn-danger btn-sm" 
                                            title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="15" class="text-center text-muted">
                            Belum ada data pencatatan telur.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="d-flex justify-content-end align-items-center mt-3">
            <div class="text-muted small mr-4">
                Showing {{ $listProduksiTelur->firstItem() ?? 0 }} to {{ $listProduksiTelur->lastItem() ?? 0 }} 
                of {{ $listProduksiTelur->total() }} entries
            </div>
            <div>
                {{ $listProduksiTelur->appends(request()->query())->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
</div>

@push('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        $('.form-delete').on('submit', function(e) {
            e.preventDefault();
            const form = this;
            const tanggal = $(this).data('tanggal');
            
            Swal.fire({
                title: 'Apakah Anda yakin?',
                html: `Data pencatatan telur pada <strong>${tanggal}</strong> akan dihapus permanen!`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                reverseButtons: false
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>
@endpush
@endsection