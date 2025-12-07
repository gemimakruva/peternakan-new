@extends('layouts.dashboard')

@section('title', 'Sampling Bobot Ayam')

@section('content_header')
<div class="mb-4 text-center d-flex flex-column align-items-center">
    <h2 class="h4 fw-bold text-dark">Sampling Bobot Ayam</h2>
    <span class="text-muted mb-0" style="max-width: 600px;">
        Halaman ini digunakan untuk Melakukan Pencatatan Sampling Bobot Ayam
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
                    <th style="width:40px">No</th>
                    <th style="width:150px">Tanggal Transaksi</th>
                    <th style="width:160px">Petugas Pencatat</th>
                    <th style="width:150px">Kandang</th>
                    <th style="width:100px">Jumlah Ayam(ekor)</th>
                    <th style="width:100px">Jumlah Sampling(ekor)</th>
                    <th style="width:100px">Umur Ayam</th>
                    <th style="width:120px">Standar Bobot(kg)</th>
                    <th style="width:150px">Range Standar Bobot(kg)</th>
                    <th style="width:150px">Rata-rata sampling(kg)</th>
                    <th style="width:120px">Batas Atas(kg)</th>
                    <th style="width:120px">Batas Bawah(kg)</th>
                    <th style="width:120px">Ayam Masuk Range</th>
                    <th style="width:100px">Uniformity(%)</th>
                    <th style="width:100px">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($listSamplingBobotAyam as $item)
                    <tr>
                        <td class="text-center">{{ $listSamplingBobotAyam->firstItem() + $loop->index }}</td>
                        <td class="text-center">{{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('l, d F Y') }}</td>
                        <td>{{ $item->petugas_pencatat ?? '-' }}</td>
                        <td>{{ $item->kandang_nama ?? '-' }}</td>
                        <td class="text-center">{{ number_format($item->jumlah_ayam_saat_ini) }}</td>
                        <td class="text-center">{{ number_format($item->jumlah_ayam_yang_disampling) }}</td>
                        <td class="text-center">{{ $item->umur }} Minggu</td>
                        <td class="text-center">{{ number_format($item->standar_bobot_kg, 2) }}</td>
                        <td class="text-center">{{ $item->range_standar_bobot }}</td>
                        <td class="text-center">{{ number_format($item->rata_rata_sampling_kg, 2) }}</td>
                        <td class="text-center">{{ number_format($item->batas_atas_kg, 2) }}</td>
                        <td class="text-center">{{ number_format($item->batas_bawah_kg, 2) }}</td>
                        <td class="text-center">{{ $item->ayam_masuk_range }}</td>
                        <td class="text-center">
                            <span class="badge {{ $item->uniformity_persen >= 80 ? 'badge-success' : 'badge-warning' }}">
                                {{ number_format($item->uniformity_persen, 2) }}%
                            </span>
                        </td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center">
                                <a href="{{ route('sampling-ayam.edit', $item->id) }}" 
                                   class="btn btn-warning btn-sm mr-2 text-white" 
                                   title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('sampling-ayam.destroy', $item->id) }}"
                                    method="POST"
                                    class="form-delete m-0"
                                    data-tanggal="tanggal {{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('l, d F Y') }}">
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
                            Belum ada data sampling bobot ayam.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="d-flex justify-content-end align-items-center mt-3">
            <div class="text-muted small mr-4">
                Showing {{ $listSamplingBobotAyam->firstItem() ?? 0 }} to {{ $listSamplingBobotAyam->lastItem() ?? 0 }} 
                of {{ $listSamplingBobotAyam->total() }} entries
            </div>
            <div>
                {{ $listSamplingBobotAyam->appends(request()->query())->links('pagination::bootstrap-4') }}
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