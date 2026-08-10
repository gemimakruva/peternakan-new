@extends('layouts.dashboard')

@section('title', 'Edit Profile')

@section('content_header')
<x-page-header title="Edit Profile" :breadcrumbs="['Profile' => '']" />
@endsection

@section('plugins.BootstrapSwitch', true)

@section('content')
<div class="mx-1200">
    <x-form-alert />

    <form action="{{ route('profile.update', $user) }}" method="post" id="form-profile" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-md-9 col-12">
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

                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title">Setting</h2>
                    </div>
                    <div class="card-body">
                        <x-adminlte-input-switch
                            name="enabled_notification"
                            label="Notification"
                            igroup-size="sm"
                            fgroup-class="mb-0"
                            :is-checked="auth()->user()->enabled_notification"
                        />
                    </div>
                </div>
            </div>
        </div>

    </form>
</div>
@endsection