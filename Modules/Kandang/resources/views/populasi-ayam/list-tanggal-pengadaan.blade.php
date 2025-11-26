@extends('layouts.dashboard')

@section('List Tanggal Pengadaan', 'List Tanggal Pengadaan untuk recording harian')

@section('content_header')
<div class="mb-4 text-center d-flex flex-column align-items-center">
    <h2 class="h4 fw-bold text-dark">List Pengadaan</h2>
    <span class="text-muted mb-0" style="max-width: 600px;">
        Halaman ini digunakan menampilkan list Pengadaan untuk recording harian
    </span>
</div>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <table class="table table-bordered table-striped text-center align-middle">
            <thead class="bg-secondary text-white">
                <tr>
                    <th style="width: 60px;">No</th>
                    <th>Tanggal Pengadaan</th>
                    <th style="width: 120px;">Action</th>
                </tr>
            </thead>
           
            <tbody>
                @foreach($ListPengadaanAyam as $index => $pengadaan)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>
                            {{ \Carbon\Carbon::parse($pengadaan['tanggal'])
                                ->translatedFormat('l, d F Y') }}
                        </td>
                        <td>
                            <a href="{{ route('populasi-ayam.createByDate', $pengadaan['id']) }}" 
                               class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i> Isi Form
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
