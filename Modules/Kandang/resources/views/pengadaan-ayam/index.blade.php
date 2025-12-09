@extends('layouts.dashboard')

@section('title', 'Pencatatan Ayam Masuk')

@section('content_header')
<div class="mb-4 text-center d-flex flex-column align-items-center pt-3" style="max-width: 1200px;">
    <h2 class="h4 fw-bold text-dark">Pengadaan Ayam</h2>
    <span class="text-muted mb-0" style="max-width: 600px;">
        Halaman untuk menampilkan data pencatatan ayam masuk ke kandang.
</div>
@stop

@section('content')
<x-form-alert />
<div class="card" style="max-width:1200px">
    <div class="card-header">
        <h3 class="card-title">Filter Data Pencatatan</h3>
    </div>

    <div class="card-body">
        <form action="" method="GET" class="row g-2 align-items-end">
            <div class="col-md-3 col-5">
                <label class="form-label">Tanggal Pencatatan</label>
                <input type="date" name="tanggal_penc" value="{{ request('tanggal_penc') }}" class="form-control">
            </div>


            <div class="col-md-3 col-5">
                <label class="form-label">Dicatat Oleh</label>
                <input type="text" name="recorded_by" value="{{ request('recorded_by') }}" class="form-control" placeholder="Nama Pencatat">
            </div>

            <div class="col-md-3 col-2">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </form>
    </div>
</div>

<div class="card mt-3" style="max-width:1200px">
    <div class="card-body table-responsive">
    <table class="table table-bordered table-striped align-middle">
    <thead  class="text-center"   style="background-color: #495057; border-color: #495057; color: white;">
        <tr>
            <th style="width:40px">No</th>
            <th style="width:400px">Tanggal</th>
            <th style="width:160px">Nama Pencatat</th>
            <th style="width:100px">Umur Ayam</th>
            <th style="width:150px">Kondisi Ayam</th>
            <th style="width:110px">Ayam Datang</th>
            <th style="width:110px">Ayam Mati</th>
            <th style="width:110px">Ayam Sakit</th>
            <th style="width:150px">Masuk Kandang</th>
            <th style="width:120px">Catatan</th>
            <th style="width:100px">Aksi</th>
        </tr>
    </thead>
     <tbody>
            @forelse ($ListPengadaanAyam as $item)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td class="text-center">{{ \Carbon\Carbon::parse($item->tanggal)
                    ->translatedFormat('l, d F Y') }}</td>
                    <td>{{ $item->pic_user->name ?? '-' }}</td>
                    <td>{{ $item->umur_ayam }} Minggu</td>
                    <td>{{ $item->kondisi_ayam }}</td>
                    <td class="text-center">{{ number_format($item->jumlah_ayam_datang) }}</td>
                    <td class="text-center">{{ number_format($item->jumlah_ayam_mati) }}</td>
                    <td class="text-center">{{ number_format($item->jumlah_ayam_sakit) }}</td>
                    <td class="text-center">{{ number_format($item->jumlah_ayam_masuk_kandang) }}</td>
                    <td>
                        @if ($item->catatan)
                            <button 
                                class="btn btn-sm btn-secondary btn-catatan" 
                                data-catatan="{{ $item->catatan }}">
                                Lihat
                            </button>
                        @else
                            -
                        @endif
                    </td>
                    <td class="text-center">
                        <div class="btn-group" role="group" style="gap: 6px;">
                            <a href="{{ route('pengadaan-ayam.show', $item->id) }}" 
                               class="btn btn-info btn-sm" title="Detail">
                                <i class="fas fa-eye"></i>
                            </a>

                            <a href="{{ route('pengadaan-ayam.edit', $item->id) }}" 
                               class="btn btn-warning btn-sm text-white" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                           <form action="{{ route('pengadaan-ayam.destroy', $item) }}"
                                method="POST"
                                class="d-inline form-delete"
                                data-tanggal="tanggal {{ \Carbon\Carbon::parse($item->tanggal)
                                 ->translatedFormat('l, d F Y') }}">
                                @csrf
                                @method('delete')
                                <button type="submit" class="btn btn-danger btn-sm" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="11" class="text-center text-muted">
                        Belum ada data pengadaan ayam.
                    </td>
                </tr>
            @endforelse
        </tbody>
</table>


        {{-- Pagination --}}
        <div class="d-flex justify-content-end mt-3">
            {{ $ListPengadaanAyam->links() }}
        </div>
    </div>
</div>
@include('components.snackbar')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
// ============== Show Catatan Button ==================
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.btn-catatan').forEach(btn => {
        btn.addEventListener('click', function () {
            const catatan = this.dataset.catatan;

            Swal.fire({
                title: 'Catatan',
                html: `<p style="text-align:left;">${catatan}</p>`,
                icon: 'info',
                confirmButtonText: 'Tutup',
                width: 500
            });
        });
    });
});

// ============== Delete Confirmation ==================
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.form-delete').forEach(function (form) {
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            let tanggal = this.dataset.tanggal;
            const currentForm = this;
            Swal.fire({
                title: "Hapus Data?",
                text: "Data " + tanggal + " akan dihapus permanen!",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#6c757d",
                confirmButtonText: "Ya, hapus!",
                cancelButtonText: "Batal"
            }).then(function (result) {
                if (result?.value) form.submit();
            });

        });
    });
});
</script>
@stop
