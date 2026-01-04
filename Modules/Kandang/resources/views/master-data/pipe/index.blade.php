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
    <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <div class="d-flex align-items-center gap-1">
                <h1>Pipa</h1>
                @can('Tambah Pipa')
                    <a href="{{ route('master-data.pipe.create') }}" class="btn btn-primary" title="Tambah Pipa">
                        Tambah Pipa
                    </a>
                @endcan
            </div>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Master Data</a></li>
              <li class="breadcrumb-item active">Pipa</li>
            </ol>
          </div>
        </div>
    </div>
@endsection

@section('content')
<div class="mx-1400">
    <x-form-alert />

    <div class="card">
        <div class="card-body">
            <form 
                action="{{ route('master-data.pipe.index') }}" 
                method="GET" 
                class="d-flex gap-2"
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
                
                <select
                    id="peternakanFilter"
                    name="peternakan_id" 
                    class="form-control mx-200"
                    x-model="selectedPeternakan"
                    @change="onPeternakanChange()">
                    <option value="">Semua Peternakan</option>
                    <template x-for="item in peternakanData" :key="item.id">
                        <option :value="item.id" x-text="item.nama" :selected="item.id == '{{ request('peternakan_id') ?? '' }}'"></option>
                    </template>
                </select>
    
                <select 
                    id="kandangFilter"
                    name="kandang_id" 
                    class="form-control mx-200"
                    x-model="selectedKandang"
                    @change="onKandangChange()"
                    :disabled="!selectedPeternakan">
                    <option value="">Semua Kandang</option>
                    <template x-for="kandang in kandangList" :key="kandang.id">
                        <option :value="kandang.id" x-text="kandang.nama" :selected="kandang.id == '{{ request('kandang_id') ?? '' }}'"></option>
                    </template>
                </select>
                
                <select 
                    id="flockFilter"
                    name="flock_id" 
                    class="form-control mx-200"
                    x-model="selectedFlock"
                    :disabled="!selectedKandang">
                    <option value="">Semua Baris</option>
                    <template x-for="flock in flockList" :key="flock.id">
                        <option :value="flock.id" x-text="flock.nama" :selected="flock.id == '{{ request('flock_id') ?? '' }}'"></option>
                    </template>
                </select>
                
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-filter"></i>
                </button>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
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
                
                <div class="d-flex justify-content-end align-items-center">
                    <div class="d-flex" style="gap: .5em">
                        <input type="search" 
                               name="search" 
                               class="form-control" 
                               placeholder="Kandang atau Baris" 
                               value="{{ request()->query('search') }}">
                        <button class="btn btn-primary" title="Cari">
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
                        <th class="mx-50">#</th>
                        <th>Kandang</th>
                        <th>Baris</th>
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
                        <td>{{ $row->flock->nama }}</td> 
                        <td>{{ $row->flock->kandang->nama  }}</td> 
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
