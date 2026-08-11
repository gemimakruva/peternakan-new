@extends('layouts.dashboard')

@section('title', 'Pencatatan Ayam Masuk')

@section('content_header')
    <x-page-header title="Edit Pengadaan Ayam" :breadcrumbs="[
        'Pengadaan Ayam' => route('pengadaan-ayam.index'),
        'Edit' => null,
    ]" />
@stop

@section('content')
    <div class="mx-1200">
        <x-form-alert />
        <div class="row">
            <div class="col-md-9 col-12">
                <form
                    enctype="multipart/form-data"
                    action="{{ route('pengadaan-ayam.update', $pengadaanAyam->id) }}"
                    method="post"
                    id="form-pengadaan"
                >
                    @method('PUT')
                    @csrf
                    @include('kandang::pengadaan-ayam._form', ['data' => $pengadaanAyam])
                    @include('kandang::pengadaan-ayam._form_distribusi')
                    @include('kandang::pengadaan-ayam._form_berkas')
                    @include('kandang::pengadaan-ayam._form_documentation')
                </form>
        </div>
        <div class="col-md-3 col-12">
                <div class="card sticy-form-action">
                    <div class="card-header">
                        <h2 class="card-title">Aksi</h2>
                    </div>
                    <div class="card-body">
                        <div class="d-flex gap-3">
                            <a href="{{ route('pengadaan-ayam.index') }}" class="btn btn-outline-secondary flex-1">Kembali</a>
                            <button class="btn btn-primary flex-1" form="form-pengadaan">Simpan</button>
                        </div>
                    </div>
                </div>
        </div>
        </div>
    </div>
@endsection
