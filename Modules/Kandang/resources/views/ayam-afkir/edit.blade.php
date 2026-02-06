@extends('layouts.dashboard')

@section('title', 'Ayam Afkir')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <div class="d-flex align-items-center gap-1">
                <h1>Edit Ayam Afkir</h1>
            </div>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">  
              <li class="breadcrumb-item"><a href="{{ route('ayam-afkir.index') }}">Ayam Afkir</a></li>
              <li class="breadcrumb-item active">Edit</li>
            </ol>
          </div>
        </div>
    </div>
@endsection

@php
$informations = [
    ['Kandang', $ayamAfkir?->kandang?->nama],
    ['PIC', $ayamAfkir?->picUser?->nama ?? '-'],
    ['Tanggal', $ayamAfkir?->tanggal?->translatedFormat('l, d F Y')],
    ['Umur Ayam (minggu)', $ayamAfkir?->umur_ayam],
];
@endphp

@section('content')
    <div style="max-width: 1200px" class="row justify-content-center">
        <div class="col-md-9 col-12">
            <form action="{{ route('ayam-afkir.update', $ayamAfkir) }}" method="POST" id="form-ayam-afkir">
                @csrf
                @method('PUT')

                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title">Informasi</h2>
                    </div>
                    <div class="card-body">
                        <div class="informations-wrapper">
                            @foreach ($informations as $info)
                                <div class="item">
                                    <span class="label">{{ $info[0] }}</span>
                                    <span class="value">: {{ $info[1] }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title">Form Ayam Afkir</h2>
                    </div>
                    <div class="card-body">
                        @include('kandang::ayam-afkir._form')
                    </div>
                </div>

                <div class="card">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped table-bordered mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-center">Flock</th>
                                        <th class="text-center">Pipa</th>
                                        <th class="text-center">Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($ayamAfkir->ayamAfkirPopulasi as $item)
                                        <tr>
                                            <td>{{ $item->flock->nama }}</td>
                                            <td>{{ $item->pipe->nama }}</td>
                                            <td class="text-right">{{ $item->jumlah_ayam_afkir }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="2"><strong>Total</strong></td>
                                        <td class="text-right">{{ format_angka($ayamAfkir->ayamAfkirPopulasi->sum('jumlah_ayam_afkir'), 0) }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-md-3 col-12">
            <div class="card sticy-form-action">
                <div class="card-header">
                    <h2 class="card-title">Aksi</h2>
                </div>
                <div class="card-body">
                    <div class="d-flex gap-3">
                        <a href="{{ route('ayam-afkir.index') }}" class="btn btn-outline-secondary flex-1">
                            Kembali
                        </a>
                        <button type="submit" class="btn btn-primary flex-1" form="form-ayam-afkir">
                            Simpan
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('css')
    <style>
        .informations-wrapper {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
        }
        .informations-wrapper .item {
            display: flex;
        }
        .informations-wrapper .item .label {
            font-weight: bold;
            flex: 2;
        }
        .informations-wrapper .item .value {
            flex: 3;
        }
    </style>
@endpush