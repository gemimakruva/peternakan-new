@extends('adminlte::page')

@section('title', 'Database Strain Ayam')

@section('content_header')
   <div class="m-3 text-center">
    <h1 class="h4 fw-bold text-dark">Database Strain Ayam</h1>
    <p class="text-muted">Database strain ayam yang digunakan dalam produksi.</p>
</div>

@endsection



@section('content')
    <table class="table table-hover table-striped table-bordered text-center mb-0">
        {{-- Column Headers --}}
        <thead class="bg-light">
            <tr>
                <th style="width: 50px;">#</th>
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
            @foreach ($strain as $row)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $row->umur_minggu }}</td>
                    <td>{{ $row->bb_bawah }}</td>
                    <td>{{ $row->bb_atas }}</td>
                    <td>{{ $row->bb_rata2 }}</td>
                    <td>{{ $row->persentase_kematian }}</td>
                    <td>{{ $row->feed_intake }}</td>
                    <td>{{ $row->fcr }}</td>
                    <td>{{ $row->hdp }}</td>
                    <td>{{ $row->hhp }}</td>
                    <td>{{ $row->egg_weight }}</td>
                    <td>{{ $row->egg_mass }}</td>
                </tr>
            @endforeach
        </tbody>

    </table>
@endsection
