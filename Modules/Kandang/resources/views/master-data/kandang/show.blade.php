@php
    $title = "Detail Kandang - $kandang->nama";
@endphp

@extends('layouts.dashboard')

@section('title', $title)

@section('content_header')
    <x-page-header :title="$title" :breadcrumbs="[
        'Master Data' => '#',
        'Kandang' => route('master-data.kandang.index'),
        $kandang->nama => null,
    ]" />
@endsection

@section('content')
    <div class="mx-1200">
        <x-form-alert />

        <div class="row">
            <div class="col-md-9 col-12">
                @include('kandang::master-data.kandang.show_section_informasi')
                @include('kandang::master-data.kandang.show_section_tabel_flock')
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
                            Tambah Flock
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
