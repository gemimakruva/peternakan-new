@extends('adminlte::page')

@section('content')
    <div class="pt-3" style="max-width: 900px;">
        <div class="card">
            <div class="card-header">{{ __('Dashboard') }}</div>
    
            <div class="card-body">
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
    
                {{ __('You are logged in!') }}
            </div>
        </div>
    </div>
@endsection
