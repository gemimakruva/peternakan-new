@extends('layouts.dashboard')

@section('title', 'Tambah Pipa')

@section('content_header')
    <x-page-header title="Edit Pipa" :breadcrumbs="[
        'Master Data' => '#',
        'Kandang' => route('master-data.kandang.index'),
        $kandang->nama => route('master-data.kandang.show', $kandang),
        $flock->nama => route('master-data.kandang.flock.show', [$kandang, $flock]),
        'Edit Pipa' => null,
    ]" />
@endsection

@section('content')
    <div class="mx-1200">
        <x-form-alert />

        <div class="row">
            <div class="col-md-9 col-md-3">
                <form 
                    action="{{ route('master-data.kandang.flock.pipe.update', [$kandang, $flock, $pipe]) }}"
                    method="post"
                    id="form-kandang-flock-pipe"
                >
                    @csrf
                    @method('put')
                    @include('kandang::master-data.kandang.flock.pipe._form')
                </form>
            </div>

            <div class="col-md-3 col-12">
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title">Aksi</h2>
                    </div>
                    <div class="card-body">
                        <div class="d-flex gap-3">
                            <a href="{{ route('master-data.kandang.flock.show', [$kandang, $flock]) }}" class="btn btn-outline-secondary flex-1">Kembali</a>
                            <button class="btn btn-primary flex-1" form="form-kandang-flock-pipe">Simpan</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
