@props([
    'overlay' => false,
    'size' => '40px',
    'text' => '',
])

@if($overlay)
<div {{ $attributes->merge(['class' => 'loading-overlay']) }}>
@endif
    <div class="loading-spinner" style="--spinner-size: {{ $size }}">
        <div class="loading-spinner__circle"></div>
        @if($text)
            <div class="loading-spinner__text">{{ $text }}</div>
        @endif
    </div>
@if($overlay)
</div>
@endif

@once
@push('css')
<style>
.loading-overlay {
    position: fixed;
    inset: 0;
    background: rgba(250, 248, 245, 0.85);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 9999;
}
.loading-spinner {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.75rem;
}
.loading-spinner__circle {
    width: var(--spinner-size, 40px);
    height: var(--spinner-size, 40px);
    border: 3px solid #E8E4DF;
    border-top-color: #F28B1E;
    border-radius: 50%;
    animation: spin 0.7s linear infinite;
}
.loading-spinner__text {
    font-size: 0.85rem;
    color: #6B7280;
    font-weight: 500;
}
@keyframes spin {
    to { transform: rotate(360deg); }
}
</style>
@endpush
@endonce
