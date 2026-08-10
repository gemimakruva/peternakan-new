@extends('layouts.dashboard')

@section('title', 'Edit Ayam Karantina')

@section('content_header')
    <x-page-header title="Edit Ayam Karantina" :breadcrumbs="[
        'Ayam Karantina' => route('ayam-karantina.index'),
        ($data->kandang->name ?? 'Kandang') => '',
        'Edit' => '',
    ]" />
@endsection


@section('content')
    <div class="mx-1000">
        <x-form-alert />
        <div class="row">
            <div class="col-md-9 col-12">
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title">Form Ayam Karantina</h2>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('ayam-karantina.update', $data) }}" method="POST" id="edit-ayam-karantina-form">
                            @method('PUT')
                            @csrf
                            @include('kandang::ayam-karantina._form')
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-12">
                <div class="card sticy-form-action">
                    <div class="card-header">
                        <h2 class="card-title">Aksi</h2>
                    </div>
                    <div class="card-body">
                        <div class="d-flex gap-3">
                            <a href="{{ route('ayam-karantina.index') }}" class="btn btn-secondary flex-1 w-100">Kembali</a>
                            <button type="submit" class="btn btn-primary flex-1 w-100" form="edit-ayam-karantina-form">Simpan</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection