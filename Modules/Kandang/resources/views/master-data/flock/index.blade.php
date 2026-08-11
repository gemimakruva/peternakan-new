@extends('layouts.dashboard')

@section('title', 'Flock')

@push('css')
<style>
    [x-cloak] { display: none !important; }

    select:disabled {
        background-color: #e9ecef;
        cursor: not-allowed;
    }
</style>
@endpush

@section('content_header')
    <x-page-header title="Flock" :breadcrumbs="['Master Data' => '#', 'Flock' => '']" />
@endsection

@section('content')
<div class="mx-1200">
    <x-form-alert />

    <x-filter-panel
        action="{{ route('master-data.flock.index') }}"
        resetUrl="{{ route('master-data.flock.index') }}"
        x-data="{
            peternakanData: {{ Js::from($peternakan) }},
            selectedPeternakan: '{{ request('peternakan_id') ?? '' }}',
            selectedKandang: '{{ request('kandang_id') ?? '' }}',
            get kandangList() {
                if (!this.selectedPeternakan) return [];
                const peternakan = this.peternakanData.find(p => p.id == this.selectedPeternakan);
                return peternakan ? peternakan.kandang : [];
            },
            onPeternakanChange() { this.selectedKandang = ''; }
        }">
        <div class="col-12 col-sm-auto">
            <select name="peternakan_id" class="form-control" x-model="selectedPeternakan" @change="onPeternakanChange()">
                <option value="">Semua Peternakan</option>
                <template x-for="item in peternakanData" :key="item.id">
                    <option :value="item.id" x-text="item.nama"></option>
                </template>
            </select>
        </div>
        <div class="col-12 col-sm-auto">
            <select name="kandang_id" class="form-control" x-model="selectedKandang" :disabled="!selectedPeternakan">
                <option value="">Semua Kandang</option>
                <template x-for="kandang in kandangList" :key="kandang.id">
                    <option :value="kandang.id" x-text="kandang.nama"></option>
                </template>
            </select>
        </div>
        <div class="col-12 col-sm">
            <input type="search" name="search" class="form-control" placeholder="Nama Flock..." value="{{ request()->query('search') }}">
        </div>
    </x-filter-panel>

    <div class="card desktop-table d-none d-md-block">
        <div class="card-body table-responsive p-0">
            <table class="table table-hover table-striped table-bordered text-center mb-0">
                <thead class="bg-light">
                    <tr>
                        <th style="width: 50px;">#</th>
                        <x-sort-th label="Nama Peternakan" name="nama_peternakan" />
                        <x-sort-th label="Nama Kandang" name="nama_kandang" />
                        <x-sort-th label="Nama Flock" name="nama_flock" />
                        <th style="width: 180px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($datas as $row)
                    <tr>
                        <td>{{ ($loop->index + 1) + ($datas->currentPage() - 1) * $datas->perPage() }}</td>
                        <td class="text-left">{{ $row->nama_peternakan ?? '-' }}</td>
                        <td class="text-left">{{ $row->nama_kandang ?? '-' }}</td>
                        <td class="text-left">{{ $row->nama_flock }}</td>
                        <td>
                            <div class="d-flex justify-content-center gap-2" role="group">
                                <a href="{{ route('master-data.flock.show', $row) }}" class="btn btn-info btn-sm" title="Lihat Detail">
                                    <i class="fas fa-eye"></i>
                                </a>

                                <a href="{{ route('master-data.flock.edit',
                                 $row) }}" class="btn btn-warning text-white btn-sm" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>

                                @if (!$row->pipes()->exists())
                                    <form
                                        action="{{ route('master-data.flock.destroy', $row) }}"
                                        method="post"
                                        data-nama="{{ $row->nama }}"
                                        class="form-delete d-inline">
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
                        <td colspan="6" class="text-muted">Belum ada data flock.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="card-footer d-flex justify-content-end">
            {{ $datas->links('components.pagination') }}
        </div>
    </div>

    <div class="mobile-card-list d-md-none">
        @forelse($datas as $row)
            <x-mobile-card title="{{ $row->nama_flock }}" subtitle="{{ $row->nama_kandang ?? '-' }}">
                <div class="data-row">
                    <span class="data-label">Peternakan</span>
                    <span class="data-value">{{ $row->nama_peternakan ?? '-' }}</span>
                </div>
                <x-slot name="actions">
                    <a href="{{ route('master-data.flock.show', $row) }}" class="btn btn-info btn-sm">
                        <i class="fas fa-eye"></i> Detail
                    </a>
                    <a href="{{ route('master-data.flock.edit', $row) }}" class="btn btn-warning btn-sm text-white">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    @if (!$row->pipes()->exists())
                        <form
                            action="{{ route('master-data.flock.destroy', $row) }}"
                            method="post"
                            data-nama="{{ $row->nama }}"
                            class="form-delete d-inline">
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
            <div class="text-center text-muted p-4">Belum ada data flock.</div>
        @endforelse

        <div class="d-flex justify-content-end mt-3">
            {{ $datas->links('components.pagination') }}
        </div>
    </div>
</div>
@include('components.snackbar')
@endsection

@push('js')
    <script>
        $(document).on('submit', '.form-delete', function(e) {
            e.preventDefault();
            const nama = $(this).data('nama');
            Swal.fire({
                title: `Hapus Flock "${nama}"?`,
                text: "Data yang dihapus tidak dapat dikembalikan.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Ya, Hapus",
                cancelButtonText: "Batal"
            }).then((result) => {
                if (result.value) {
                    this.submit();
                }
            });
        });
    </script>
@endpush
