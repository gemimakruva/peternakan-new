@extends('layouts.dashboard')

@section('title', 'Strain Ayam')

@section('content_header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
        <div class="d-flex align-items-center gap-1">
            <h1>Strain Ayam</h1>
        </div>
        </div>
        <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Master Data</a></li>
            <li class="breadcrumb-item active">Strain Ayam</li>
        </ol>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="mx-1200">
    <div class="card">
        <div class="card-header">
            <div class="d-flex flex-wrap justify-content-left gap-2">
                @foreach ($strains as $strain)
                    <a 
                        href="{{ route('master-data.strain-ayam.index', ['strain_id' => $strain->id]) }}"
                        class="btn text-bold {{ $filterStrainId == $strain->id ? 'text-primary' : 'text-secondary' }}"
                    >
                        {{ $strain->nama }}
                    </a>
                @endforeach
            </div>
        </div>

        <div class="card-body table-responsive p-0">
            <table class="table table-hover table-striped table-bordered text-center">
                <thead class="bg-light">
                    <tr>
                        <th>#</th>
                        <th>Umur Minggu</th>
                        <th>BB Bawah</th>
                        <th>BB Atas</th>
                        <th>BB Rata-rata</th>
                        <th>% Kematian</th>
                        <th>Feed Intake</th>
                        <th>FCR</th>
                        <th>HDP</th>
                        <th>HHP</th>
                        <th>Berat Telur</th>
                        <th>Egg Mass</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($strainMetrics as $row)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td class="text-right">{{ format_angka($row->umur) }}</td>
                            <td class="text-right">{{ format_angka($row->berat_badan_min) }}</td>
                            <td class="text-right">{{ format_angka($row->berat_badan_max) }}</td>
                            <td class="text-right">{{ format_angka($row->berat_badan) }}</td>
                            <td class="text-right">{{ format_angka($row->persentase_kematian) }}</td>
                            <td class="text-right">{{ format_angka($row->feed_intake) }}</td>
                            <td class="text-right">{{ format_angka($row->fcr) }}</td>
                            <td class="text-right">{{ format_angka($row->hdp) }}</td>
                            <td class="text-right">{{ format_angka($row->hhp) }}</td>
                            <td class="text-right">{{ format_angka($row->egg_weight) }}</td>
                            <td class="text-right">{{ format_angka($row->egg_mass) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="12">Data tidak tersedia</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
