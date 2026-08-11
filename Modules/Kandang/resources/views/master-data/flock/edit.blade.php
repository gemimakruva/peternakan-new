@php
    $title= "Edit Flock - $flock->nama";
@endphp

@extends('layouts.dashboard')

@section('title', $title)

@section('content_header')
    <x-page-header :title="$title" :breadcrumbs="[
        'Master Data' => '#',
        'Flock' => route('master-data.flock.index'),
        $flock->nama => null,
    ]" />
@endsection

@section('content')
    <div class="mx-1200">
        <div class="row">
            <div class="col-md-9 col-12">
                <div class="card">
                    <div class="card-body">
                        <form
                            action="{{ route('master-data.flock.update',$flock) }}"
                            method="post" 
                            id="form-flock"
                        >
                            @csrf
                            @method('PUT')
                            @include('kandang::master-data.flock._form_edit')
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-12">
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title">Aksi</h2>
                    </div>
                    <div class="card-body">
                        <div class="d-flex gap-3">
                            <a href="{{ route('master-data.flock.index') }}" class="btn btn-outline-secondary flex-1">Kembali</a>
                            <button class="btn btn-primary flex-1" form="form-flock">Simpan</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
