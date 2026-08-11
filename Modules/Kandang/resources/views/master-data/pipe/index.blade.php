@extends('layouts.dashboard')

@section('title', 'Pipa')

@push('css')
<style>
    [x-cloak] {
        display: none !important;
    }
    select:disabled {
        background-color: #e9ecef;
        cursor: not-allowed;
    }
</style>
@endpush

@section('content_header')
    <x-page-header title="Pipa" :breadcrumbs="['Master Data' => '#', 'Pipa' => '']" />
@endsection

@section('content')
<div class="mx-1200">
    <x-form-alert />

    <x-filter-panel
        action="{{ route('master-data.pipe.index') }}"
        resetUrl="{{ route('master-data.pipe.index') }}"
        x-data="{
            peternakanData: {{ Js::from($peternakan) }},
            selectedPeternakan: '{{ request('peternakan_id') ?? '' }}',
            selectedKandang: '{{ request('kandang_id') ?? '' }}',
            selectedFlock: '{{ request('flock_id') ?? '' }}',
            get kandangList() {
                if (!this.selectedPeternakan) return [];
                const peternakan = this.peternakanData.find(p => p.id == this.selectedPeternakan);
                return peternakan ? peternakan.kandang : [];
            },
            get flockList() {
                if (!this.selectedKandang) return [];
                const peternakan = this.peternakanData.find(p => p.id == this.selectedPeternakan);
                if (!peternakan) return [];
                const kandang = peternakan.kandang.find(k => k.id == this.selectedKandang);
                return kandang ? kandang.flocks : [];
            },
            onPeternakanChange() { this.selectedKandang = ''; this.selectedFlock = ''; },
            onKandangChange() { this.selectedFlock = ''; }
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
            <select name="kandang_id" class="form-control" x-model="selectedKandang" @change="onKandangChange()" :disabled="!selectedPeternakan">
                <option value="">Semua Kandang</option>
                <template x-for="kandang in kandangList" :key="kandang.id">
                    <option :value="kandang.id" x-text="kandang.nama"></option>
                </template>
            </select>
        </div>
        <div class="col-12 col-sm-auto">
            <select name="flock_id" class="form-control" x-model="selectedFlock" :disabled="!selectedKandang">
                <option value="">Semua Flock</option>
                <template x-for="flock in flockList" :key="flock.id">
                    <option :value="flock.id" x-text="flock.nama"></option>
                </template>
            </select>
        </div>
        <div class="col-12 col-sm">
            <input type="search" name="search" class="form-control" placeholder="Kandang, Flock, Pipe ..." value="{{ request()->query('search') }}">
        </div>
    </x-filter-panel>

    <div class="card desktop-table d-none d-md-block">
        <div class="card-body table-responsive p-0">
            <table class="table table-hover table-striped table-bordered text-center mb-0">
                <thead class="bg-light">
                  <tr>
                        <th width="50">#</th>
                        <x-sort-th label="Nama Peternakan" name="nama_peternakan" />
                        <x-sort-th label="Nama Kandang" name="nama_kandang" />
                        <x-sort-th label="Nama Flock" name="nama_flock" />
                        <x-sort-th label="Nama Pipa" name="nama" />
                        <x-sort-th label="Kapasitas" name="kapasitas" />
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($datas as $row)
                    <tr>
                        <td>{{ ($loop->index + 1) + (request()->get('page', 1) - 1) * $datas->perPage() }}</td>
                        <td class="text-left">{{ $row->nama_peternakan ?? '-' }}</td>
                        <td class="text-left">{{ $row->nama_kandang ?? '-' }}</td>
                        <td class="text-left">{{ $row->nama_flock ?? '-' }}</td>
                        <td class="text-left">{{ $row->nama ?? '-' }}</td>
                        <td class="text-right">{{ format_angka($row->kapasitas) }}</td>
                        <td class="text-center">
                        <div class="d-flex justify-content-center" style="gap: .5em">
                            <a href="{{ route('master-data.pipe.edit', $row) }}" class="btn btn-warning text-white btn-sm" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>

                            <form action="{{ route('master-data.pipe.destroy', $row->id) }}"
                                method="post"
                                data-nama="{{ $row->nama }}"
                                class="form-delete d-inline">
                                @csrf
                                @method('delete')
                                <button class="btn btn-danger btn-sm" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-muted">Belum ada data pipa.</td>
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
            <x-mobile-card title="{{ $row->nama ?? '-' }}" subtitle="{{ $row->nama_kandang ?? '-' }}">
                <div class="data-row">
                    <span class="data-label">Peternakan</span>
                    <span class="data-value">{{ $row->nama_peternakan ?? '-' }}</span>
                </div>
                <div class="data-row">
                    <span class="data-label">Flock</span>
                    <span class="data-value">{{ $row->nama_flock ?? '-' }}</span>
                </div>
                <div class="data-row">
                    <span class="data-label">Kapasitas</span>
                    <span class="data-value">{{ format_angka($row->kapasitas) }}</span>
                </div>
                <x-slot name="actions">
                    <a href="{{ route('master-data.pipe.edit', $row) }}" class="btn btn-warning btn-sm text-white">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <form action="{{ route('master-data.pipe.destroy', $row->id) }}"
                        method="post"
                        data-nama="{{ $row->nama }}"
                        class="form-delete d-inline">
                        @csrf
                        @method('delete')
                        <button class="btn btn-sm btn-danger">
                            <i class="fas fa-trash"></i> Hapus
                        </button>
                    </form>
                </x-slot>
            </x-mobile-card>
        @empty
            <div class="text-center text-muted p-4">Belum ada data pipa.</div>
        @endforelse

        <div class="d-flex justify-content-end mt-3">
            {{ $datas->links('components.pagination') }}
        </div>
    </div>
</div>
@endsection

@push('js')
    <script>
        $(document).on('submit', '.form-delete', function(e) {
            e.preventDefault();
            const nama = $(this).data('nama');

            Swal.fire({
                title: `Hapus Pipa "${nama}"?`,
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
