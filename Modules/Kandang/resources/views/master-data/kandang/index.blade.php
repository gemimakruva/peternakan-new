@extends('layouts.dashboard')

@section('title', 'Kandang')

@section('content_header')
    <x-page-header title="Kandang" :breadcrumbs="['Master Data' => '#', 'Kandang' => '']">
        <x-slot name="actions">
            <a href="{{ route('master-data.kandang.create') }}" class="btn btn-primary">Tambah Kandang</a>
        </x-slot>
    </x-page-header>
@endsection

@section('content')
    <div class="mx-1200">
        <x-form-alert />

        <x-filter-panel
            action="{{ route('master-data.kandang.index') }}"
            resetUrl="{{ route('master-data.kandang.index') }}"
            x-data="{
                strainData: {{ Js::from($strain) }},
                peternakanData: {{ Js::from($peternakan) }},
                selectedStrain: '{{ request('strain_id') ?? '' }}',
                selectedPeternakan: '{{ request('peternakan_id') ?? '' }}',
            }">
            <div class="col-12 col-sm-auto">
                <select name="strain_id" class="form-control" x-model="selectedStrain">
                    <option value="">Semua Strain</option>
                    <template x-for="strain in strainData" :key="strain.id">
                        <option :value="strain.id" x-text="strain.nama"></option>
                    </template>
                </select>
            </div>
            <div class="col-12 col-sm-auto">
                <select name="peternakan_id" class="form-control" x-model="selectedPeternakan">
                    <option value="">Semua Peternakan</option>
                    <template x-for="item in peternakanData" :key="item.id">
                        <option :value="item.id" x-text="item.nama"></option>
                    </template>
                </select>
            </div>
            <div class="col-12 col-sm">
                <input type="search" name="search" class="form-control" placeholder="Nama Kandang..." value="{{ request()->query('search') }}">
            </div>
        </x-filter-panel>

        <div class="card desktop-table d-none d-md-block">
            <div class="card-body table-responsive p-0">
                <table class="table table-hover table-striped table-bordered text-center">
                    <thead class="bg-light">
                        <th style="width: 50px;">#</th>
                        <x-sort-th label="Strain" name="nama_strain" />
                        <x-sort-th label="Nama Peternakan" name="nama_peternakan" />
                        <x-sort-th label="Nama Kandang" name="nama_kandang" />
                        <x-sort-th label="Kapasitas Kandang" name="kapasitas_kandang" />
                        <th style="width: 150px;">Aksi</th>
                    </thead>
                    <tbody>
                        @forelse($kandang as $row)
                            <tr>
                                <td class="text-center">{{ ($loop->index + 1) + (request()->get('page', 1) * 10 - 10) }}</td>
                                <td class="text-left">{{ $row->nama_strain }}</td>
                                <td class="text-left">{{ $row->nama_peternakan }}</td>
                                <td class="text-left">{{ $row->nama_kandang }}</td>
                                <td class="text-right">{{ format_angka($row->kapasitas_kandang) }}</td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center" style="gap: .5em">
                                        <a href="{{ route('master-data.kandang.show', $row) }}" class="btn btn-sm btn-info text-white" title="Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>

                                        <a href="{{ route('master-data.kandang.edit', $row) }}" class="btn btn-sm btn-warning text-white" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        @if (!$row->flocks()->exists())
                                            <form action="{{ route('master-data.kandang.destroy', $row) }}" method="post"
                                                data-nama="{{ $row->nama }}" class="form-delete">
                                                @csrf
                                                @method('delete')
                                                <button class="btn btn-sm btn-danger" title="Hapus">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-3">
                                    Tidak ada data kandang ditemukan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($kandang->hasPages())
                <div class="card-footer d-flex justify-content-end">
                    {{ $kandang->links('components.pagination') }}
                </div>
            @endif
        </div>

        <div class="mobile-card-list d-md-none">
            @forelse($kandang as $row)
                <x-mobile-card title="{{ $row->nama_kandang }}" subtitle="{{ $row->nama_peternakan }}">
                    <div class="data-row">
                        <span class="data-label">Strain</span>
                        <span class="data-value">{{ $row->nama_strain }}</span>
                    </div>
                    <div class="data-row">
                        <span class="data-label">Kapasitas</span>
                        <span class="data-value">{{ format_angka($row->kapasitas_kandang) }}</span>
                    </div>
                    <x-slot name="actions">
                        <a href="{{ route('master-data.kandang.show', $row) }}" class="btn btn-info btn-sm text-white">
                            <i class="fas fa-eye"></i> Detail
                        </a>
                        <a href="{{ route('master-data.kandang.edit', $row) }}" class="btn btn-warning btn-sm text-white">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        @if (!$row->flocks()->exists())
                            <form action="{{ route('master-data.kandang.destroy', $row) }}" method="post"
                                data-nama="{{ $row->nama }}" class="form-delete d-inline">
                                @csrf
                                @method('delete')
                                <button class="btn btn-sm btn-danger">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </form>
                        @endif
                    </x-slot>
                </x-mobile-card>
            @empty
                <div class="text-center text-muted p-4">Tidak ada data kandang ditemukan.</div>
            @endforelse

            @if ($kandang->hasPages())
                <div class="d-flex justify-content-end mt-3">
                    {{ $kandang->links('components.pagination') }}
                </div>
            @endif
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(document).on('submit', '.form-delete', function(e) {
            e.preventDefault();
            const nama = $(this).data('nama');

            Swal.fire({
                title: `Hapus Kandang "${nama}"?`,
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
