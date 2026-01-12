@extends('layouts.dashboard')

@section('title', 'Ayam Afkir')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <div class="d-flex align-items-center gap-1">
                <h1>Edit Ayam Afkir</h1>
            </div>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">  
              <li class="breadcrumb-item"><a href="{{ route('ayam-afkir.index') }}">Ayam Afkir</a></li>
              <li class="breadcrumb-item active">Edit</li>
            </ol>
          </div>
        </div>
    </div>
@endsection

@section('content')
    <div style="max-width: 1200px" class="row justify-content-center">
        <div class="col-md-9 col-12">
            <form action="{{ route('ayam-afkir.update', $ayamAfkir) }}" method="POST" id="form-ayam-afkir">
                @csrf
                @method('PUT')

                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title">Form Ayam Afkir</h2>
                    </div>
                    <div class="card-body">
                        @include('kandang::ayam-afkir._form')
                    </div>
                </div>
            </form>
        </div>
        <div class="col-md-3 col-12">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Aksi</h2>
                </div>
                <div class="card-body">
                    <div class="d-flex gap-3">
                        <a href="{{ route('ayam-afkir.index') }}" class="btn btn-secondary flex-1">
                            Kembali
                        </a>
                        <button type="submit" class="btn btn-primary flex-1" form="form-ayam-afkir">
                            Simpan
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection