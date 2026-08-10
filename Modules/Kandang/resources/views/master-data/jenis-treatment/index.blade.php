@extends('layouts.dashboard')

@section('title', 'Jenis Treatment')

@section('content_header')
    <x-page-header title="Jenis Treatment" :breadcrumbs="['Master Data' => '#', 'Jenis Treatment' => '']">
        <x-slot name="actions">
            <a href="{{ route('master-data.jenis-treatment.create') }}" class="btn btn-primary">Tambah Jenis Treatment</a>
        </x-slot>
    </x-page-header>
@endsection

@section('content')
    <div class="mx-1200">
        <x-form-alert />

        <x-filter-panel action="{{ route('master-data.jenis-treatment.index', request()->all()) }}" resetUrl="{{ route('master-data.jenis-treatment.index') }}">
            <div class="col-12 col-md-4">
                <input type="search" name="search" class="form-control" placeholder="Cari Jenis Treatment..." value="{{ request()->query('search') }}">
            </div>
        </x-filter-panel>

        <div class="card desktop-table d-none d-md-block">
            <div class="card-body table-responsive p-0">
                <table class="table table-hover table-striped table-bordered text-center">
                    <thead class="bg-light">
                        <th style="width: 50px;">#</th>
                        <th>Jenis Treatment</th>
                        <th style="width: 150px;">Aksi</th>
                    </thead>
                    <tbody>
                        @forelse($jenisTreatment as $row)
                            <tr>
                                <td class="text-center">{{ ($loop->index + 1) + ($jenisTreatment->currentPage() - 1) * $jenisTreatment->perPage() }}</td>
                                <td class="text-left">{{ $row->nama }}</td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center" style="gap: .5em">
                                        <a href="{{ route('master-data.jenis-treatment.edit', $row) }}" class="btn btn-sm btn-warning text-white" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <form action="{{ route('master-data.jenis-treatment.destroy', $row) }}" method="post"
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
                                <td colspan="3" class="text-center text-muted py-3">
                                    Tidak ada data jenis treatment ditemukan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($jenisTreatment->hasPages())
                <div class="card-footer d-flex justify-content-end">
                    {{ $jenisTreatment->links('components.pagination') }}
                </div>
            @endif
        </div>

        <div class="mobile-card-list d-md-none">
            @forelse($jenisTreatment as $row)
                <x-mobile-card title="{{ $row->nama }}">
                    <x-slot name="actions">
                        <a href="{{ route('master-data.jenis-treatment.edit', $row) }}" class="btn btn-warning btn-sm text-white">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <form action="{{ route('master-data.jenis-treatment.destroy', $row) }}" method="post"
                            data-nama="{{ $row->nama }}" class="form-delete d-inline">
                            @csrf
                            @method('delete')
                            <button class="btn btn-sm btn-danger">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                        </form>
                    </x-slot>
                </x-mobile-card>
            @empty
                <div class="text-center text-muted p-4">Tidak ada data jenis treatment ditemukan.</div>
            @endforelse

            @if ($jenisTreatment->hasPages())
                <div class="d-flex justify-content-end mt-3">
                    {{ $jenisTreatment->links('components.pagination') }}
                </div>
            @endif
        </div>
    </div>
@endsection
@push('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).on('submit', '.form-delete', function (e) {
            e.preventDefault();
            const nama = $(this).data('nama');

            Swal.fire({
                title: `Hapus Jenis Treatment "${nama}"?`,
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