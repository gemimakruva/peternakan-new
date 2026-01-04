@php
    $title= "Edit Baris - $flock->nama";
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
              <li class="breadcrumb-item"><a href="{{ route('master-data.flock.index') }}">Baris</a></li>
              <li class="breadcrumb-item active">{{ $flock->nama }}</li>
              <li class="breadcrumb-item active">Baris</li>
            </ol>
          </div>
        </div>
    </div>
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
