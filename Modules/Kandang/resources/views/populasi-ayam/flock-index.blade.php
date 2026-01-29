@extends('layouts.dashboard')

@section('title', 'Populasi Ayam')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <div class="d-flex align-items-center gap-1">
                <h1>Populasi Ayam - {{ $kandang->nama }} - Baris</h1>
                <a href="{{ route('populasi-ayam.create', $kandang) }}" class="btn btn-primary">Tambah Populasi Ayam</a>
            </div>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">  
              <li class="breadcrumb-item"><a href="{{ route('populasi-ayam.index') }}">Populasi Ayam</a></li>
              <li class="breadcrumb-item active">{{ $kandang->nama }}</li>
              <li class="breadcrumb-item active">Flock</li>
            </ol>
          </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="mx-1400">
        <div class="card">
            <div class="card-body table-responsive p-0">
                <table class="table table-hover table-striped table-bordered text-center mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="align-middle" width="40">#</th>
                            <th class="align-middle">Baris</th>
                            <th class="align-middle" width="100">Jumlah Ayam Fit</th>
                            <th class="align-middle" width="100">Akumulasi Kematian</th>
                            <th class="align-middle" width="100">Kematian (%)</th>
                            <th class="align-middle" width="100">Akumulasi Afkir</th>
                            <th class="align-middle" width="100">Afkir (%)</th>
                            <th class="align-middle" width="100">Akumulasi Kematian + Afkir</th>
                            <th class="align-middle" width="100">Kematian + Afkir (%)</th>
                            <th class="align-middle" width="100">Masuk Karantina</th>
                            <th class="align-middle" width="100">Keluar Karantina</th>
                            <th class="align-middle" width="100">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($listFlock as $row)
                            <tr>
                                <td class="text-right">{{ ($listFlock->currentPage() - 1) * $listFlock->perPage() + $loop->iteration }}</td>
                                <td class="text-left">{{ $row->nama }}</td>
                                <td class="text-right">{{ format_angka($row->ayam_sehat) }}</td>
                                <td class="text-right">{{ format_angka($row->ayam_mati) }}</td>
                                <td class="text-right">{{ format_angka($row->ayam_mati/$row->jumlah_ayam_masuk_kandang, 3) }}%</td>
                                <td class="text-right">{{ format_angka($row->ayam_afkir) }}</td>
                                <td class="text-right">{{ format_angka($row->ayam_afkir/$row->jumlah_ayam_masuk_kandang, 3) }}%</td>
                                <td class="text-right">{{ format_angka($row->ayam_mati + $row->ayam_afkir) }}</td>
                                <td class="text-right">{{ format_angka(($row->ayam_mati + $row->ayam_afkir)/$row->jumlah_ayam_masuk_kandang, 3) }}%</td>
                                <td class="text-right">{{ format_angka($row->ayam_masuk_karantina) }}</td>
                                <td class="text-right">{{ format_angka($row->ayam_keluar_karantina) }}</td>
                                <td>
                                    <a href="{{ route('populasi-ayam.flock.pipe.index', [$kandang, $row])  }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
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

            @if ($listFlock->hasPages())
                <div class="card-footer d-flex justify-content-end">
                    {{ $listFlock->links('components.pagination') }}
                </div>
            @endif
        </div>
    </div>
@endsection