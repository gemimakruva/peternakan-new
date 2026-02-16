@extends('layouts.dashboard')

@section('title', 'Edit Role')

@section('content_header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Edit Role</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Master Data</a></li>
                <li class="breadcrumb-item"><a href="{{ route('role.index') }}">Role</a></li>
                <li class="breadcrumb-item active">Edit {{ $role->name }}</li>
            </ol>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="mx-1200 row">
    <div class="col-md-9 col-12">
        <form action="{{ route('role.update', $role) }}" method="post" id="form-role" >
            @csrf
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Form Role</h2>
                </div>
                <div class="card-body">
                    @method('PUT')
                    @include('role._form')
                </div>
            </div>
            @include('role._form_permissions')
        </form>
    </div>
    <div class="col-md-3 col-12">
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">Aksi</h2>
            </div>
            <div class="card-body">
                <div class="d-flex gap-3">
                    <a href="{{ route('role.index') }}" class="btn btn-outline-secondary flex-1">
                        Kembali
                    </a>
                    <button type="submit" class="btn btn-primary flex-1" form="form-role">
                        Simpan
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection