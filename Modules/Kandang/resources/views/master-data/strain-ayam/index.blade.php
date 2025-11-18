@extends('adminlte::page')

@section('title', 'Database Strain Ayam')

@section('content_header')
<div class="m-3 text-center">
    <h1 class="h4 fw-bold text-dark">Database Strain Ayam</h1>
    <p class="text-muted">Database strain ayam yang digunakan dalam produksi.</p>
</div>
@endsection

@section('content')
<div class="m-3 text-center">
    {{-- Tombol filter per strain --}}
    <div class="mb-4 d-flex flex-wrap justify-content-between gap-2">
       <div clas>
         @foreach ($strains as $strain)
            <a href="{{ route('master-data.strain-ayam.index', ['strain_id' => $strain->id]) }}" 
            class="btn {{ $filterStrainId == $strain->id ? 'btn-success' : 'btn-outline-secondary' }}">
            Strain {{ $strain->id }}
            </a>
        @endforeach
       </div>
        {{-- Tombol reset --}}
        <a href="{{ route('master-data.strain-ayam.index') }}" class="btn btn-outline-secondary">
            Tampilkan Semua
        </a>
    </div>


    {{-- Tabel --}}
    <div class="table-responsive" style="max-width: 1200px; margin:auto;">
        <table class="table table-hover table-striped table-bordered text-center mb-0">
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
                        <td>{{ $row->umur }}</td>
                        <td>{{ $row->berat_badan_min }}</td>
                        <td>{{ $row->berat_badan_max }}</td>
                        <td>{{ $row->berat_badan }}</td>
                        <td>{{ $row->persentase_kematian }}</td>
                        <td>{{ $row->feed_intake }}</td>
                        <td>{{ $row->fcr }}</td>
                        <td>{{ $row->hdp }}</td>
                        <td>{{ $row->hhp }}</td>
                        <td>{{ $row->egg_weight }}</td>
                        <td>{{ $row->egg_mass }}</td>
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
@endsection
