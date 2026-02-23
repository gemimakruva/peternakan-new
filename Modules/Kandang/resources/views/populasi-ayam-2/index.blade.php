@extends('layouts.dashboard')

@section('title', 'Populasi Ayam')

@section('content_header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <div class="d-flex align-items-center gap-1">
                <h1>Populasi Ayam</h1>
                <a href="{{ route('populasi-ayam-2.create') }}" class="btn btn-primary">Tambah Populasi Ayam</a>
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
        <div class="card-header">
            <h2 class="card-title">Filter</h2>
        </div>
        <div class="card-body">
            <form class="d-flex gap-2" action="{{ route('populasi-ayam-2.index') }}">
                <x-adminlte-select name="kandang_id" fgroup-class="mb-0 mx-200">
                    <x-adminlte-options
                        :options="$listKandang"
                        empty-option="Semua Kandang"
                        :selected="request()->query('kandang_id')"
                    />
                </x-adminlte-select>

                <button class="btn btn-primary" type="submit">
                    <i class="fas fa-search"></i>
                </button>

                <a href="{{ route('populasi-ayam-2.index') }}" class="btn btn-secondary">
                    <i class="fas fa-undo"></i>
                </a>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body table-responsive p-0">
            <table class="table table-hover table-striped table-bordered text-center mb-0">
                <thead>
                    <tr>
                        <th class="align-middle" rowspan="2" style="min-width: 40px;">#</th>
                        <th class="align-middle" rowspan="2" style="min-width: 180px;">Kandang</th>
                        <th class="align-middle" rowspan="2" style="min-width: 180px;">Tanggal</th>
                        <th class="align-middle" rowspan="2" style="min-width: 60px;">Umur Ayam</th>
                        <th class="align-middle" colspan="5">Total Ayam</th>
                        <th class="align-middle" rowspan="2" style="min-width: 40px;">Aksi</th>
                    </tr>
                    <tr>
                        <th class="align-middle" style="min-width: 60px;">Sehat</th>
                        <th class="align-middle" style="min-width: 60px;">Mati</th>
                        <th class="align-middle" style="min-width: 60px;">Afkir</th>
                        <th class="align-middle" style="min-width: 60px;">Masuk Karantina</th>
                        <th class="align-middle" style="min-width: 60px;">Keluar Karantina</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($datas as $row)
                        <tr>
                            <td class="text-right">{{ ($datas->currentPage() - 1) * $datas->perPage() + $loop->iteration }}</td>
                            <td class="text-left">{{ $row->nama_kandang }}</td>
                            <td class="text-left">{{ $row->tanggal->translatedFormat('l, d F Y') }}</td>
                            <td class="text-right">{{ format_angka(@$row->umur_ayam) }}</td>
                            <td class="text-right">{{ format_angka(@$row->ayam_sehat) }}</td>
                            <td class="text-right">{{ format_angka(@$row->ayam_mati) }}</td>
                            <td class="text-right">{{ format_angka(@$row->ayam_afkir) }}</td>
                            <td class="text-right">{{ format_angka(@$row->ayam_masuk_karantina) }}</td>
                            <td class="text-right">{{ format_angka(@$row->ayam_keluar_karantina) }}</td>
                            <td>
                                <div class="d-flex gap-2 justify-content-center">
                                    <a href="{{ route('populasi-ayam-2.edit', [$row->id_kandang, $row->tanggal->format('Y-m-d')])  }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @if (@$row->is_editable)
                                        <form action="{{ route('populasi-ayam-2.destroy', [$row->id_kandang, $row->tanggal->format('Y-m-d')]) }}" method="post">
                                            @csrf
                                            @method('delete')
                                            <button class="btn btn-sm btn-danger">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center">Data Populasi Ayam Kosong.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($datas->hasPages())
            <div class="card-footer d-flex justify-content-end">
                {{ $datas->links('components.pagination') }}
            </div>
        @endif
    </div>
</div>
@endsection