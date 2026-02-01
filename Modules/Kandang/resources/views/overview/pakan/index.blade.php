@extends('layouts.dashboard')

@section('title', 'Overview Pakan Harian')

@section('content_header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Overview Pakan Harian</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item active">Pemberian Pakan</li>
                <li class="breadcrumb-item active">Overview Pakan Harian</li>
            </ol>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="mx-1200">

    <div class="card">
        <div class="card-body table-responsive p-0">
            <table class="table table-hover table-striped table-bordered text-center mb-0">

                <thead>
                    <tr>
                        <th class="align-middle" style="width: 40px;">#</th>
                        <x-sort-th class="align-middle" style="width: 100px;" label="Kandang" name="nama_kandang" />
                        <x-sort-th class="align-middle" style="width: 100px;" label="Tanggal" name="tanggal_pemberian_pakan" />
                        <x-sort-th class="align-middle" style="width: 100px;" label="Umur Ayam" name="umur_ayam" />
                        <x-sort-th class="align-middle" style="width: 100px;" label="Pemberian" name="pemberian_kg" />
                        <x-sort-th class="align-middle" style="width: 100px;" label="Sisa" name="sisa_kg" />
                        <x-sort-th class="align-middle" style="width: 100px;" label="Feed Intake" name="feed_intake_kg" />
                        <x-sort-th class="align-middle" style="width: 100px;" label="Feed Intake per Ekor (realisasi)" name="feed_intake_per_ekor" />
                        <x-sort-th class="align-middle" style="width: 100px;" label="Feed Intake per Ekor (standar)" name="feed_intake_per_ekor_standar" />
                    </tr>
                </thead>
                <tbody>
                    @forelse($datas as $data)
                        <tr>
                            <td>{{ ($datas->currentPage() - 1) * $datas->perPage() + $loop->iteration }}</td>
                            <td class="text-left">{{ $data->nama_kandang }}</td>
                            <td class="text-left">{{ $data->tanggal_pemberian_pakan->translatedFormat('l, d F Y') }}</td>
                            <td class="text-right">{{ format_angka($data->umur_ayam) }}</td>
                            <td class="text-right">{{ format_angka($data->pemberian_kg) }}</td>
                            <td class="text-right">{{ format_angka($data->sisa_kg) }}</td>
                            <td class="text-right">{{ format_angka($data->feed_intake_kg) }}</td>
                            <td class="text-right">{{ format_angka($data->feed_intake_per_ekor) }}</td>
                            <td class="text-right">{{ format_angka($data->feed_intake_per_ekor_standar) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3">Data overview pakan harian tidak ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection