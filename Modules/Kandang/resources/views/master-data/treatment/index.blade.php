@extends('layouts.dashboard')

@section('title', 'Pencatatan Ayam Masuk')

@section('content_header')
<div class="mb-4 text-center d-flex flex-column align-items-center pt-3" style="max-width: 1200px;">
    <h2 class="h4 fw-bold text-dark">Jenis Treatment</h2>
    <span class="text-muted mb-0" style="max-width: 600px;">
        Halaman untuk menampilkan data Jenis Disinfektan
 kandang
</div>
@stop

@section('content')
<div>
    <x-form-alert />
    <div class="card shadow-sm" style="max-width: 1200px;">
        <div class="card-header text-white d-flex justify-content-between align-items-center"
             style="background-color: #495057; border-color: #495057;">

            <form action="{{ route('master-data.jenis-treatment.index', request()->all()) }}"
                 method="get" class="w-100">
                <div class="d-flex justify-content-between align-items-center">
                    <h2 class="card-title mb-0">Daftar Jenis Treatment</h2>

                    <div class="d-flex" style="gap: .5em">
                        <input type="search"
                               name="search"
                               class="form-control form-control-sm"
                               placeholder="Cari Disinfectan..."
                               value="{{ request()->query('search') }}">

                        <button class="btn btn-dark btn-sm" title="Cari">
                            <i class="fas fa-search"></i>
                        </button>

                        @can('Tambah Jenis Disinfektan
')
                        <a href="{{ route('master-data.jenis-treatment.create') }}"
                           class="btn btn-light btn-sm text-dark"
                           title="Tambah Jenis Disinfektan
">
                            <i class="fas fa-plus"></i>
                        </a>
                        @endcan
                    </div>
                </div>
            </form>
        </div>

        <div class="card-body table-responsive p-0">
            <table class="table table-hover table-striped table-bordered text-center mb-0">
                <thead class="bg-light">
    <tr>
        <th style="width: 50px;">#</th>
        <th>Jenis Treatment</th>
        <th style="width: 150px;">Aksi</th>
    </tr>
</thead>

<tbody>
    @forelse($datas as $row)
    {{-- @dd($row->nama === 'Disenfectan') --}}
        <tr>
            {{-- Nomor urut mengikuti pagination --}}
            <td>{{ ($loop->index + 1) + (request()->get('page', 1) * $datas->perPage() - $datas->perPage()) }}</td>

            <td>{{ $row->nama }}</td>
            <td class="text-center">
                <div class="d-flex justify-content-center" style="gap: .5em">
                    @can('Edit Jenis Treatment')
                  <a href="{{ $row->nama === 'Disinfektan' ? '#' : route('master-data.jenis-treatment.edit', $row->id) }}"
                    class="btn btn-sm btn-warning text-white {{ $row->nama === 'Disinfektan' ? 'disabled' : '' }}"
                    title="Edit"
                    {{ $row->nama == 'Disinfektan' ? 'aria-disabled=true tabindex=-1' : '' }}>
                        <i class="fas fa-edit"></i>
                    </a>
                    @endcan

                    @can('Hapus Jenis Treatment')
                   <form action="{{ route('master-data.jenis-treatment.destroy', $row->id) }}"
                        method="post"
                        data-nama="{{ $row->nama }}"
                        class="form-delete">
                        @csrf
                        @method('delete')
                        <button type="submit"
                                class="btn btn-sm btn-danger {{ $row->nama == 'Disinfektan' ? 'disabled' : '' }}"
                                title="Hapus"
                                {{ $row->nama == 'Disinfektan' ? 'aria-disabled=true tabindex=-1' : '' }}
                                {{ $row->nama == 'Disinfektan' ? 'disabled' : '' }}>
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>

                    @endcan

                </div>
            </td>
        </tr>
            @empty
                <tr>
                    <td colspan="3" class="text-center text-muted py-3">
                        Tidak ada data treatment ditemukan.
                    </td>
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
@push('js')
<script>
    $(document).on('submit', '.form-delete', function(e) {
        e.preventDefault(); 
        let form = $(this);
        let nama = form.data('nama');
        Swal.fire({
            title: 'Hapus Data?',
            text: "Yakin ingin menghapus disinfectan '" + nama + "'?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Hapus',
            cancelButtonText: 'Batal'
        }).then((result) => {
              if (result.value) {
                    this.submit();
                }
        });
    });
</script>
@endpush

@endsection