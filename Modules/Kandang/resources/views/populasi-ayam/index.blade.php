@extends('layouts.dashboard')

@section('title', 'Populasi Ayam')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <div class="d-flex align-items-center gap-1">
                <h1>Populasi Ayam</h1>
            </div>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">  
              <li class="breadcrumb-item active">Populasi Ayam</li>
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
                            <th class="align-middle" rowspan="2" width="40">#</th>
                            <th class="align-middle" rowspan="2" >Kandang</th>
                            <th class="align-middle" rowspan="2" >Tanggal Pengadaan</th>
                            <th class="align-middle" colspan="2">Umur Ayam</th>
                            <th class="align-middle" colspan="4">Total Ayam</th>
                            <th class="align-middle" rowspan="2" >Terakhir Diperbarui</th>
                            <th class="align-middle" rowspan="2" >Aksi</th>
                        </tr>
                        <tr>
                            <th class="align-middle">Awal</th>
                            <th class="align-middle">Saat Ini</th>
                            <th class="align-middle">Sehat</th>
                            <th class="align-middle">Mati</th>
                            <th class="align-middle">Masuk Karantina</th>
                            <th class="align-middle">Keluar Karantina</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($listKandang as $row)
                            <tr>
                                <td>{{ ($listKandang->currentPage() - 1) * $listKandang->perPage() + $loop->iteration }}</td>
                                <td>{{ $row['nama'] }}</td>
                                <td>{{ @$row->latestPengadaanAyam->tanggal?->translatedFormat('l, d F Y') }}</td>
                                <td>{{ @$row->latestPengadaanAyam->umur_ayam }}</td>
                                <td>{{ @$row->latestPengadaanAyam->umur_ayam_saat_ini }}</td>
                                <td>{{ @$row->ayam_sehat }}</td>
                                <td>{{ @$row->ayam_mati }}</td>
                                <td>{{ @$row->ayam_masuk_karantina }}</td>
                                <td>{{ @$row->ayam_keluar_karantina }}</td>
                                <td>{{ @$row->terakhir_diperharui->translatedFormat('l, d F Y') }}</td>
                                <td>
                                    <a href="{{ route('populasi-ayam.flock.index', $row->id)  }}" class="btn btn-sm btn-info">
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

            @if ($listKandang->hasPages())
                <div class="card-footer d-flex justify-content-end">
                    {{ $listKandang->links('components.pagination') }}
                </div>
            @endif
        </div>
    </div>
@endsection