@extends('layouts.dashboard')

@section('title', 'Detail Inventory Pakan Jadi')

@section('content_header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Detail Inventory Pakan Jadi</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">  
                <li class="breadcrumb-item"><a href="{{ route('gudang-pakan.pakan-finished-good-inventory.index') }}">Inventory Pakan Jadi</a></li>
                <li class="breadcrumb-item active">Detail</li>
            </ol>
        </div>
    </div>
</div>
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

    <div class="card">
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
