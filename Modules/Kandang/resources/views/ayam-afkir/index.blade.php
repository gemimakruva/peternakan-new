@extends('adminlte::page')

@section('title', 'Transaksi Ayam Afkir')

@section('content_header')
<div class="mb-4 text-center d-flex flex-column align-items-center">
    <h2 class="h4 fw-bold text-dark">List Ayam Afkir</h2>
    <span class="text-muted mb-0" style="max-width: 600px;">
        Halaman ini digunakan untuk Menampilkan daftar pembelian ayam afkir
    </span>
</div>
@endsection


@section('content')
<div>
    <div>
    <x-form-alert />
    <div style="max-width: 1200px" class="card shadow-sm">
        <div class="card-header text-white d-flex justify-content-between
         align-items-center"
             style="background-color: #495057; border-color: #495057;">
            <form action="{{ route('master-data.kandang.index', request()->all()) }}" 
                  method="get" 
                  class="w-100">
                <div class="d-flex justify-content-between align-items-center">
                    <h2 class="card-title mb-0">Transaksi Ayam Afkir</h2>
                    <div class="d-flex" style="gap: .5em">
                        <input 
                            type="search" 
                            name="search" 
                            class="form-control form-control-sm" 
                            placeholder="Kandang atau Flock"
                            value="{{ request()->query('search') }}"
                        >

                        <button class="btn btn-dark btn-sm" title="Cari">
                            <i class="fas fa-search"></i>
                        </button>

                        @can('Tambah Ayam Akfir')
                        <a href="{{ route('ayam-afkir.create') }}" 
                           class="btn btn-light btn-sm text-dark" 
                           title="Tambah Transaksi">
                            <i class="fas fa-plus"></i>
                        </a>
                        @endcan

                    </div>

                </div>

            </form>
        </div>


        <div class="card-body table-responsive p-0">
            <table class="table table-hover table-striped table-bordered 
            text-center mb-0">
                {{-- Column Headers --}}
                <thead class="bg-light">
                   <tr>
                        <th style="width: 50px;">#</th>
                        <th>Tanggal Penjualan</th>
                        <th>Umur Ayam (mingguan)</th>
                        <th>Jumlah Ayam Afkir</th>
                        <th>Penyebab</th>
                        <th>Pembeli</th>
                        <th>Harga (kg)</th>
                        <th>Identitas Populasi</th>
                        <th style="width: 180px;">Aksi</th>
                   </tr>
                </thead>
                <tbody>
                    @forelse($listAyamAfkir as $index => $afkir)
                        <tr>
                            <td>{{ $listAyamAfkir->firstItem() + $index }}</td>
                            <td>{{ \Carbon\Carbon::parse($afkir->tanggal)
                                ->translatedFormat('l, d F Y') }}</td>
                            <td>{{ $afkir->umur_ayam }}</td>
                            <td>{{ $afkir->jumlah_ayam_afkir }}</td>
                            <td>{{ $afkir->penyebab_afkir }}</td>
                            <td>{{ $afkir->pembeli_afkir ?? '-' }}</td>
                            <td>{{ isset($afkir->harga_jual) ? 
                            number_format($afkir->harga_jual,
                             0, ',', '.') : '-' }}
                            </td>
                            <td>
                            <button type="button" 
                                    class="btn btn-sm btn-info btn-populasi" 
                                    data-kandang="{{ $afkir->populasi->kandang->nama ?? '-' }}"
                                    data-flock="{{ $afkir->populasi->flock->nama ?? '-' }}"
                                    data-pipe="{{ $afkir->populasi->pipe->nama ?? '-' }}">
                                <i class="fas fa-info-circle"></i> Info Populasi
                            </button>
                            </td>
                            <td>
                                <div class="d-flex justify-content-center gap-1">
                                    <!-- Tombol Edit -->
                                    <a href="{{ route('ayam-afkir.edit', $afkir->id) }}" 
                                    class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <!-- Tombol Hapus -->
                                    <form action="{{ route('ayam-afkir.destroy', $afkir->id) }}" 
                                        method="POST" 
                                        class="delete-form m-0"
                                        data-tanggal="{{ \Carbon\Carbon::parse($afkir->tanggal)
                                        ->format('d-m-Y') }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>  
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
         <div class="card-footer d-flex justify-content-end">
            {{ $listAyamAfkir->links('components.pagination') }}
        </div>

    </div>
</div>
</div>
@endsection
@push('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#6c757d",
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
                        <ul style="list-style:none; padding:0; text-align:center; 
                        line-height:1.6;">
                            <li><strong>Kandang:</strong> ${kandang}</li>
                            <li><strong>Flock:</strong> ${flock}</li>
                            <li><strong>Pipe:</strong> ${pipe}</li>
                        </ul>
                    `,
                    icon: 'info',
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Tutup'
                });
            });
    });

    });
    </script>
@endpush

