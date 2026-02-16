@extends('layouts.dashboard')

@section('title', 'Rekapan Pakan Harian')

@section('content_header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Rekapan Pakan Harian</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item active">Pemberian Pakan</li>
                <li class="breadcrumb-item active">Rekapan Pakan Harian</li>
            </ol>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="mx-1200">

    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Filter</h2>
        </div>
        <div class="card-body">
            <form action="{{ route('overview-pakan-harian') }}" method="get" class="d-flex gap-2">
                <x-adminlte-select
                    name="kandang_id"
                    fgroup-class="mb-0 mx-200"
                >
                    <x-adminlte-options
                        :options="$listKandang"
                        empty-option="Semua Kandang"
                        :selected="request()->query('kandang_id')"
                    />
                </x-adminlte-select>

                <x-adminlte-button type="submit" theme="primary" icon="fas fa-search" />

                <a href="{{ route('overview-pakan-harian') }}" class="btn btn-secondary">
                    <i class="fas fa-undo"></i>
                </a>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body table-responsive p-0">
            <table class="table table-hover table-striped table-bordered text-center mb-0">
                <thead>
                    <tr>
                        <th class="align-middle" style="width: 40px;">#</th>
                        <x-sort-th class="align-middle" style="min-width: 180px;" label="Kandang" name="nama_kandang" />
                        <x-sort-th class="align-middle" style="min-width: 200px;" label="Tanggal" name="tanggal_pemberian_pakan" />
                        <x-sort-th class="align-middle" style="min-width: 80px;" label="Umur Ayam" name="umur_ayam" />
                        <x-sort-th class="align-middle" style="min-width: 80px;" label="Jumlah Ayam" name="jumlah_ayam" />
                        <x-sort-th class="align-middle" style="min-width: 80px;" label="Pemberian" name="pemberian_kg" />
                        <x-sort-th class="align-middle" style="min-width: 80px;" label="Sisa" name="sisa_kg" />
                        <x-sort-th class="align-middle" style="min-width: 80px;" label="Konsumsi" name="feed_intake_kg" />
                        <x-sort-th class="align-middle" style="min-width: 80px;" label="Konsumsi per Ekor (realisasi)" name="feed_intake_per_ekor" />
                        <x-sort-th class="align-middle" style="min-width: 80px;" label="Konsumsi per Ekor (standar)" name="feed_intake_per_ekor_standar" />
                        <th class="align-middle" style="min-width: 80px;">Konsumsi per Kandang (realisasi)</th>
                        <th class="align-middle" style="min-width: 80px;">Konsumsi per Kandang (standar)</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($datas as $data)
                        <tr>
                            <td>{{ ($datas->currentPage() - 1) * $datas->perPage() + $loop->iteration }}</td>
                            <td class="text-left">{{ $data->nama_kandang }}</td>
                            <td class="text-left">{{ $data->tanggal_pemberian_pakan->translatedFormat('l, d F Y') }}</td>
                            <td class="text-right">{{ format_angka($data->umur_ayam) }}</td>
                            <td class="text-right">{{ format_angka($data->jumlah_ayam) }}</td>
                            <td class="text-right">{{ format_angka($data->pemberian_kg) }}</td>
                            <td class="text-right">{{ format_angka($data->sisa_kg) }}</td>
                            <td class="text-right">{{ format_angka($data->feed_intake_kg) }}</td>
                            <td class="text-right">{{ format_angka($data->feed_intake_per_ekor) }}</td>
                            <td class="text-right">{{ format_angka($data->feed_intake_per_ekor_standar) }}</td>
                            <td class="text-right">{{ format_angka(($data->feed_intake_per_ekor * $data->jumlah_ayam)/1000) }}</td>
                            <td class="text-right">{{ format_angka(($data->feed_intake_per_ekor_standar * $data->jumlah_ayam)/1000) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3">Data rekapan pakan harian tidak ditemukan.</td>
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