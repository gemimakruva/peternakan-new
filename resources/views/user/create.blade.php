@extends('layouts.dashboard')

@section('title', 'Tambah User')

@section('content_header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
        <div class="d-flex align-items-center gap-1">
            <h1>Tambah User</h1>
        </div>
        </div>
        <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">User Management</a></li>
            <li class="breadcrumb-item"><a href="{{ route('user.index') }}">User</a></li>
            <li class="breadcrumb-item active">Tambah User</li>
        </ol>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="mx-1200 row">
    <div class="col-md-9 col-12">
        <form action="{{ route('user.store') }}" method="post" id="form-user">
            @csrf
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Form User</h4>
                </div>
                <div class="card-body">
                    @include('user._form')
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header">
                    <h4 class="card-title">Role User</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach($roles as $role)
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="roles[]" value="{{ $role->name }}" id="role-{{ $role->name }}">
                                    <label class="form-check-label" for="role-{{ $role->name }}">
                                        {{ $role->name }}
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>
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
                    <a href="{{ route('user.index') }}" class="btn btn-outline-secondary flex-1">
                        Kembali
                    </a>
                    <button type="submit" class="btn btn-primary flex-1" form="form-user">
                        Simpan
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection