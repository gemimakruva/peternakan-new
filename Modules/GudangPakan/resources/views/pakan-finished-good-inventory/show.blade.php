@extends('layouts.dashboard')

@section('title', 'Detail Inventory Pakan Jadi')

@section('content_header')
    <x-page-header title="Detail Inventory Pakan Jadi" :breadcrumbs="['Inventory Pakan Jadi' => route('gudang-pakan.pakan-finished-good-inventory.index'), 'Detail' => '']" />
@endsection

@section('content')
<div class="mx-900">
    <x-form-alert />

    <div class="card">
        <div class="card-body">
            <table>
                <tbody>
                    <tr>
                        <td>Nama Pakan</td>
                        <td>: {{ $data->nama }}</td>
                    </tr>
                    <tr>
                        <td>Satuan</td>
                        <td>: Kg</td>
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
                    </tr>
                </thead>
                <tbody>
                    @forelse($datas as $data)
                        <tr>
                            <td>{{ ($datas->currentPage() - 1) * $datas->perPage() + $loop->iteration }}</td>
                            <td class="text-left">{{ $data->tanggal->translatedFormat('l, d F Y') }}</td>
                            <td class="text-right">{{ $data->tipe->value == 'masuk'  ? $data->jumlah : 0 }}</td>
                            <td class="text-right">{{ $data->tipe->value == 'keluar' ? $data->jumlah : 0 }}</td>
                            <td class="text-right">{{ $data->tipe->value == 'opname' ? $data->jumlah : 0 }}</td>
                            <td class="text-right">{{ $data->saldo }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Data Inventory Pre-Mixing tidak tersedia</td>
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
            <x-mobile-card title="{{ $data->tanggal->translatedFormat('l, d F Y') }}" badge="{{ $data->tipe->value }}" badgeClass="badge-{{ $data->tipe->value == 'masuk' ? 'success' : ($data->tipe->value == 'keluar' ? 'danger' : 'warning') }}">
                <div class="data-row">
                    <span class="data-label">Masuk</span>
                    <span class="data-value">{{ $data->tipe->value == 'masuk' ? $data->jumlah : 0 }}</span>
                </div>
                <div class="data-row">
                    <span class="data-label">Keluar</span>
                    <span class="data-value">{{ $data->tipe->value == 'keluar' ? $data->jumlah : 0 }}</span>
                </div>
                <div class="data-row">
                    <span class="data-label">Opname</span>
                    <span class="data-value">{{ $data->tipe->value == 'opname' ? $data->jumlah : 0 }}</span>
                </div>
                <div class="data-row">
                    <span class="data-label">Saldo</span>
                    <span class="data-value">{{ $data->saldo }}</span>
                </div>
            </x-mobile-card>
        @empty
            <p class="text-center text-muted">Data Inventory Pre-Mixing tidak tersedia</p>
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
