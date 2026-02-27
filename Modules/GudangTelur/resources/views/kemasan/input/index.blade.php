@extends('layouts.dashboard')

@section('title', 'List Input Kemasan')

@section('content_header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <div class="d-flex align-items-center gap-1">
                <h1>List Input Kemasan</h1>
                <a href="{{ route('gudang-telur.kemasan-input.create') }}" class="btn btn-primary">Tambah Input Kemasan</a>
            </div>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">  
                <li class="breadcrumb-item"><a href="{{ route('gudang-telur.kemasan-inventory.index') }}">Kemasan</a></li>
                <li class="breadcrumb-item active">Input</li>
            </ol>
        </div>
    </div>
</div>
@endsection


@section('content')
<div class="mx-1000">
    <x-form-alert />

    <div class="card">
        <div class="card-header text-white d-flex justify-content-between align-items-center">
            <form action="{{ route('gudang-telur.kemasan-input.index', request()->all()) }}" method="get" class="w-100">
                <div class="d-flex gap-2 justify-content-start align-items-end">
                    <x-adminlte-select
                        name="pic_user_id"
                        fgroup-class="mb-0 w-100 mx-sm-200"
                    >
                        <x-adminlte-options
                            :options="$listUsers"
                            empty-option="Semua Pic User"
                            :selected="request()->query('pic_user_id')"
                        />
                    </x-adminlte-select>

                    <x-adminlte-select
                        name="supplier_id"
                        fgroup-class="mb-0 w-100 mx-sm-200"
                    >
                        <x-adminlte-options
                            :options="$listSupplier"
                            empty-option="Semua Supplier"
                            :selected="request()->query('supplier_id')"
                        />
                    </x-adminlte-select>

                    <input 
                        type="search" 
                        name="search" 
                        class="form-control mx-sm-200" 
                        placeholder="Pic User, Supplier ..."
                        value="{{ request()->query('search') }}"
                    >

                    <button class="btn btn-primary" title="Cari">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </form>
        </div>

        <div class="card-body table-responsive p-0">
            <table class="table table-hover table-striped table-bordered text-center mb-0">
                <thead>
                    <tr>
                        <th class="align-middle" style="width: 40px;">#</th>
                        <x-sort-th class="align-middle" style="min-width: 150px;" label="Tanggal" name="tanggal" />
                        <x-sort-th class="align-middle" style="min-width: 150px;" label="Pic User" name="nama_pic_user" />
                        <x-sort-th class="align-middle" style="min-width: 150px;" label="Supplier" name="nama_supplier" />
                        <th class="align-middle" style="width: 40px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($datas as $data)
                        <tr>
                            <td>{{ ($datas->currentPage() - 1) * $datas->perPage() + $loop->iteration }}</td>
                            <td class="text-left">{{ $data->tanggal->translatedFormat('l, d F Y') }}</td>
                            <td class="text-left">{{ $data->nama_pic_user }}</td>
                            <td class="text-left">{{ $data->nama_supplier }}</td>
                            <td>
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('gudang-telur.kemasan-input.edit', $data->id) }}" class="btn btn-sm btn-warning text-white">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form 
                                        action="{{ route('gudang-telur.kemasan-input.destroy', $data->id) }}"
                                        method="post"
                                        class="form-delete"
                                        data-tanggal="{{ $data->tanggal->translatedFormat('l, d F Y') }}"
                                    >
                                        @csrf
                                        @method('delete')
                                        <button class="btn btn-danger btn-sm">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">Data Input Kemasan tidak tersedia</td>
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
            title: `Hapus Data Input Tanggal "${tanggal}"?`,
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