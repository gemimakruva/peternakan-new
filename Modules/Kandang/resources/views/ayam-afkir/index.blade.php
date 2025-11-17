@extends('adminlte::page')

@section('title', 'Transaksi Ayam Afkir')

@section('content_header')
    <h1 class="font-weight-bold">List Transaksi Ayam Afkir</h1>
@endsection

@section('content')
<div>
    <x-form-alert />
    <div class="card shadow-sm">
        <div class="card-header text-white d-flex justify-content-between align-items-center"
             style="background-color: #495057; border-color: #495057;">
            <form action="{{ route('master-data.kandang.index', request()->all()) }}" method="get" class="w-100">
                <div class="d-flex justify-content-between align-items-center">
                    <h2 class="card-title mb-0">Transaksi Ayam Afkir</h2>

                    <div class="d-flex" style="gap: .5em">
                        <input type="search" 
                               name="search" 
                               class="form-control form-control-sm" 
                               placeholder="Kandang atau Flock" 
                               value="{{ request()->query('search') }}">
                        <button class="btn btn-dark btn-sm" title="Cari">
                            <i class="fas fa-search"></i>
                        </button>

                        @can('Tambah Flock')
                        <a href="{{ route("ayam-afkir.create") }}" class="btn btn-light btn-sm text-dark" title="Tambah Transaksi">
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
                        <th>Tanggal Afkir</th>
                        <th>Nama Flock</th>
                        <th>Nama Kandang</th>
                        <th>Umur Ayam</th>
                        <th>Jumlah Afkir</th>
                        <th>Penyebab Afkir</th>
                        <th>Nama Pembeli</th>
                        <th>Harga Jual (kg)</th>
                        <th style="width: 180px;">Aksi</th>
                   </tr>
                </thead>
                   <tbody>
                        @php
                            // DATA DUMMY SEMENTARA
                            $datas = collect([
                                (object)[
                                    'id' => 1,
                                    'tanggal_afkir' => '2025-02-10',
                                    'flock_name' => 'Flock A',
                                    'kandang_name' => 'Kandang 1',
                                    'umur_ayam' => 12,
                                    'jumlah_ayam_afkir' => 50,
                                    'penyebab_afkir' => 'Cacat tumbuh',
                                    'nama_pembeli' => 'Pak Budi',
                                    'harga_jual_per_kg' => 18000
                                ],
                                (object)[
                                    'id' => 2,
                                    'tanggal_afkir' => '2025-02-12',
                                    'flock_name' => 'Flock B',
                                    'kandang_name' => 'Kandang 3',
                                    'umur_ayam' => 13,
                                    'jumlah_ayam_afkir' => 70,
                                    'penyebab_afkir' => 'Ayam stres',
                                    'nama_pembeli' => 'Bu Sari',
                                    'harga_jual_per_kg' => 17500
                                ],
                                (object)[
                                    'id' => 3,
                                    'tanggal_afkir' => '2025-02-14',
                                    'flock_name' => 'Flock C',
                                    'kandang_name' => 'Kandang 2',
                                    'umur_ayam' => 14,
                                    'jumlah_ayam_afkir' => 40,
                                    'penyebab_afkir' => '-',
                                    'nama_pembeli' => 'Pak Darto',
                                    'harga_jual_per_kg' => 18500
                                ],
                            ]);
                        @endphp

                        @foreach ($datas as $row)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ \Carbon\Carbon::parse($row->tanggal_afkir)->format('d M Y') }}</td>
                            <td>{{ $row->flock_name }}</td>
                            <td>{{ $row->kandang_name }}</td>
                            <td>{{ $row->umur_ayam }} Minggu</td>
                            <td>{{ $row->jumlah_ayam_afkir }}</td>
                            <td>{{ $row->penyebab_afkir }}</td>
                            <td>{{ $row->nama_pembeli }}</td>
                            <td>Rp {{ number_format($row->harga_jual_per_kg, 0, ',', '.') }}</td>
                            <td>
                                <div class="btn-group">
                                  <a href="{{ route('ayam-afkir.edit', $row->id) }}" 
                                class="btn btn-primary btn-sm" 
                                title="Edit Transaksi">
                                    <i class="fas fa-edit"></i>
                                </a>
                                 <form action="#" 
                                    method="post" 
                                    class="form-delete d-inline"
                                    data-tanggal="{{ \Carbon\Carbon::parse($row->tanggal_afkir)->format('d M Y') }}">
                                        @csrf
                                        @method('delete')
                                        <button class="btn btn-danger btn-sm">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
            </table>
        </div>

        {{-- Paginattion  --}}
        {{-- <div class="card-footer d-flex justify-content-end">
            {{ $datas->links('components.pagination') }}
        </div> --}}
    </div>
</div>
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
    $(document).on('submit', '.form-delete', function(e) {
        e.preventDefault();
        const tanggal = $(this).data('tanggal');

        Swal.fire({
            title: `Hapus Transaksi tanggal ${tanggal}?`,
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
