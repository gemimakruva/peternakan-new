@extends('layouts.dashboard')

@section('title', 'Inventory Bahan Pakan')

@section('content_header')
    <x-page-header title="Inventory Bahan Pakan" :breadcrumbs="['Inventory Bahan Pakan' => route('gudang-pakan.bahan-pakan-inventory.index'), 'Detail' => '']" />
@endsection


@section('content')
<div class="mx-1200">
    <x-form-alert />

    <div class="card">
        <div class="card-body">
            <table>
                <tbody>
                    <tr>
                        <td>Nama Bahan Pakan</td>
                        <td>: {{ $data->nama }}</td>
                    </tr>
                    <tr>
                        <td>Satuan</td>
                        <td>: {{ $data->satuan->nama }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="card desktop-table d-none d-md-block">
        <div class="card-body table-responsive p-0">
            <table class="table table-hover table-striped table-bordered text-center mb-0">
                <thead>
                    <tr>
                        <th class="align-middle" style="width: 40px;">#</th>
                        <th class="align-middle" style="width: 200px;">Tanggal</th>
                        <th class="align-middle" style="width: 100px;">Masuk</th>
                        <th class="align-middle" style="width: 100px;">Keluar</th>
                        <th class="align-middle" style="width: 100px;">Opname</th>
                        <th class="align-middle" style="width: 100px;">Saldo</th>
                        <th class="align-middle" style="width: 100px;">Harga</th>
                        <th class="align-middle" style="width: 100px;" title="Moving Weighted Average">MWA</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($datas as $data)
                        <tr>
                            <td>{{ ($datas->currentPage() - 1) * $datas->perPage() + $loop->iteration }}</td>
                            <td class="text-left">{{ $data->tanggal->translatedFormat('l, d F Y') }}</td>
                            <td class="text-right">{{ $data->tipe == 'masuk'  ? $data->jumlah : 0 }}</td>
                            <td class="text-right">{{ $data->tipe == 'keluar' ? $data->jumlah : 0 }}</td>
                            <td class="text-right">{{ $data->tipe == 'opname' ? $data->jumlah : 0 }}</td>
                            <td class="text-right">{{ $data->saldo }}</td>
                            <td class="text-right">{{ format_angka($data->harga_satuan) }}</td>
                            <td class="text-right">{{ format_angka($data->mwa) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">Data Inventory Bahan Pakan tidak tersedia</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($datas->hasPages())
            <div class="card-footer d-flex justify-content-end">
                {{ $datas->links('components.pagination') }}
            </div>
        @endif
    </div>

    <div class="mobile-card-list d-md-none">
        @forelse($datas as $data)
            <x-mobile-card title="{{ $data->tanggal->translatedFormat('d F Y') }}" badge="{{ ucfirst($data->tipe) }}" badgeClass="badge-{{ $data->tipe == 'masuk' ? 'success' : ($data->tipe == 'keluar' ? 'danger' : 'info') }}">
                <div class="data-row">
                    <span class="data-label">Masuk</span>
                    <span class="data-value">{{ $data->tipe == 'masuk' ? $data->jumlah : 0 }}</span>
                </div>
                <div class="data-row">
                    <span class="data-label">Keluar</span>
                    <span class="data-value">{{ $data->tipe == 'keluar' ? $data->jumlah : 0 }}</span>
                </div>
                <div class="data-row">
                    <span class="data-label">Opname</span>
                    <span class="data-value">{{ $data->tipe == 'opname' ? $data->jumlah : 0 }}</span>
                </div>
                <div class="data-row">
                    <span class="data-label">Saldo</span>
                    <span class="data-value">{{ $data->saldo }}</span>
                </div>
                <div class="data-row">
                    <span class="data-label">Harga</span>
                    <span class="data-value">{{ format_angka($data->harga_satuan) }}</span>
                </div>
                <div class="data-row">
                    <span class="data-label">MWA</span>
                    <span class="data-value">{{ format_angka($data->mwa) }}</span>
                </div>
            </x-mobile-card>
        @empty
            <p class="text-center text-muted">Data Inventory Bahan Pakan tidak tersedia</p>
        @endforelse
        @if ($datas->hasPages())
            <div class="d-flex justify-content-end mt-3">
                {{ $datas->links('components.pagination') }}
            </div>
        @endif
    </div>
</div>
@endsection

@push('js')
    <script>
        $(document).on('submit', '.form-delete', function (e) {
            e.preventDefault();
            const tanggal = $(this).data('tanggal');

            Swal.fire({
                title: `Hapus Pembelian Bahan Pakan "${tanggal}"?`,
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
