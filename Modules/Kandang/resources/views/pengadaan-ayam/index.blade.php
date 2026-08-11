@extends('layouts.dashboard')

@section('title', 'Pengadaan Ayam')

@section('content_header')
    <x-page-header title="Pengadaan Ayam" :breadcrumbs="['Pengadaan Ayam' => '']">
        <x-slot name="actions">
            <a href="{{ route('pengadaan-ayam.create') }}" class="btn btn-primary">Tambah Pengadaan Ayam</a>
        </x-slot>
    </x-page-header>
@stop

@section('content')
    <div class="mx-1400">
        <x-form-alert />

        <x-filter-panel :action="route('pengadaan-ayam.index')" :resetUrl="route('pengadaan-ayam.index')">
            <div class="col-12 col-md-4">
                <label class="form-label" for="tanggal">Tanggal</label>
                <input type="date" name="tanggal" class="form-control" value="{{ request()->query('tanggal') }}">
            </div>
            <div class="col-12 col-md-4">
                <input
                    type="search"
                    name="search"
                    class="form-control"
                    value="{{ request()->query('search') }}"
                    placeholder="Nama Pencatat ..."
                />
            </div>
        </x-filter-panel>

        <div class="card desktop-table d-none d-md-block">
            <div class="card-body table-responsive p-0">
                <table class="table table-bordered table-striped">
                    <thead class="text-center">
                        <tr>
                            <th class="align-middle" style="width:40px">#</th>
                            <th class="align-middle" style="width:200px">Tanggal</th>
                            <th class="align-middle" style="width:160px">Nama Kandang</th>
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
                                <td class="text-left">{{ $item->kandang->nama }}</td>
                                <td class="text-left">{{ $item->picUser->name ?? '-' }}</td>
                                <td class="text-left">{{ $item->umur_ayam }} Minggu</td>
                                <td class="text-left">{{ $item->kondisi_ayam }}</td>
                                <td class="text-right">{{ format_angka($item->jumlah_ayam_datang) }}</td>
                                <td class="text-right">{{ format_angka($item->jumlah_ayam_mati) }}</td>
                                <td class="text-right">{{ format_angka($item->jumlah_ayam_sakit) }}</td>
                                <td class="text-right">{{ format_angka($item->jumlah_ayam_masuk_kandang) }}</td>
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

                                        @if (!$item->is_has_populasi)
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
                                        @endif
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
            </div>
        </div>

        <div class="mobile-card-list d-md-none">
            @forelse ($listPengadaanAyam as $item)
                <x-mobile-card
                    :title="$item->kandang->nama"
                    :subtitle="$item->tanggal->translatedFormat('d M Y') . ' — ' . ($item->picUser->name ?? '-')"
                >
                    <div class="data-row">
                        <span class="data-label">Umur Ayam</span>
                        <span class="data-value">{{ $item->umur_ayam }} Minggu</span>
                    </div>
                    <div class="data-row">
                        <span class="data-label">Kondisi</span>
                        <span class="data-value">{{ $item->kondisi_ayam }}</span>
                    </div>
                    <div class="data-row">
                        <span class="data-label">Ayam Datang</span>
                        <span class="data-value">{{ format_angka($item->jumlah_ayam_datang) }}</span>
                    </div>
                    <div class="data-row">
                        <span class="data-label">Ayam Mati</span>
                        <span class="data-value">{{ format_angka($item->jumlah_ayam_mati) }}</span>
                    </div>
                    <div class="data-row">
                        <span class="data-label">Ayam Sakit</span>
                        <span class="data-value">{{ format_angka($item->jumlah_ayam_sakit) }}</span>
                    </div>
                    <div class="data-row">
                        <span class="data-label">Masuk Kandang</span>
                        <span class="data-value">{{ format_angka($item->jumlah_ayam_masuk_kandang) }}</span>
                    </div>
                    <x-slot name="actions">
                        @if ($item->catatan)
                            <button class="btn btn-sm btn-secondary btn-catatan" data-catatan="{{ $item->catatan }}">
                                <i class="fas fa-sticky-note"></i>
                            </button>
                        @endif
                        <a href="{{ route('pengadaan-ayam.show', $item->id) }}" class="btn btn-info btn-sm text-white">
                            <i class="fas fa-eye"></i> Detail
                        </a>
                        <a href="{{ route('pengadaan-ayam.edit', $item->id) }}" class="btn btn-warning btn-sm text-white">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        @if (!$item->is_has_populasi)
                            <form
                                action="{{ route('pengadaan-ayam.destroy', $item) }}"
                                method="POST"
                                class="d-inline form-delete"
                                data-tanggal="tanggal {{ $item->tanggal->translatedFormat('l, d F Y') }}"
                            >
                                @csrf
                                @method('delete')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        @endif
                    </x-slot>
                </x-mobile-card>
            @empty
                <x-empty-state icon="chicken" title="Belum Ada Data" description="Belum ada data pengadaan ayam." />
            @endforelse
        </div>

        @if ($listPengadaanAyam->hasPages())
            <div class="d-flex justify-content-end mt-3">
                {{ $listPengadaanAyam->links() }}
            </div>
        @endif
    </div>

<script>
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
                icon: "warning",
                confirmButtonColor: "var(--danger)",
                cancelButtonColor: "var(--secondary)",
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
