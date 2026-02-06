@extends('layouts.dashboard')

@section('title', 'Sampling Bobot Ayam')

@section('content_header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
        <div class="d-flex align-items-center gap-1">
            <h1>Sampling Bobot Ayam</h1>
            <a href="{{ route('sampling-ayam.create') }}" class="btn btn-primary">Tambah Sampling Bobot Ayam</a>
        </div>
        </div>
        <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item active">Sampling Bobot Ayam</li>
        </ol>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="mx-1400">
    <x-form-alert />

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Filter</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('sampling-ayam.index') }}" method="GET" class="d-flex align-items-end gap-2">
                <div>
                    <label class="form-label">Tanggal Pencatatan</label>
                    <div class="d-flex">
                        <input type="date" name="tanggal_mulai" value="{{ request('tanggal_mulai') }}" class="form-control">
                        <span class="mx-2 align-self-center">s/d</span>
                        <input type="date" name="tanggal_selesai" value="{{ request('tanggal_selesai') }}" class="form-control">
                    </div>
                </div>
    
                <x-adminlte-select name="kandang_id" fgroup-class="mb-0 mx-200">
                    <x-adminlte-options 
                        :options="$listKandang"
                        empty-option="Pilih Kandang ..."
                        :selected="request()->query('kandang_id')"
                    />
                </x-adminlte-select>
    
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-search"></i>
                </button>
    
                <a href="{{ route('sampling-ayam.index') }}" class="btn btn-secondary">
                    <i class="fas fa-undo"></i>
                </a>
            </form>
        </div>
    </div>

    <div class="card mt-3">
        <div class="card-body table-responsive p-0">
            <table class="table table-bordered table-striped align-middle">
                <thead class="text-center">
                    <tr>
                        <th class="align-middle" style="min-width:40px">#</th>
                        <th class="align-middle" style="min-width:200px">Tanggal Transaksi</th>
                        <th class="align-middle" style="min-width:160px">Petugas Pencatat</th>
                        <th class="align-middle" style="min-width:150px">Kandang</th>
                        <th class="align-middle" style="min-width:100px">Jumlah Ayam(ekor)</th>
                        <th class="align-middle" style="min-width:100px">Jumlah Sampling(ekor)</th>
                        <th class="align-middle" style="min-width:100px">Umur Ayam</th>
                        <th class="align-middle" style="min-width:120px">Standar Bobot(kg)</th>
                        <th class="align-middle" style="min-width:150px">Range Standar Bobot(kg)</th>
                        <th class="align-middle" style="min-width:150px">Rata-rata sampling(kg)</th>
                        <th class="align-middle" style="min-width:120px">Batas Atas(kg)</th>
                        <th class="align-middle" style="min-width:120px">Batas Bawah(kg)</th>
                        <th class="align-middle" style="min-width:120px">Ayam Masuk Range</th>
                        <th class="align-middle" style="min-width:100px">Uniformity(%)</th>
                        <th class="align-middle" style="min-width:100px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($listSamplingBobotAyam as $item)
                        <tr>
                            <td class="text-right">{{ $listSamplingBobotAyam->firstItem() + $loop->index }}</td>
                            <td class="text-left">{{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('l, d F Y') }}</td>
                            <td class="text-left">{{ $item->petugas_pencatat ?? '-' }}</td>
                            <td class="text-left">{{ $item->kandang_nama ?? '-' }}</td>
                            <td class="text-right">{{ number_format($item->jumlah_ayam_saat_ini) }}</td>
                            <td class="text-right">{{ number_format($item->jumlah_ayam_yang_disampling) }}</td>
                            <td class="text-right">{{ $item->umur }} Minggu</td>
                            <td class="text-right">{{ number_format($item->standar_bobot_kg, 2) }}</td>
                            <td class="text-right">{{ $item->range_standar_bobot }}</td>
                            <td class="text-right">{{ number_format($item->rata_rata_sampling_kg, 2) }}</td>
                            <td class="text-right">{{ number_format($item->batas_atas_kg, 2) }}</td>
                            <td class="text-right">{{ number_format($item->batas_bawah_kg, 2) }}</td>
                            <td class="text-right">{{ $item->ayam_masuk_range }}</td>
                            <td class="text-right">
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
        </div>
        @if ($listSamplingBobotAyam->hasPages())
            <div class="card-footer d-flex justify-content-end">
                {{ $listSamplingBobotAyam->links('components.pagination') }}
            </div>
        @endif
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