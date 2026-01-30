@extends('layouts.dashboard')

@section('title', 'Vaksin Minum')

@section('content_header')
<div class="mb-4 text-center d-flex flex-column align-items-center">
    <h2 class="h4 fw-bold text-dark">Vaksin Minum</h2>
    <span class="text-muted mb-0" style="max-width: 600px;">
        Halaman ini digunakan untuk Melakukan Pencatatan Vaksin Minum
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
        <h3 class="card-title m-0">Data Sampling Bobot Ayam</h3>
    </div>
    <div class="card-body table-responsive">
        <table class="table table-bordered table-striped align-middle">
            <thead class="text-center" style="background-color: #495057; border-color: #495057; color: white;">
                <tr>
                    <th style="width:1%">No</th>
                    <th style="width:150px">Tanggal Transaksi</th>
                    <th style="width:150px">Kandang</th>
                    <th style="width:150px">Flock</th>
                    <th style="width:120px">Perhitungan Jumlah ml Vaksin per Flock</th>
                    <th style="width:150px">Jumlah Air di Tong (liter) per Flock</th>
                    <th style="width:80px">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($listVaksinMinum as $item)
                    <tr>
                        <td class="text-center align-middle">{{ $loop->iteration + ($listVaksinMinum->currentPage() - 1) * $listVaksinMinum->perPage() }}</td>
                        <td class="align-middle text-center">{{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d F Y') }}</td>
                        <td class="align-middle">{{ $item->flock->kandang->nama }}</td>
                        <td class="align-middle text-center">{{ $item->flock->nama }}</td>
                        <td class="align-middle text-center">{{ number_format($item->jumlah_ml_vaksin_per_flock, 2) }}</td>
                        <td class="align-middle text-center">{{ number_format($item->jumlah_air_di_tong_per_flock, 2) }}</td>
                        <td class="text-center align-middle">
                            <a href="{{ route('vaksin-minum.edit', $item->id) }}" 
                                class="btn btn-warning btn-sm mr-2 text-white" 
                                title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center">No data available</td></tr>
                @endforelse

            </tbody>
        </table>

        <div class="d-flex justify-content-end align-items-center mt-3">
            <div class="text-muted small mr-4">
                Showing {{ $listVaksinMinum->firstItem() ?? 0 }} to {{ $listVaksinMinum->lastItem() ?? 0 }} 
                of {{ $listVaksinMinum->total() }} entries
            </div>
            <div>
                {{ $listVaksinMinum->appends(request()->query())->links('pagination::bootstrap-4') }}
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
                html: `Data sampling bobot ayam pada <strong>${tanggal}</strong> akan dihapus permanen!`,
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