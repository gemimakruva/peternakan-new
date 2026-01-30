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
            <div class="card-header">
                <h2 class="card-title">Filter</h2>
            </div>
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

                    <input 
                        type="search"
                        name="search"
                        class="form-control mx-200"
                        placeholder="Nama Kandang..."
                        value="{{ request()->query('search') }}"
                    />
                    
                    <div class="d-flex gap-2 justify-content-end">
                        <button type="submit" class="btn btn-primary btn-block">
                            <i class="fas fa-search"></i>
                        </button>
                        <a href="{{ route('master-data.kandang.index') }}" class="btn btn-secondary">
                            <i class="fas fa-undo"></i>
                        </a>
                    </div>
                </form>
            </div>
        </div>
        
        <div class="card">
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
