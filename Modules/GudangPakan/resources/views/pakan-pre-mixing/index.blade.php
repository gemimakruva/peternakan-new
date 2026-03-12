@extends('layouts.dashboard')

@section('title', 'Pre-Mixing')

@section('content_header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <div class="d-flex align-items-center gap-1">
                <h1>Pre-Mixing</h1>
                <a href="{{ route('gudang-pakan.pakan-pre-mixing.create') }}" class="btn btn-primary">Tambah Pre-Mixing</a>
            </div>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">  
                <li class="breadcrumb-item active">Pre-Mixing</li>
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
            <form action="{{ route('gudang-pakan.pakan-pre-mixing.index', request()->all()) }}" method="get" class="w-100">                    
                <div class="d-flex gap-3 align-items-end">
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

                        <a href="{{ route('gudang-pakan.pakan-pre-mixing.index') }}" class="btn btn-secondary">
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
                        <x-sort-th class="align-middle" style="min-width: 150px;" label="Tanggal" name="tanggal" />
                        <x-sort-th class="align-middle" style="min-width: 150px;" label="Pic" name="nama_pic_user" />
                        <x-sort-th class="align-middle" style="min-width: 150px;" label="Formulasi" name="nama_formulasi" />
                        <x-sort-th class="align-middle" style="min-width: 150px;" label="Jumlah Campuran" name="jumlah_campuran" />
                        <x-sort-th class="align-middle" style="min-width: 150px;" label="Harga Total" name="harga_total" />
                        <th class="align-middle" style="width: 40px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($datas as $data)
                        <tr>
                            <td>{{ ($datas->currentPage() - 1) * $datas->perPage() + $loop->iteration }}</td>
                            <td class="text-left">{{ $data->tanggal->translatedFormat('l, d F Y - H:i') }}</td>
                            <td class="text-left">{{ $data->nama_pic_user }}</td>
                            <td class="text-left">{{ $data->nama_formulasi }}</td>
                            <td class="text-right">{{ $data->jumlah_campuran }}</td>
                            <td class="text-right">{{ format_angka($data->harga_total) }}</td>
                            <td>
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('gudang-pakan.pakan-pre-mixing.edit', $data->id) }}" class="btn btn-sm btn-warning text-white">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form
                                        action="{{ route('gudang-pakan.pakan-pre-mixing.destroy', $data->id) }}"
                                        method="post"
                                        class="form-delete"
                                        data-nama_formulasi="{{ $data->nama_formulasi }}"
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
                            <td colspan="7" class="text-center">Data Pre Mixing tidak tersedia</td>
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
            const nama_formulasi = $(this).data('nama_formulasi');

            Swal.fire({
                title: `Hapus Pre-Mixing "${nama_formulasi}"?`,
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
