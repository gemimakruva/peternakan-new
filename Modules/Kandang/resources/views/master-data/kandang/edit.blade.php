@extends('adminlte::page')

@section('title', 'Edit Kandang')

@section('content_header')
    <h1>Edit Kandang</h1>
@endsection

@section('content')
    <div style="width: 1000px;">
        <div class="row">
            <div class="col-12 col-md-8">
                
                <form action="{{ route('master-data.kandang.update', @$data->id) }}" method="post" id="form-kandang">
                    @csrf
                    @method('put')
                    @include('kandang::master-data.kandang._form')
                </form>

            </div>
            <div class="col-12 col-md-4">

                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title">Aksi</h2>
                    </div>
                    <div class="card-body">
                        <div class="d-flex" style="gap: .5em">
                            <button type="submit" form="form-kandang" class="btn btn-primary w-100">Update</button>
                            <a href="{{ route('master-data.kandang.index') }}" class="btn btn-danger w-100">Kembali</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
