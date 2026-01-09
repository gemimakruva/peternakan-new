@extends('layouts.dashboard')

@section('title', 'Populasi Ayam')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <div class="d-flex align-items-center gap-1">
                <h1>Populasi Ayam - {{ $flock->nama }} - Pipe</h1>
            </div>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">  
              <li class="breadcrumb-item"><a href="{{ route('populasi-ayam.index') }}">Populasi Ayam</a></li>
              <li class="breadcrumb-item active">{{ $kandang->nama }}</a></li>
              <li class="breadcrumb-item"><a href="{{ route('populasi-ayam.flock.index', [$kandang]) }}">Flock</a></li>
              <li class="breadcrumb-item active">{{ $flock->nama }}</li>
              <li class="breadcrumb-item active">Pipe</li>
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
                    <thead class="bg-light">
                        <tr>
                            <th class="align-middle" width="40">#</th>
                            <th class="align-middle">Tanggal Transaksi</th>
                            <th class="align-middle">Petugas Pencatat</th>
                            <th class="align-middle">Pipa</th>
                            <th class="align-middle" width="100">Umur Ayam</th>
                            <th class="align-middle" width="100">Ayam Sehat</th>
                            <th class="align-middle" width="100">Ayam Mati</th>
                            <th class="align-middle" width="100">Ayam Afkir</th>
                            <th class="align-middle" width="100">Ayam Masuk Karantina</th>
                            <th class="align-middle" width="100">Ayam Keluar Karantina</th>
                            <th class="align-middle">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($listPopulasiAyam as $row)
                            <tr>
                                <td class="text-right">{{ ($listPopulasiAyam->currentPage() - 1) * $listPopulasiAyam->perPage() + $loop->iteration }}</td>
                                <td class="text-left">{{ $row->tanggal->translatedFormat('l, d F Y') }}</td>
                                <td class="text-left">{{ $row->picUser->name }}</td>
                                <td class="text-left">{{ $row->pipe->nama }}</td>
                                <td class="text-left">{{ $row->umur_ayam_record }} Minggu</td>
                                <td class="text-right">{{ number_format($row->ayam_sehat, 0, ',', '.') }}</td>
                                <td class="text-right">{{ number_format($row->ayam_mati, 0, ',', '.') }}</td>
                                <td class="text-right">{{ number_format($row->ayam_afkir, 0, ',', '.') }}</td>
                                <td class="text-right">{{ number_format($row->ayam_masuk_karantina, 0, ',', '.') }}</td>
                                <td class="text-right">{{ number_format($row->ayam_keluar_karantina, 0, ',', '.') }}</td>
                                <td>
                                    <a href="{{ route('populasi-ayam.edit', $row)  }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="11" class="text-center">Data Populasi Ayam Kosong.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($listPopulasiAyam->hasPages())
                <div class="card-footer d-flex justify-content-end">
                    {{ $listPopulasiAyam->links('components.pagination') }}
                </div>
            @endif
        </div>
    </div>
@endsection