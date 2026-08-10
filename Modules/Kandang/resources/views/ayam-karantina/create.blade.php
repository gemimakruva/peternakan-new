@extends('layouts.dashboard')

@section('title', 'Tambah Ayam Karantina')

@section('content_header')
    <x-page-header title="Tambah Ayam Karantina" :breadcrumbs="[
        'Ayam Karantina' => route('ayam-karantina.index'),
        'Tambah' => '',
    ]" />
@endsection

@section('content')
    <div class="mx-1200">
        <div class="row">
            <div class="col-md-9 col-12">
                <form action="{{ route('ayam-karantina.store') }}" method="POST" id="form-ayam-karantina">
                    @csrf
                    <div class="card">
                        <div class="card-header">
                            <h2 class="card-title">Form Ayam Karantina</h2>
                        </div>
                        <div class="card-body">
                            @include('kandang::ayam-karantina._form')
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
                            <a href="{{ route('ayam-karantina.index') }}" class="btn btn-outline-secondary flex-1 w-100">Kembali</a>
                            <button class="btn btn-primary flex-1 w-100" form="form-ayam-karantina">Simpan</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection