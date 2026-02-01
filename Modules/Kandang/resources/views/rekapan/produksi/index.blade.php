@extends('layouts.dashboard')

@section('title', 'Rekapan Produksi')

@section('content_header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Rekapan Produksi</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">  
                <li class="breadcrumb-item active">Rekapan Produksi</li>
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
                <thead>
                    <tr>
                        <th class="align-middle" style="width: 40px;">#</th>
                        <x-sort-th class="align-middle" style="width: 150px;" label="Kandang" name="nama_kandang" />
                    </tr>
                </thead>
                <tbody>
                    @forelse($datas as $data)
                        <tr>
                            <td>{{ ($datas->currentPage() - 1) * $datas->perPage() + $loop->iteration }}</td>
                            <td class="text-left">{{ $data->nama_kandang }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">Data rekapan ayam tidak tersedia.</td>
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