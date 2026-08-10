@extends('layouts.dashboard')

@section('title', 'General')

@section('content_header')
<x-page-header title="General" :breadcrumbs="['Setting' => '']" />
@endsection

@section('content')
<div class="mx-1200">
    <x-form-alert />

    <form action="{{ route('setting.general.store') }}" method="post" id="form-setting" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-12 col-md-9">
                <div class="card">
                    <div class="card-body">
                        @include('setting._form')
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-3">
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