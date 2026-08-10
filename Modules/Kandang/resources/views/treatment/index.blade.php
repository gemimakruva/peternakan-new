@extends('layouts.dashboard')

@section('title', 'Treatment')

@section('content_header')
    <x-page-header title="Treatment" :breadcrumbs="['Treatment' => '']">
        <x-slot name="actions">
            <a href="{{ route('treatment.create') }}" class="btn btn-primary">Tambah Treatment</a>
        </x-slot>
    </x-page-header>
@endsection

@section('content')
    <div class="mx-1200">
        <x-form-alert />

        <x-filter-panel action="{{ route('treatment.index') }}" resetUrl="{{ route('treatment.index') }}">
            <div class="col-12 col-md-4">
                <x-adminlte-select
                    name="kandang_id"
                    fgroup-class="mb-0 w-100"
                >
                    <x-adminlte-options
                        :options="$listKandang"
                        empty-option="Semua Kandang ..."
                        :selected="request()->query('kandang_id')"
                    />
                </x-adminlte-select>
            </div>

            <div class="col-12 col-md-4">
                <x-adminlte-input
                    type="search"
                    name="search"
                    placeholder="Nama Pencatat ..."
                    :value="request()->query('search')"
                    fgroup-class="mb-0 w-100"
                />
            </div>
        </x-filter-panel>

        <div class="card desktop-table d-none d-md-block">
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
                                            data-tanggal="{{ $row->tanggal->translatedFormat('l, d F Y') }}" class="form-delete">
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

        <div class="mobile-card-list d-md-none">
            @forelse($datas as $row)
                <x-mobile-card
                    title="{{ $row->nama_kandang }}"
                    subtitle="{{ $row->tanggal->translatedFormat('d M Y') }}"
                >
                    <div class="data-row">
                        <span class="data-label">Pencatat</span>
                        <span class="data-value">{{ $row->nama_creator }}</span>
                    </div>
                    <x-slot name="actions">
                        <a href="{{ route('treatment.edit', $row->id) }}" class="btn btn-warning btn-sm text-white">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <form action="{{ route('treatment.destroy', $row->id) }}" method="post"
                            data-tanggal="{{ $row->tanggal->translatedFormat('l, d F Y') }}" class="form-delete d-inline">
                            @csrf
                            @method('delete')
                            <button class="btn btn-sm btn-danger">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                        </form>
                    </x-slot>
                </x-mobile-card>
            @empty
                <div class="text-center text-muted p-4">Tidak ada data treatment ditemukan.</div>
            @endforelse

            @if ($datas->hasPages())
                <div class="d-flex justify-content-end mt-3">
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
                title: `Hapus Treatment "${tanggal}"?`,
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