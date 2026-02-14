@extends('layouts.dashboard')

@section('title', 'Treatment')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <div class="d-flex align-items-center gap-1">
                    <h1>Treatment</h1>
                    <a href="{{ route('treatment.create') }}" class="btn btn-primary">Tambah Treatment</a>
                </div>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item active">Treatment</li>
                </ol>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="mx-1200">
        <x-form-alert />

        <div class="card">
            <div class="card-header">
                <h2 class="card-title">Filter</h2>
            </div>
            <div class="card-body">
                <form
                    action="{{ route('treatment.index') }}"
                    method="get"
                    class="d-flex gap-3 align-items-end flex-column flex-sm-row"
                >
                    <x-adminlte-select
                        name="kandang_id"
                        fgroup-class="mb-0 w-100 mx-sm-200"
                    >
                        <x-adminlte-options
                            :options="$listKandang"
                            empty-option="Semua Kandang ..."
                            :selected="request()->query('kandang_id')"
                        />
                    </x-adminlte-select>

                    <x-adminlte-input 
                        type="search"
                        name="search"
                        placeholder="Nama Pencatat ..."
                        :value="request()->query('search')"
                        fgroup-class="mb-0 w-100 mx-sm-200"
                    />
                    
                    <div class="d-flex gap-2">
                        <button class="btn btn-primary" type="submit">
                            <i class="fas fa-search"></i>
                        </button>

                        <a href="{{ route('treatment.index') }}" class="btn btn-secondary">
                            <i class="fas fa-undo"></i>
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-body table-responsive p-0">
                <table class="table table-hover table-striped table-bordered text-center">
                    <thead class="bg-light">
                        <th style="width: 50px;">#</th>
                        <x-sort-th label="Nama Kandang" name="nama_kandang"></x-sort-th>
                        <x-sort-th label="Nama Pencatat" name="nama_creator"></x-sort-th>
                        <x-sort-th label="Tanggal" name="tanggal"></x-sort-th>
                        <th style="width: 150px;">Aksi</th>
                    </thead>
                    <tbody>
                        @forelse($datas as $row)
                            <tr>
                                <td class="text-right">{{ ($loop->index + 1) + (request()->get('page', 1) * 10 - 10) }}</td>
                                <td class="text-left">{{ $row->nama_kandang }}</td>
                                <td class="text-left">{{ $row->nama_creator }}</td>
                                <td class="text-left">{{ $row->tanggal->translatedFormat('l, d F Y') }}</td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center" style="gap: .5em">
                                        <a href="{{ route('treatment.edit', $row->id) }}" class="btn btn-sm btn-warning" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <form action="{{ route('treatment.destroy', $row->id) }}" method="post"
                                            data-nama="{{ $row->nama }}" class="form-delete">
                                            @csrf
                                            @method('delete')
                                            <button class="btn btn-sm btn-danger" title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-3">
                                    Tidak ada data treatment ditemukan.
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
@endsection

@push('js')
    <script>
        $(document).on('submit', '.form-delete', function (e) {
            e.preventDefault();
            const nama = $(this).data('nama');

            Swal.fire({
                title: `Hapus Treatment "${nama}"?`,
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