@extends('layouts.dashboard')

@section('title', 'Daftar Notifikasi')

@section('content_header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Daftar Notifikasi</h1>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="mx-900">
    <div class="card">
        <div class="card-body">
            <div class="notifications">
                @forelse ($notifications as $not)
                    <a href="{{ $not->data['url'] }}" class="item">
                        <div class="d-flex justify-content-center align-items-center">
                            <i class="{{ $not->data['icon'] }}" style="font-size: 4rem;"></i>
                        </div>
                        <div>
                            <h2 class="title">{{ $not->data['title'] }}</h2>
                            <p class="mb-0">{{ $not->data['message'] }}</p>
                            <p class="mb-0">{{ $not->created_at->translatedFormat('l, d F Y') }}</p>
                        </div>
                    </a>
                @empty
                    
                @endforelse
            </div>
        </div>
        @if ($notifications->hasPages())
            <div class="card-footer d-flex justify-content-end">
                {{ $notifications->links('components.pagination') }}
            </div>
        @endif
    </div>      
</div>
@endsection

@push('css')
<style>
    .notifications {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }
    .notifications .item {
        grid-template-columns: 1fr 9fr;
        border: 1px solid #ddd;
        border-radius: 6px;
        color: #333;
        display: grid;
        gap: .6rem;
        padding: 1rem 0;
    }
    .notifications .item:hover {
        background-color: #eee;
    }
    .notifications .item .title {
        font-size: 1.4rem;
    }
</style>
@endpush