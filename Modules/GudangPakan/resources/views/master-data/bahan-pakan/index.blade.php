@extends('layouts.dashboard')

@section('title', 'Bahan Baku')

@section('content_header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <div class="d-flex align-items-center gap-1">
                <h1>Bahan Baku</h1>
                <a href="{{ route('gudang-pakan.master-data.bahan-pakan.create') }}" class="btn btn-primary">Tambah Bahan Baku</a>
            </div>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">  
                <li class="breadcrumb-item active">Bahan Baku</li>
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
            <form action="{{ route('gudang-pakan.master-data.bahan-pakan.index', request()->all()) }}" method="get" class="w-100">
                <div class="d-flex justify-content-start">
                    <div class="d-flex gap-3">
                        <x-adminlte-select
                            name="tipe"
                            fgroup-class="mb-0 w-100 mx-sm-200"
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
                            placeholder="Nama Bahan Baku ..."
                            value="{{ request()->query('search') }}"
                        >

                        <div class="d-flex gap-2">
                            <button class="btn btn-primary" title="Cari">
                                <i class="fas fa-search"></i>
                            </button>
    
                            <a href="{{ route('gudang-pakan.master-data.bahan-pakan.index') }}" class="btn btn-secondary">
                                <i class="fas fa-undo"></i>
                            </a>
                        </div>
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
                        <x-sort-th class="align-middle" style="min-width: 150px;" label="Tipe" name="tipe" />
                        <x-sort-th class="align-middle" style="min-width: 150px;" label="Nama" name="nama" />
                        <x-sort-th class="align-middle" style="min-width: 150px;" label="Harga Satuan" name="harga_satuan" />
                        <th class="align-middle" style="width: 40px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($datas as $data)
                        <tr>
                            <td>{{ ($datas->currentPage() - 1) * $datas->perPage() + $loop->iteration }}</td>
                            <td class="text-left">{{ $data->tipe_enum?->title() }}</td>
                            <td class="text-left">{{ $data->nama }}</td>
                            <td class="text-right">{{ format_angka($data->harga_satuan) }}</td>
                            <td>
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('gudang-pakan.master-data.bahan-pakan.edit', $data->id) }}" class="btn btn-sm btn-warning text-white">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form
                                        action="{{ route('gudang-pakan.master-data.bahan-pakan.destroy', $data->id) }}"
                                        method="post"
                                        class="form-delete"
                                        data-nama="{{ $data->nama }}"
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
                            <td colspan="4" class="text-center">Data Bahan Baku tidak tersedia</td>
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
            const nama = $(this).data('nama');

            Swal.fire({
                title: `Hapus Bahan Baku "${nama}"?`,
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
