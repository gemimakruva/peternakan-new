@extends('layouts.dashboard')

@section('title', 'Baris')

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
    <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <div class="d-flex align-items-center gap-1">
                <h1>Baris</h1>
                @can('Tambah Baris')
                    <a href="{{ route('master-data.flock.create') }}" class="btn btn-primary" title="Tambah Baris">
                        Tambah Baris
                    </a>
                @endcan
            </div>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Master Data</a></li>
              <li class="breadcrumb-item active">Baris</li>
            </ol>
          </div>
        </div>
    </div>
@endsection

@section('content')
<div class="mx-1000">
    <x-form-alert />

    {{-- Filter --}}
    <div class="card">
        <div class="card-body">
            <form 
                action="{{ route('master-data.flock.index') }}" 
                method="GET" 
                class="d-flex gap-3 align-items-end"
                x-data="{
                    peternakanData: {{ Js::from($peternakan) }},
                    selectedPeternakan: '{{ request('peternakan_id') ?? '' }}',
                    selectedKandang: '{{ request('kandang_id') ?? '' }}',
                    get kandangList() {
                        if (!this.selectedPeternakan) {
                            return [];
                        }
                        const peternakan = this.peternakanData.find(p => p.id == this.selectedPeternakan);
                        return peternakan ? peternakan.kandang : [];
                    },
                    onPeternakanChange() {
                        this.selectedKandang = '';
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
                    :disabled="!selectedPeternakan">
                    <option value="">Semua Kandang</option>
                    <template x-for="kandang in kandangList" :key="kandang.id">
                        <option :value="kandang.id" x-text="kandang.nama" :selected="kandang.id == '{{ request('kandang_id') ?? '' }}'"></option>
                    </template>
                </select>
    
                <div>
                    <button type="submit" class="btn btn-primary btn-block">
                        <i class="fas fa-filter"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Table --}}
    <div class="card">
        <div class="card-header text-white d-flex justify-content-between align-items-center">
            <form action="{{ route('master-data.flock.index') }}" method="get" class="w-100">
                @if(request('peternakan_id'))
                    <input type="hidden" name="peternakan_id" value="{{ request('peternakan_id') }}">
                @endif
                @if(request('kandang_id'))
                    <input type="hidden" name="kandang_id" value="{{ request('kandang_id') }}">
                @endif
                
                <div class="d-flex justify-content-between align-items-center">
                    <h2 class="card-title mb-0">List Baris</h2>
                    <div class="d-flex" style="gap: .5em">
                        <input type="search" 
                            name="search" 
                            class="form-control" 
                            placeholder="Cari baris..." 
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
                        <th style="width: 50px;">#</th>
                        <th>Nama Kandang</th>
                        <th>Nama Baris</th>
                        <th style="width: 180px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($datas as $row)
                    <tr>    
                        <td>{{ ($loop->index + 1) + ($datas->currentPage() - 1) * $datas->perPage() }}</td>
                        <td>{{ $row->kandang->nama ?? '-' }}</td>
                        <td>{{ $row->nama }}</td>
                        <td>
                            <div class="d-flex justify-content-center gap-2" role="group">
                                <a href="{{ route('master-data.flock.show',
                                 $row) }}" class="btn btn-info btn-sm" title="Lihat Detail">
                                    <i class="fas fa-eye"></i>
                                </a>

                                <a href="{{ route('master-data.flock.edit',
                                 $row) }}" class="btn btn-warning text-white btn-sm" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>

                                @if (auth()->user()->can('Hapus Flock') && !$row->pipes()->exists())    
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
                        <td colspan="6" class="text-muted">Belum ada data baris.</td>
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
@include('components.snackbar')
@endsection

@push('js')
    <script>
        $(document).on('submit', '.form-delete', function(e) {
            e.preventDefault();
            const nama = $(this).data('nama');
            Swal.fire({
                title: `Hapus Baris "${nama}"?`,
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
