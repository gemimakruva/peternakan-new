@extends('layouts.dashboard')

@section('title', 'Pelaksanaan Treatment')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Pelaksanaa Treatment</h1> 
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item active">Pelaksanaan Treatment</li>
                </ol>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="mx-900">
        <x-form-alert />

        <div class="card">
            <div class="card-body table-responsive p-0">
                <table class="table table-hover table-striped table-bordered">
                    <thead class="text-center">
                        <tr>
                            <th style="max-width: 40px;">#</th>
                            <th style="max-width: 180px;">Kandang</th>
                            <th style="max-width: 140px;">Bulan</th>
                            <th style="max-width: 180px;">Treatment Terjadwal</th>
                            <th style="max-width: 40px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($datas as $index => $row)
                            <tr>
                                <td class="text-right">{{ ($loop->index + 1) + (request()->get('page', 1) * 10 - 10) }}</td>
                                <td>{{ $row->nama_kandang }}</td>
                                <td>{{ $row->nama_bulan }}</td>
                                <td class="text-right">{{ $row->treatment_terjadwal }}</td>
                                <td>
                                    <div class="d-flex justify-content-center gap-1">
                                        <a href="{{ route('treatment-pelaksanaan.jadwal', [$row->id_kandang, $row->bulan]) }}" class="btn btn-primary btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-3">
                                    Tidak ada data treatment ditemukan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection