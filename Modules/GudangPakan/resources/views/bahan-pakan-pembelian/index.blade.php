@extends('layouts.dashboard')

@section('title', 'Pembelian Bahan Pakan')

@section('content_header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <div class="d-flex align-items-center gap-1">
                <h1>Pembelian Bahan Pakan</h1>
                <a href="{{ route('gudang-pakan.bahan-pakan-pembelian.create') }}" class="btn btn-primary">Tambah Pembelian Bahan Pakan</a>
            </div>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">  
                <li class="breadcrumb-item active">Pembelian Bahan Pakan</li>
            </ol>
        </div>
    </div>
</div>
@endsection


@section('content')
<div class="mx-1200">
    <x-form-alert />
    
    <div class="card">
        <div class="card-body">
            <form action="{{ route('gudang-pakan.bahan-pakan-pembelian.index', request()->all()) }}" method="get" class="w-100">                    
                <div class="d-flex gap-3 align-items-end">
                    <x-adminlte-select
                        name="supplier_id"
                        fgroup-class="mb-0"
                    >
                        <x-adminlte-options 
                            :options="$listSupplier"
                            :selected="request()->query('supplier_id')"
                            empty-option="Semua Supplier"
                        />
                    </x-adminlte-select>

                    <input 
                        type="search" 
                        name="search" 
                        class="form-control w-100 mx-sm-200" 
                        placeholder="Nama Pic ..."
                        value="{{ request()->query('search') }}"
                    >

                    <div class="d-flex gap-2">
                        <button class="btn btn-primary" title="Cari">
                            <i class="fas fa-search"></i>
                        </button>

                        <a href="{{ route('gudang-pakan.bahan-pakan-pembelian.index') }}" class="btn btn-secondary">
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
                        <x-sort-th class="align-middle" style="min-width: 150px;" label="Pic" name="nama_pic_user" />
                        <x-sort-th class="align-middle" style="min-width: 150px;" label="Supplier" name="nama_supplier" />
                        <x-sort-th class="align-middle" style="min-width: 150px;" label="Tanggal Pesan" name="tanggal_pesan" />
                        <x-sort-th class="align-middle" style="min-width: 150px;" label="Tanggal Datang" name="tanggal_datang" />
                        <th class="align-middle" style="width: 40px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($datas as $data)
                        <tr>
                            <td>{{ ($datas->currentPage() - 1) * $datas->perPage() + $loop->iteration }}</td>
                            <td class="text-left">{{ $data->nama_pic_user }}</td>
                            <td class="text-left">{{ $data->nama_supplier }}</td>
                            <td class="text-left">{{ $data->tanggal_pesan->translatedFormat('l, d F Y') }}</td>
                            <td class="text-left">{{ $data->tanggal_datang->translatedFormat('l, d F Y') }}</td>
                            <td>
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('gudang-pakan.bahan-pakan-pembelian.edit', $data->id) }}" class="btn btn-sm btn-warning text-white">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form
                                        action="{{ route('gudang-pakan.bahan-pakan-pembelian.destroy', $data->id) }}"
                                        method="post"
                                        class="form-delete"
                                        data-tanggal="{{ $data->tanggal_pesan->translatedFormat('l, d F Y') }}"
                                    >
                                        @csrf
                                        @method('delete')
                                        <button class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Data Pembelian Bahan Pakan tidak tersedia</td>
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
