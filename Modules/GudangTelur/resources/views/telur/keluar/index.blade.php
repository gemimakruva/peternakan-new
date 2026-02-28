@extends('layouts.dashboard')

@section('title', 'List Telur Keluar')

@section('content_header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <div class="d-flex align-items-center gap-1">
                <h1>List Telur Keluar</h1>
                <a href="{{ route('gudang-telur.telur-keluar.create') }}" class="btn btn-primary">Tambah Telur Keluar</a>
            </div>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">  
                <li class="breadcrumb-item"><a href="{{ route('gudang-telur.telur-inventory.index') }}">Telur Inventory</a></li>
                <li class="breadcrumb-item active">Telur Keluar</li>
            </ol>
        </div>
    </div>
</div>
@endsection


@section('content')
<div class="mx-1000">
    <x-form-alert />

    <div class="card">
        <div class="card-body">
            <form action="{{ route('gudang-telur.telur-keluar.index', request()->all()) }}" method="get" class="w-100">
                <div class="d-flex gap-2 justify-content-start align-items-end">
                    <x-adminlte-input
                        label="Tanggal"
                        type="date"
                        name="tanggal"
                        fgroup-class="mb-0 mx-sm-200"
                        :value="request()->query('tanggal')"
                    />

                    <input 
                        type="search" 
                        name="search" 
                        class="form-control mx-sm-200" 
                        placeholder="Pic User, Asal Telur"
                        value="{{ request()->query('search') }}"
                    >

                    <button class="btn btn-primary" title="Cari">
                        <i class="fas fa-search"></i>
                    </button>

                    <a href="{{ route('gudang-telur.telur-keluar.index') }}" class="btn btn-secondary">
                        <i class="fas fa-undo"></i>
                    </a>
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
                        <x-sort-th class="align-middle" style="min-width: 150px;" label="Tanggal" name="tanggal" />
                        <x-sort-th class="align-middle" style="min-width: 150px;" label="Pic User" name="nama_pic_user" />
                        <x-sort-th class="align-middle" style="min-width: 150px;" label="Tujuan Telur" name="nama_telur_tujuan" />
                        <th class="align-middle" style="width: 40px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($datas as $data)
                        <tr>
                            <td>{{ ($datas->currentPage() - 1) * $datas->perPage() + $loop->iteration }}</td>
                            <td class="text-left">{{ $data->tanggal->translatedFormat('l, d F Y') }}</td>
                            <td class="text-left">{{ $data->nama_pic_user }}</td>
                            <td class="text-left">{{ $data->nama_telur_tujuan }}</td>
                            <td>
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('gudang-telur.telur-keluar.edit', $data->id) }}" class="btn btn-sm btn-warning text-white">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form 
                                        action="{{ route('gudang-telur.telur-keluar.destroy', $data->id) }}"
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
                            <td colspan="5" class="text-center">Data Telur Masuk tidak tersedia</td>
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
            title: `Hapus Data Telur Masuk "${tanggal}"?`,
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