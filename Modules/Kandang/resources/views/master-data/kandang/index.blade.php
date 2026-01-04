@extends('layouts.dashboard')

@section('title', 'Kandang')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <div class="d-flex align-items-center gap-1">
                <h1>Kandang</h1>
                @can('Tambah Kandang')
                    <a href="{{ route('master-data.kandang.create') }}" class="btn btn-primary">Tambah Kandang</a>
                @endcan
            </div>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Master Data</a></li>
              <li class="breadcrumb-item active">Kandang</li>
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
            <div class="card-body">
                <form 
                    action="{{ route('master-data.kandang.index') }}" 
                    method="GET" 
                    class="d-flex gap-3 align-items-end"
                    x-data="{
                        strainData: {{ Js::from($strain) }},
                        peternakanData: {{ Js::from($peternakan) }},
                        selectedStrain: '{{ request('strain_id') ?? '' }}',
                        selectedPeternakan: '{{ request('peternakan_id') ?? '' }}',
                    }">
                    
                    <select 
                        id="strainFilter"
                        name="strain_id" 
                        class="form-control mx-200"
                        x-model="selectedStrain">
                        <option value="">Semua Strain</option>
                        <template x-for="strain in strainData" :key="strain.id">
                            <option :value="strain.id" x-text="strain.nama" :selected="strain.id == '{{ request('strain_id') ?? '' }}'"></option>
                        </template>
                    </select>

                    <select 
                        id="peternakanFilter"
                        name="peternakan_id" 
                        class="form-control mx-200"
                        x-model="selectedPeternakan">
                        <option value="">Semua Peternakan</option>
                        <template x-for="item in peternakanData" :key="item.id">
                            <option :value="item.id" x-text="item.nama" :selected="item.id == '{{ request('peternakan_id') ?? '' }}'"></option>
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
        
        <div class="card">
            <div class="card-header text-white d-flex justify-content-between align-items-center" >
                <form action="{{ route('master-data.kandang.index', request()->all()) }}" method="get" class="w-100">
                    <div class="d-flex justify-content-end align-items-center">
                        <div class="d-flex gap-2">
                            <input type="search" name="search" class="form-control" placeholder="Cari Kandang..." value="{{ request()->query('search') }}">
                            <button class="btn btn-primary" title="Cari">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="card-body table-responsive p-0">
                <table class="table table-hover table-striped table-bordered text-center">
                    <thead class="bg-light">
                        <th style="width: 50px;">#</th>
                        <th>Strain</th>
                        <th>Nama Peternakan</th>
                        <th>Nama Kandang</th>
                        <th style="width: 150px;">Aksi</th>
                    </thead>
                    <tbody>
                        @forelse($kandang as $row)
                            <tr>
                                <td class="text-center">{{ ($loop->index + 1) + (request()->get('page', 1) * 10 - 10) }}</td>
                                <td class="text-left">{{ $row->strain->nama }}</td>
                                <td class="text-left">{{ $row->peternakan->nama }}</td>
                                <td class="text-left">{{ $row->nama }}</td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center" style="gap: .5em">
                                        <a href="{{ route('master-data.kandang.show', $row) }}" class="btn btn-sm btn-info text-white" title="Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>

                                        @can('Edit Kandang')
                                            <a href="{{ route('master-data.kandang.edit', $row) }}" class="btn btn-sm btn-warning text-white" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        @endcan

                                        @if (auth()->user()->can('Hapus Kandang') && !$row->flocks()->exists())
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
                                <td colspan="5" class="text-center text-muted py-3">
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
    </div>
    @include('components.snackbar')
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
