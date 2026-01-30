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
            <div class="card-header text-white d-flex justify-content-between align-items-center">
                <form action="{{ route('master-data.kandang.index', request()->all()) }}" method="get" class="w-100">
                    <div class="d-flex justify-content-end">
                        <div class="d-flex gap-2">
                            <input 
                                type="search" 
                                name="search" 
                                class="form-control" 
                                placeholder="Kandang, PIC, Pembeli ..."
                                value="{{ request()->query('search') }}"
                            >

                            <button class="btn btn-primary" title="Cari">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="card-body table-responsive p-0">
                <table class="table table-hover table-striped table-bordered text-center mb-0">

                    <thead>
                        <tr>
                            <th class="align-middle" style="width: 40px;">#</th>
                            <th class="align-middle" style="width: 150px;">Kandang</th>
                            <th class="align-middle" style="width: 100px;">Tanggal</th>
                            <th class="align-middle" style="width: 100px;">Umur Ayam (mingguan)</th>
                            <th class="align-middle" style="width: 100px;">Jumlah Ayam Afkir</th>
                            <th class="align-middle" style="width: 150px;">PIC</th>
                            <th class="align-middle" style="width: 150px;">Pembeli</th>
                            <th class="align-middle" style="width: 150px;">Harga (per kg)</th>
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

                                        <a href="{{ route('ayam-afkir.edit', $afkir->id) }}" class="btn btn-sm btn-warning">
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

