@extends('layouts.dashboard')

@section('title', 'Ayam Afkir')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <div class="d-flex align-items-center gap-1">
                <h1>Ayam Afkir</h1>
            </div>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">  
              <li class="breadcrumb-item active">Ayam Afkir</li>
            </ol>
          </div>
        </div>
    </div>
@endsection


@section('content')

    <div class="mx-1200">
        <x-form-alert />
        <div class="card">
            <div class="card-body">
                <form 
                    action="{{ route('ayam-afkir.index') }}" 
                    class="d-flex gap-3 align-items-end flex-column flex-sm-row""
                >
                    <x-adminlte-select
                        name="kandang_id"
                        fgroup-class="w-100 mb-0 mx-sm-200"
                    >
                        <x-adminlte-options
                            :options="$listKandang"
                            :selected="request()->query('kandang_id')"
                            empty-option="Semua Kandang"
                        />
                    </x-adminlte-select>

                    <input 
                        type="search" 
                        name="search" 
                        class="form-control mx-sm-200" 
                        placeholder="Kandang, PIC, Pembeli ..."
                        value="{{ request()->query('search') }}"
                    >
    
                    <div class="d-flex gap-2">
                        <button class="btn btn-primary">
                            <i class="fas fa-search"></i>
                        </button>
                        <a href="{{ route('ayam-afkir.index') }}" class="btn btn-secondary">
                            <i class="fas fa-undo"></i>
                        </a>                        
                    </div>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-body table-responsive p-0">
                <table class="table table-hover table-striped table-bordered text-center mb-0">

                    <thead>
                        <tr>
                            <th class="align-middle" style="width: 40px;">#</th>
                            <x-sort-th class="align-middle" style="min-width: 150px;" label="Kandang" name="nama_kandang" />
                            <x-sort-th class="align-middle" style="min-width: 200px;" label="Tanggal" name="tanggal" />
                            <x-sort-th class="align-middle" style="min-width: 100px;" label="Umur Ayam (mingguan)" name="umur_ayam" />
                            <x-sort-th class="align-middle" style="min-width: 100px;" label="Jumlah Ayam Afkir" name="total_jumlah_ayam_afkir" />
                            <x-sort-th class="align-middle" style="min-width: 150px;" label="PIC" name="nama_pic_user" />
                            <x-sort-th class="align-middle" style="min-width: 150px;" label="Pembeli" name="pembeli_afkir" />
                            <x-sort-th class="align-middle" style="min-width: 150px;" label="Harga (per kg)" name="harga_jual" />
                            <th class="align-middle" style="width: 40px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($listAyamAfkir as $index => $afkir)
                            <tr>
                                <td>{{ ($listAyamAfkir->currentPage() - 1) * $listAyamAfkir->perPage() + $loop->iteration }}</td>
                                <td class="text-left">{{ $afkir->nama_kandang }}</td>
                                <td class="text-left">{{ $afkir->tanggal->translatedFormat('l, d F Y') }}</td>
                                <td class="text-right">{{ $afkir->umur_ayam }}</td>
                                <td class="text-right">{{ format_angka($afkir->total_jumlah_ayam_afkir) }}</td>
                                <td class="text-left">{{ $afkir->nama_pic_user ?? '-' }}</td>
                                <td class="text-left">{{ $afkir->pembeli_afkir ?? '-' }}</td>
                                <td class="text-right">{{ format_uang($afkir->harga_jual) ?? '-' }}</td>
                                <td>
                                    <div class="d-flex justify-content-center gap-2">
                                        {{-- <button 
                                            type="button" 
                                            class="btn btn-sm btn-info btn-populasi" 
                                            data-kandang="{{ $afkir->populasi->pipe->flock->kandang->nama ?? '-' }}"
                                            data-flock="{{ $afkir->populasi->pipe->flock->nama ?? '-' }}"
                                            data-pipe="{{ $afkir->populasi->pipe->nama ?? '-' }}"
                                        >
                                            <i class="fas fa-info-circle"></i>
                                        </button> --}}

                                        <a href="{{ route('ayam-afkir.edit', $afkir->id) }}" class="btn btn-sm btn-warning text-white">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">Data Ayam Afkir tidak tersedia</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($listAyamAfkir->hasPages())
                <div class="card-footer d-flex justify-content-end">
                    {{ $listAyamAfkir->links('components.pagination') }}
                </div>
            @endif
        </div>
    </div>
@endsection

@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.delete-form').forEach(function(form) {
                form.addEventListener('submit', function(e) {
                    e.preventDefault(); 

                    const tanggal = this.dataset.tanggal || 'data ini';
                    const currentForm = this;

                    Swal.fire({
                        title: "Hapus Data?",
                        text: "Data tanggal " + tanggal + " akan dihapus permanen!",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "var(--danger)",
                        cancelButtonColor: "var(--secondary)",
                        confirmButtonText: "Ya, hapus!",
                        cancelButtonText: "Batal"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            currentForm.submit(); 
                        }
                    });
                });
            });

            document.querySelectorAll('.btn-populasi').forEach(function(button) {
                button.addEventListener('click', function() {
                    const kandang = this.dataset.kandang;
                    const flock = this.dataset.flock;
                    const pipe = this.dataset.pipe;

                    Swal.fire({
                        title: 'Detail Populasi Ayam',
                        html: `
                            <ul style="list-style:none; padding:0; text-align:left; line-height:1.6;">
                                <li><strong>Kandang:</strong> ${kandang}</li>
                                <li><strong>Flock:</strong> ${flock}</li>
                                <li><strong>Pipe:</strong> ${pipe}</li>
                            </ul>
                        `,
                        icon: 'info',
                        confirmButtonColor: 'var(--info)',
                        confirmButtonText: 'Tutup'
                    });
                });
            });
        });
    </script>
@endpush

