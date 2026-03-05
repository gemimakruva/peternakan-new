@extends('layouts.dashboard')

@section('title', 'Inventory Bahan Pakan')

@section('content_header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Inventory Bahan Pakan</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">  
                <li class="breadcrumb-item active">Inventory Bahan Pakan</li>
            </ol>
        </div>
    </div>
</div>
@endsection


@section('content')
<div class="mx-900">
    <x-form-alert />
    
    <div class="card">
        <div class="card-body">
            <form action="{{ route('gudang-pakan.bahan-pakan-inventory.index', request()->all()) }}" method="get" class="w-100">                    
                <div class="d-flex gap-3 align-items-end">
                    <x-adminlte-select
                        name="tipe"
                        fgroup-class="w-100 mx-sm-200 mb-0"
                    >
                        <x-adminlte-options
                            :options="$listTipe"
                            :selected="request()->query('tipe')"
                            empty-option="Semua Tipe"
                        />
                    </x-adminlte-select>

                    <input 
                        type="search" 
                        name="search" 
                        class="form-control w-100 mx-sm-200" 
                        placeholder="Nama Bahan Pakan ..."
                        value="{{ request()->query('search') }}"
                    >

                    <div class="d-flex gap-2">
                        <button class="btn btn-primary" title="Cari">
                            <i class="fas fa-search"></i>
                        </button>

                        <a href="{{ route('gudang-pakan.bahan-pakan-inventory.index') }}" class="btn btn-secondary">
                            <i class="fas fa-undo"></i>
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body table-responsive p-0">
            <table class="table table-hover table-striped table-bordered text-center mb-0">
                <thead>
                    <tr>
                        <th class="align-middle" style="width: 40px;">#</th>
                        <th class="align-middle" style="width: 150px;">Tipe</th>
                        <x-sort-th class="align-middle" style="min-width: 150px;" label="Nama Bahan Pakan" name="nama_bahan_pakan" />
                        <x-sort-th class="align-middle" style="min-width: 100px;" label="Jumlah" name="jumlah" />
                        <th class="align-middle" style="width: 50px;">Satuan</th>
                        <th class="align-middle" style="width: 40px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($datas as $data)
                        <tr>
                            <td>{{ ($datas->currentPage() - 1) * $datas->perPage() + $loop->iteration }}</td>
                            <td class="text-left">{{ $data->tipe }}</td>
                            <td class="text-left">{{ $data->nama_bahan_pakan }}</td>
                            <td class="text-right">{{ format_angka($data->jumlah) }}</td>
                            <td class="text-left">{{ $data->nama_satuan }}</td>
                            <td>
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('gudang-pakan.bahan-pakan-inventory.show', $data->id) }}" class="btn btn-sm btn-warning text-white">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">Data Inventory Bahan Pakan tidak tersedia</td>
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

@push('js')
    <script>
        $(document).on('submit', '.form-delete', function (e) {
            e.preventDefault();
            const tanggal = $(this).data('tanggal');

            Swal.fire({
                title: `Hapus Pembelian Bahan Pakan "${tanggal}"?`,
                text: "Data yang dihapus tidak dapat dikembalikan.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Ya, Hapus",
                cancelButtonText: "Batal"
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit();
                }
            });
        });
    </script>
@endpush
