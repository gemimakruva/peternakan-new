@extends('adminlte::page')

@section('title', 'Pipa')

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
<div class="mb-4 text-center d-flex flex-column align-items-center pt-3" style="max-width: 1200px;">
    <h2 class="h4 fw-bold text-dark">Manajemen Pipa</h2>
    <span class="text-muted mb-0" style="max-width: 600px;">
        Halaman ini digunakan untuk menampilkan daftar pipa serta
        informasi kapasitas pada setiap pipa.
    </span>
</div>
@endsection

@section('content')
<div style="max-width: 1200px;">
    <x-form-alert />
    <div class="card-body px-0">
        <form 
            action="{{ route('master-data.pipe.index') }}" 
            method="GET" 
            class="row g-2 align-items-end"
            x-data="{
                peternakanData: {{ Js::from($peternakan) }},
                selectedPeternakan: '{{ request('peternakan_id') ?? '' }}',
                selectedKandang: '{{ request('kandang_id') ?? '' }}',
                selectedFlock: '{{ request('flock_id') ?? '' }}',
                get kandangList() {
                    if (!this.selectedPeternakan) {
                        return [];
                    }
                    const peternakan = this.peternakanData.find(p => p.id == this.selectedPeternakan);
                    return peternakan ? peternakan.kandang : [];
                },
                get flockList() {
                    if (!this.selectedKandang) {
                        return [];
                    }
                    const peternakan = this.peternakanData.find(p => p.id == this.selectedPeternakan);
                    if (!peternakan) return [];
                    const kandang = peternakan.kandang.find(k => k.id == this.selectedKandang);
                    return kandang ? kandang.flocks : [];
                },
                onPeternakanChange() {
                    this.selectedKandang = '';
                    this.selectedFlock = '';
                },
                onKandangChange() {
                    this.selectedFlock = '';
                }
            }">
            
            <div class="col-md-3 col-4">
                <label for="peternakanFilter">Peternakan</label>
                <div class="input-group input-group-lg">
                    <div class="input-group-prepend">
                        <span class="input-group-text bg-white">
                            <i class="fas fa-warehouse text-muted"></i>
                        </span>
                    </div>
                    <select 
                        id="peternakanFilter"
                        name="peternakan_id" 
                        class="form-control"
                        x-model="selectedPeternakan"
                        @change="onPeternakanChange()">
                        <option value="">Semua Peternakan</option>
                        <template x-for="item in peternakanData" :key="item.id">
                            <option :value="item.id" x-text="item.nama" :selected="item.id == '{{ request('peternakan_id') ?? '' }}'"></option>
                        </template>
                    </select>
                </div>
            </div>

            <div class="col-md-3 col-4">
                <label for="kandangFilter">Kandang</label>
                <div class="input-group input-group-lg">
                    <div class="input-group-prepend">
                        <span class="input-group-text bg-white">
                            <i class="fas fa-home text-muted"></i>
                        </span>
                    </div>
                    <select 
                        id="kandangFilter"
                        name="kandang_id" 
                        class="form-control"
                        x-model="selectedKandang"
                        @change="onKandangChange()"
                        :disabled="!selectedPeternakan">
                        <option value="">Semua Kandang</option>
                        <template x-for="kandang in kandangList" :key="kandang.id">
                            <option :value="kandang.id" x-text="kandang.nama" :selected="kandang.id == '{{ request('kandang_id') ?? '' }}'"></option>
                        </template>
                    </select>
                </div>
            </div>

            <div class="col-md-3 col-4">
                <label for="flockFilter">Baris</label>
                <div class="input-group input-group-lg">
                    <div class="input-group-prepend">
                        <span class="input-group-text bg-white">
                            <i class="fas fa-layer-group text-muted"></i>
                        </span>
                    </div>
                    <select 
                        id="flockFilter"
                        name="flock_id" 
                        class="form-control"
                        x-model="selectedFlock"
                        :disabled="!selectedKandang">
                        <option value="">Semua Baris</option>
                        <template x-for="flock in flockList" :key="flock.id">
                            <option :value="flock.id" x-text="flock.nama" :selected="flock.id == '{{ request('flock_id') ?? '' }}'"></option>
                        </template>
                    </select>
                </div>
            </div>

            <div class="col-md-1 col-1" style="max-width:80px;">
                <button type="submit" class="btn btn-primary btn-block btn-lg">
                    <i class="fas fa-filter"></i>
                </button>
            </div>
        </form>
    </div>
    <div class="card shadow-sm">
        <div class="card-header text-white d-flex justify-content-between align-items-center"
             style="background-color: #495057; border-color: #495057;">
            <form action="{{ route('master-data.pipe.index') }}" method="get" class="w-100">
                @if(request('peternakan_id'))
                    <input type="hidden" name="peternakan_id" value="{{ request('peternakan_id') }}">
                @endif
                @if(request('kandang_id'))
                    <input type="hidden" name="kandang_id" value="{{ request('kandang_id') }}">
                @endif
                @if(request('flock_id'))
                    <input type="hidden" name="flock_id" value="{{ request('flock_id') }}">
                @endif
                
                <div class="d-flex justify-content-between align-items-center">
                    <h2 class="card-title mb-0">List Pipa</h2>

                    <div class="d-flex" style="gap: .5em">
                        <input type="search" 
                               name="search" 
                               class="form-control form-control-sm" 
                               placeholder="Kandang atau Baris" 
                               value="{{ request()->query('search') }}">
                        <button class="btn btn-dark btn-sm" title="Cari">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <div class="card-body table-responsive p-0">
            <table class="table table-hover table-striped table-bordered text-center mb-0">
                <thead class="bg-light">
                  <tr>
                        <th>#</th>
                        <th>Nama</th>
                        <th>Nama Peternakan</th>
                        <th>Nama Kandang</th>
                        <th>Nama Baris</th>
                        <th>Kapasitas</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($datas as $row)
                    <tr>
                        <td>{{ ($loop->index + 1) + (request()->get('page', 1) - 1) * $datas->perPage() }}</td>
                        <td>{{ $row->nama }}</td>
                        <td>{{ $row->flock->kandang->peternakan->nama ?? '-' }}</td>
                        <td>{{ $row->flock->kandang->nama ?? '-' }}</td>
                        <td>{{ $row->flock->nama ?? '-' }}</td>
                        <td>{{ $row->kapasitas }}</td>
                        <td class="text-center">
                        <div class="d-flex justify-content-center" style="gap: .5em">
                            @can('Edit Pipe')
                            <a href="{{ route('master-data.pipe.edit', $row) }}" class="btn btn-warning text-white btn-sm" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            @endcan
                            
                            @can('Hapus Pipe')
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
                            @endcan
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
</div>
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
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
