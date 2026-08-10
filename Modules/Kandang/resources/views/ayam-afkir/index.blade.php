@extends('layouts.dashboard')

@section('title', 'Ayam Afkir')

@section('content_header')
    <x-page-header title="Ayam Afkir" :breadcrumbs="['Ayam Afkir' => '']" />
@endsection


@section('content')

    <div class="mx-1200">
        <x-form-alert />

        <x-filter-panel action="{{ route('ayam-afkir.index') }}" resetUrl="{{ route('ayam-afkir.index') }}">
            <div class="col-12 col-md-4">
                <x-adminlte-select
                    name="kandang_id"
                    fgroup-class="w-100 mb-0"
                >
                    <x-adminlte-options
                        :options="$listKandang"
                        :selected="request()->query('kandang_id')"
                        empty-option="Semua Kandang"
                    />
                </x-adminlte-select>
            </div>

            <div class="col-12 col-md-4">
                <input
                    type="search"
                    name="search"
                    class="form-control"
                    placeholder="Kandang, PIC, Pembeli ..."
                    value="{{ request()->query('search') }}"
                >
            </div>
        </x-filter-panel>

        <div class="card desktop-table d-none d-md-block">
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
                                        <a href="{{ route('ayam-afkir.edit', $afkir->id) }}" class="btn btn-sm btn-warning text-white">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center">Data Ayam Afkir tidak tersedia</td>
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

        <div class="mobile-card-list d-md-none">
            @forelse($listAyamAfkir as $index => $afkir)
                <x-mobile-card
                    title="{{ $afkir->nama_kandang }}"
                    subtitle="{{ $afkir->tanggal->translatedFormat('d M Y') }}"
                >
                    <div class="data-row">
                        <span class="data-label">Umur Ayam</span>
                        <span class="data-value">{{ $afkir->umur_ayam }} minggu</span>
                    </div>
                    <div class="data-row">
                        <span class="data-label">Jumlah Afkir</span>
                        <span class="data-value">{{ format_angka($afkir->total_jumlah_ayam_afkir) }}</span>
                    </div>
                    <div class="data-row">
                        <span class="data-label">PIC</span>
                        <span class="data-value">{{ $afkir->nama_pic_user ?? '-' }}</span>
                    </div>
                    <div class="data-row">
                        <span class="data-label">Pembeli</span>
                        <span class="data-value">{{ $afkir->pembeli_afkir ?? '-' }}</span>
                    </div>
                    <div class="data-row">
                        <span class="data-label">Harga (per kg)</span>
                        <span class="data-value">{{ format_uang($afkir->harga_jual) ?? '-' }}</span>
                    </div>
                    <x-slot name="actions">
                        <a href="{{ route('ayam-afkir.edit', $afkir->id) }}" class="btn btn-warning btn-sm text-white">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                    </x-slot>
                </x-mobile-card>
            @empty
                <div class="text-center text-muted p-4">Data Ayam Afkir tidak tersedia.</div>
            @endforelse

            @if ($listAyamAfkir->hasPages())
                <div class="d-flex justify-content-end mt-3">
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
