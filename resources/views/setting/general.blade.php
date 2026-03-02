@extends('layouts.dashboard')

@section('title', 'General')

@section('content_header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>General</h1>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="mx-1200">
    <x-form-alert />

    <form action="{{ route('setting.general.store') }}" method="post" id="form-setting" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-sm-9 col-12">
                <div class="card">
                    <div class="card-body">
                        @include('setting._form')
                    </div>
                </div>
            </div>
            
            <div class="col-sm-3 col-12">
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title">Aksi</h2>
                    </div>
                    <div class="card-body">
                        <button type="submit" class="btn btn-primary w-100" form="form-setting">
                            Simpan
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </form>
</div>
@endsection