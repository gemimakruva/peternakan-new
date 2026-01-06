@extends('layouts.dashboard')

@section('title', 'Pengadaan Ayam')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <div class="d-flex align-items-center gap-1">
                    <h1>Pengadaan Ayam</h1>
                    <a href="{{ route('pengadaan-ayam.create') }}" class="btn btn-primary">Tambah Pengadaan Ayam</a>
                </div>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item active">Pengadaan Ayam</li>
                </ol>
            </div>
        </div>
    </div>
@stop

@section('content')
    <div class="mx-1200">
        <x-form-alert />

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Filter</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('pengadaan-ayam.index') }}" class="d-flex gap-3 align-items-end">
                    <div class="w-200-px">
                        <label class="form-label" for="tanggal">Tanggal</label>
                        <input type="date" name="tanggal"  class="form-control" value="{{ request()->query('tanggal') }}">
                    </div>

                    <input type="search" name="search" class="form-control w-200-px" value="{{ request()->query('search') }}" placeholder="Nama Pencatat ...">
                    
                    <div class="d-flex gap-1">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i>
                        </button>
                        <a href="{{ route('pengadaan-ayam.index') }}" class="btn btn-secondary">
                            <i class="fas fa-undo"></i>
                        </a>
                    </div>
                </form>
            </div>
        </div>
        
        <div class="card">
            <div class="card-body table-responsive p-0">
                <table class="table table-bordered table-striped">
                    <thead class="text-center">
                        <tr>
                            <th class="align-middle" style="width:40px">#</th>
                            <th class="align-middle" style="width:400px">Tanggal</th>
                            <th class="align-middle" style="width:160px">Nama Pencatat</th>
                            <th class="align-middle" style="width:150px">Umur Ayam</th>
                            <th class="align-middle" style="width:100px">Kondisi Ayam</th>
                            <th class="align-middle" style="width:110px">Ayam Datang</th>
                            <th class="align-middle" style="width:110px">Ayam Mati</th>
                            <th class="align-middle" style="width:110px">Ayam Sakit</th>
                            <th class="align-middle" style="width:150px">Masuk Kandang</th>
                            <th class="align-middle" style="width:100px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($listPengadaanAyam as $item)
                            <tr>
                                <td class="text-left">{{ $loop->iteration }}</td>
                                <td class="text-left">{{ $item->tanggal->translatedFormat('l, d F Y') }}</td>
                                <td class="text-left">{{ $item->picUser->name ?? '-' }}</td>
                                <td class="text-left">{{ $item->umur_ayam }} Minggu</td>
                                <td class="text-left">{{ $item->kondisi_ayam }}</td>
                                <td class="text-right">{{ number_format($item->jumlah_ayam_datang) }}</td>
                                <td class="text-right">{{ number_format($item->jumlah_ayam_mati) }}</td>
                                <td class="text-right">{{ number_format($item->jumlah_ayam_sakit) }}</td>
                                <td class="text-right">{{ number_format($item->jumlah_ayam_masuk_kandang) }}</td>
                                <td class="text-center">
                                    <div class="d-flex gap-2" role="group">
                                        @if ($item->catatan)
                                            <button class="btn btn-sm btn-secondary btn-catatan" data-catatan="{{ $item->catatan }}" title="Catatan">
                                                <i class="fas fa-sticky-note"></i>
                                            </button>
                                        @endif

                                        <a href="{{ route('pengadaan-ayam.show', $item->id) }}" class="btn btn-info btn-sm" title="Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
            
                                        <a href="{{ route('pengadaan-ayam.edit', $item->id) }}" class="btn btn-warning btn-sm text-white" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
            
                                    <form
                                            action="{{ route('pengadaan-ayam.destroy', $item) }}"
                                            method="POST"
                                            class="d-inline form-delete"
                                            data-tanggal="tanggal {{ $item->tanggal->translatedFormat('l, d F Y') }}"
                                        >
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
                                    Belum ada data Pengadaan Ayam.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                @if ($listPengadaanAyam->hasPages())
                    <div class="d-flex justify-content-end mt-3">
                        {{ $listPengadaanAyam->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

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
