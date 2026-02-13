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
            <form
                action="{{ route('sampling-ayam.index') }}"
                method="GET"
                class="d-flex align-items-end gap-3 flex-column flex-sm-row"
            >
                <x-adminlte-input
                    type="date"
                    name="tanggal"
                    label="Tanggal"
                    fgroup-class="mb-0 w-100 mx-sm-200"
                    :value="request()->query('tanggal')"
                />
    
                <x-adminlte-select
                    name="kandang_id"
                    fgroup-class="mb-0 w-100 mx-sm-200"
                >
                    <x-adminlte-options 
                        :options="$listKandang"
                        empty-option="Pilih Kandang ..."
                        :selected="request()->query('kandang_id')"
                    />
                </x-adminlte-select>
    
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search"></i>
                    </button>
        
                    <a href="{{ route('sampling-ayam.index') }}" class="btn btn-secondary">
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
                        <th class="align-middle" style="min-width:40px">#</th>
                        <x-sort-th class="align-middle" style="min-width:200px" label="Tanggal" name="tanggal" />
                        <x-sort-th class="align-middle" style="min-width:160px" label="Petugas Pencatat" name="nama_pencatat" />
                        <x-sort-th class="align-middle" style="min-width:150px" label="Kandang" name="nama_kandang" />
                        <x-sort-th class="align-middle" style="min-width:100px" label="Jumlah Ayam(ekor)" name="jumlah_ayam" />
                        <x-sort-th class="align-middle" style="min-width:100px" label="Jumlah Sampling(ekor)" name="jumlah_sampling" />
                        <x-sort-th class="align-middle" style="min-width:100px" label="Umur Ayam" name="umur_ayam" />
                        <x-sort-th class="align-middle" style="min-width:120px" label="Standar Bobot(kg)" name="standar_bobot" />
                        <th class="align-middle" style="min-width:150px">Range Standar Bobot(kg)</th>
                        <x-sort-th class="align-middle" style="min-width:150px" label="Rata-rata sampling(kg)" name="realisasi_bobot" />
                        <th class="align-middle" style="min-width:150px">Range Sampling(kg)</th>
                        <x-sort-th class="align-middle" style="min-width:120px" label="Ayam Masuk Range" name="jumlah_masuk_range" />
                        <x-sort-th class="align-middle" style="min-width:100px" label="Uniformity(%)" name="uniformity" />
                        <th class="align-middle" style="min-width:100px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($datas as $item)
                        <tr>
                            <td class="text-right">{{ $datas->firstItem() + $loop->index }}</td>
                            <td class="text-left">{{ $item->tanggal->translatedFormat('l, d F Y') }}</td>
                            <td class="text-left">{{ $item->nama_pencatat }}</td>
                            <td class="text-left">{{ $item->nama_kandang }}</td>
                            <td class="text-right">{{ format_angka($item->jumlah_ayam) }}</td>
                            <td class="text-right">{{ format_angka($item->jumlah_sampling) }}</td>
                            <td class="text-right">{{ $item->umur_ayam }} Minggu</td>
                            <td class="text-right">{{ format_angka($item->standar_bobot) }}</td>
                            <td class="text-right">{{ format_angka($item->standar_bobot_min) }} - {{ format_angka($item->standar_bobot_max) }}</td>
                            <td class="text-right">{{ format_angka($item->realisasi_bobot) }}</td>
                            <td class="text-right">{{ format_angka($item->realisasi_bobot_min) }} - {{ format_angka($item->realisasi_bobot_max) }}</td>
                            <td class="text-right">{{ format_angka($item->jumlah_masuk_range) }}</td>
                            <td class="text-right">
                                <span class="badge {{ $item->uniformity >= .8 ? 'badge-success' : 'badge-warning' }}">
                                    {{ format_angka($item->uniformity*100) }}%
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
        @if ($datas->hasPages())
            <div class="card-footer d-flex justify-content-end">
                {{ $datas->links('components.pagination') }}
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