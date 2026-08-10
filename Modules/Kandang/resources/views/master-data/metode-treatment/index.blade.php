@extends('layouts.dashboard')

@section('title', 'Metode Treatment')

@section('content_header')
    <x-page-header title="Metode Treatment" :breadcrumbs="['Master Data' => '#', 'Metode Treatment' => '']">
        <x-slot name="actions">
            <a href="{{ route('master-data.metode-treatment.create') }}" class="btn btn-primary">Tambah Metode Treatment</a>
        </x-slot>
    </x-page-header>
@endsection

@section('content')
    <div class="mx-1200">
        <x-form-alert />

        <x-filter-panel action="{{ route('master-data.metode-treatment.index', request()->all()) }}" resetUrl="{{ route('master-data.metode-treatment.index') }}">
            <div class="col-12 col-md-4">
                <input type="search" name="search" class="form-control" placeholder="Cari Metode Treatment..." value="{{ request()->query('search') }}">
            </div>
        </x-filter-panel>

        <div class="card desktop-table d-none d-md-block">
            <div class="card-body table-responsive p-0">
                <table class="table table-hover table-striped table-bordered text-center">
                    <thead class="bg-light">
                        <th style="width: 50px;">#</th>
                        <th>Metode Treatment</th>
                        <th style="width: 150px;">Aksi</th>
                    </thead>
                    <tbody>
                        @forelse($metodeTreatment as $row)
                            <tr>
                                <td class="text-center">{{ ($loop->index + 1) + ($metodeTreatment->currentPage() - 1) * $metodeTreatment->perPage() }}</td>
                                <td class="text-left">{{ $row->nama }}</td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center" style="gap: .5em">
                                        <a href="{{ route('master-data.metode-treatment.edit', $row) }}" class="btn btn-sm btn-warning text-white" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <form action="{{ route('master-data.metode-treatment.destroy', $row) }}" method="post"
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
                                    Tidak ada data metode treatment ditemukan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($metodeTreatment->hasPages())
                <div class="card-footer d-flex justify-content-end">
                    {{ $metodeTreatment->links('components.pagination') }}
                </div>
            @endif
        </div>

        <div class="mobile-card-list d-md-none">
            @forelse($metodeTreatment as $row)
                <x-mobile-card title="{{ $row->nama }}">
                    <x-slot name="actions">
                        <a href="{{ route('master-data.metode-treatment.edit', $row) }}" class="btn btn-warning btn-sm text-white">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <form action="{{ route('master-data.metode-treatment.destroy', $row) }}" method="post"
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
                <div class="text-center text-muted p-4">Tidak ada data metode treatment ditemukan.</div>
            @endforelse

            @if ($metodeTreatment->hasPages())
                <div class="d-flex justify-content-end mt-3">
                    {{ $metodeTreatment->links('components.pagination') }}
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
                title: `Hapus Metode Treatment "${nama}"?`,
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
