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
    <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <div class="d-flex align-items-center gap-1">
                <h1>Flock</h1>
            </div>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Master Data</a></li>
              <li class="breadcrumb-item active">Flock</li>
            </ol>
          </div>
        </div>
    </div>
@endsection

@section('content')
<div class="mx-1200">
    <x-form-alert />

    {{-- Filter --}}
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Filter</h2>
        </div>
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

                <input type="search" 
                    name="search" 
                    class="form-control mx-200" 
                    placeholder="Nama Flock..." 
                    value="{{ request()->query('search') }}">
    
                <div class="d-flex justify-content-end gap-2">
                    <button type="submit" class="btn btn-primary btn-block">
                        <i class="fas fa-search"></i>
                    </button>
                    <a href="{{ route('master-data.flock.index') }}" class="btn btn-secondary">
                        <i class="fas fa-undo"></i>
                    </a>
                </div>
            </form>
        </div>
    </div>

    {{-- Table --}}
    <div class="card">
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
