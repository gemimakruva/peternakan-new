@extends('layouts.dashboard')

@section('title', 'Edit Profile')

@section('content_header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Edit Profile</h1>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="mx-1200">
    <x-form-alert />

    <div class="row">
        <div class="col-md-9 col-12">
            <form action="{{ route('profile.update', $user) }}" method="post" id="form-profile" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title">Form User</h2>
                    </div>
                    <div class="card-body">
                        @include('user._form')
                        <x-adminlte-input-file 
                            name="avatar_file" label="Profile Image" 
                            placeholder="Choose a file..."
                            disable-feedback/>
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
                    <button type="submit" class="btn btn-primary w-100" form="form-profile">
                        Simpan
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection