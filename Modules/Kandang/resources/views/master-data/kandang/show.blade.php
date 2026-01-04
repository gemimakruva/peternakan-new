@php
    $title = "Detail Kandang - $kandang->nama";
@endphp

@extends('layouts.dashboard')

@section('title', $title)

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            <div class="d-flex align-items-center gap-1">
                <h1>{{ $title }}</h1>
            </div>
            </div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Master Data</a></li>
                <li class="breadcrumb-item"><a href="{{ route('master-data.kandang.index') }}">Kandang</a></li>
                <li class="breadcrumb-item active">{{ $kandang->nama }}</li>
                <li class="breadcrumb-item active">Detail</li>
            </ol>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="mx-1200">
        <x-form-alert />

        <div class="row">
            <div class="col-md-9 col-12">
                @include('kandang::master-data.kandang.show_section_informasi')
                @include('kandang::master-data.kandang.show_section_tabel_baris')
            </div>
            <div class="col-md-3 col-12">
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title">Aksi</h2>
                    </div>
                    <div class="card-body">
                        <div class="d-flex gap-3 mb-3">
                            <a href="{{ route('master-data.kandang.index') }}" class="btn btn-outline-secondary flex-1">
                                Kembali
                            </a>
                            <a 
                                href="{{ 
                                    route('master-data.kandang.edit', [
                                        'kandang' => $kandang,
                                        'back_uri' => route('master-data.kandang.show', $kandang)
                                    ]) 
                                }}"
                                class="btn btn-warning flex-1"
                            >
                                Edit
                            </a>
                        </div>
                        <a 
                            href="{{ route('master-data.kandang.flock.create', $kandang) }}"
                            class="btn btn-primary btn-block"
                        >
                            Tambah Baris
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
