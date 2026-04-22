@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                
                <div class="card">
                    <div class="card-body">
                        <h1 class="mb-0">Selamat Datang di <strong>{{ config('adminlte.title') }}</strong>.</h1>
                        <h2>{{ config('adminlte.description') }}</h2>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection