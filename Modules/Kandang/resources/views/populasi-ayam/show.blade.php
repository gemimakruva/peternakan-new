@extends('layouts.dashboard')

@section('title', 'Populasi Ayam')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <div class="d-flex align-items-center gap-1">
                <h1>Populasi Ayam - {{ $kandang->nama }} - Baris</h1>
                <a href="{{ route('populasi-ayam.createByDate', $kandang->id) }}" class="btn btn-primary">Tambah Populasi Ayam</a>
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
                            <th width="40">#</th>
                            <th>Baris</th>
                            <th>Jumlah Ayam Fit</th>
                            <th>Akumulasi Kematian</th>
                            <th>Kematian (%)</th>
                            <th>Akumulasi Afkir</th>
                            <th>Afkir (%)</th>
                            <th>Akumulasi Kematian + Afkir</th>
                            <th>Kematian + Afkir</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($lisFlock as $row)
                            <tr>
                                <td>{{ ($listKandang->currentPage() - 1) * $listKandang->perPage() + $loop->iteration }}</td>
                                <td>
                                    <a href="{{ route('populasi-ayam.show', $row->id)  }}" class="btn btn-sm btn-info">
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