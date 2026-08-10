@props([
    'title' => 'Belum Ada Data',
    'description' => '',
    'icon' => 'clipboard',
    'actionUrl' => '',
    'actionLabel' => 'Tambah Data',
])

<div {{ $attributes->merge(['class' => 'empty-state']) }}>
    <div class="empty-state__icon">
        @switch($icon)
            @case('search')
                <svg width="120" height="120" viewBox="0 0 120 120" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="60" cy="60" r="56" fill="#F28B1E" fill-opacity="0.08"/>
                    <circle cx="52" cy="52" r="22" stroke="#F28B1E" stroke-width="4" fill="none"/>
                    <line x1="68" y1="68" x2="88" y2="88" stroke="#F28B1E" stroke-width="4" stroke-linecap="round"/>
                    <line x1="44" y1="44" x2="60" y2="60" stroke="#F28B1E" stroke-width="3" stroke-linecap="round"/>
                    <line x1="60" y1="44" x2="44" y2="60" stroke="#F28B1E" stroke-width="3" stroke-linecap="round"/>
                </svg>
            @break
            @case('egg')
                <svg width="120" height="120" viewBox="0 0 120 120" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="60" cy="60" r="56" fill="#F28B1E" fill-opacity="0.08"/>
                    <path d="M60 26C47 26 36 44 36 62C36 76 47 88 60 88C73 88 84 76 84 62C84 44 73 26 60 26Z" stroke="#F28B1E" stroke-width="3.5" fill="none"/>
                    <ellipse cx="60" cy="68" rx="12" ry="8" stroke="#F28B1E" stroke-width="2" stroke-dasharray="4 3" fill="none"/>
                </svg>
            @break
            @case('chicken')
                <svg width="120" height="120" viewBox="0 0 120 120" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="60" cy="60" r="56" fill="#F28B1E" fill-opacity="0.08"/>
                    <circle cx="60" cy="42" r="14" stroke="#F28B1E" stroke-width="3.5" fill="none"/>
                    <path d="M46 56C42 62 40 70 40 78C40 84 48 90 60 90C72 90 80 84 80 78C80 70 78 62 74 56" stroke="#F28B1E" stroke-width="3.5" fill="none"/>
                    <circle cx="55" cy="40" r="2" fill="#F28B1E"/>
                    <path d="M64 46L72 42L64 38" stroke="#F28B1E" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
                    <path d="M54 52L50 58" stroke="#F28B1E" stroke-width="2" stroke-linecap="round"/>
                    <path d="M66 52L70 58" stroke="#F28B1E" stroke-width="2" stroke-linecap="round"/>
                </svg>
            @break
            @case('box')
                <svg width="120" height="120" viewBox="0 0 120 120" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="60" cy="60" r="56" fill="#F28B1E" fill-opacity="0.08"/>
                    <path d="M34 50L60 36L86 50L60 64L34 50Z" stroke="#F28B1E" stroke-width="3" fill="none"/>
                    <path d="M34 50V74L60 88V64" stroke="#F28B1E" stroke-width="3" fill="none"/>
                    <path d="M86 50V74L60 88V64" stroke="#F28B1E" stroke-width="3" fill="none"/>
                    <path d="M40 44L50 38" stroke="#F28B1E" stroke-width="2" stroke-linecap="round" stroke-dasharray="3 3"/>
                </svg>
            @break
            @case('chart')
                <svg width="120" height="120" viewBox="0 0 120 120" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="60" cy="60" r="56" fill="#F28B1E" fill-opacity="0.08"/>
                    <line x1="32" y1="86" x2="88" y2="86" stroke="#F28B1E" stroke-width="3" stroke-linecap="round"/>
                    <line x1="32" y1="34" x2="32" y2="86" stroke="#F28B1E" stroke-width="3" stroke-linecap="round"/>
                    <polyline points="40,70 52,70 64,70 76,70" stroke="#F28B1E" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" fill="none" stroke-dasharray="5 4"/>
                    <circle cx="40" cy="70" r="3" fill="#F28B1E"/>
                    <circle cx="76" cy="70" r="3" fill="#F28B1E"/>
                </svg>
            @break
            @default
                <svg width="120" height="120" viewBox="0 0 120 120" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="60" cy="60" r="56" fill="#F28B1E" fill-opacity="0.08"/>
                    <rect x="40" y="28" width="40" height="52" rx="4" stroke="#F28B1E" stroke-width="3.5" fill="none"/>
                    <rect x="40" y="28" width="40" height="14" rx="4" stroke="#F28B1E" stroke-width="3.5" fill="#F28B1E" fill-opacity="0.15"/>
                    <line x1="50" y1="52" x2="70" y2="52" stroke="#F28B1E" stroke-width="2.5" stroke-linecap="round"/>
                    <line x1="50" y1="60" x2="65" y2="60" stroke="#F28B1E" stroke-width="2.5" stroke-linecap="round"/>
                    <line x1="50" y1="68" x2="60" y2="68" stroke="#F28B1E" stroke-width="2.5" stroke-linecap="round"/>
                    <path d="M68 74L72 78L80 70" stroke="#F28B1E" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
                </svg>
        @endswitch
    </div>

    <h6 class="empty-state__title">{{ $title }}</h6>

    @if($description)
        <p class="empty-state__description">{{ $description }}</p>
    @endif

    @if($actionUrl)
        <a href="{{ $actionUrl }}" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-lg"></i> {{ $actionLabel }}
        </a>
    @endif
</div>

@once
@push('css')
<style>
.empty-state {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    text-align: center;
    padding: 2.5rem 1rem;
    max-width: 400px;
    margin: 0 auto;
}
.empty-state__icon {
    margin-bottom: 1.25rem;
}
.empty-state__icon svg {
    width: 120px;
    height: 120px;
}
.empty-state__title {
    font-size: 1rem;
    font-weight: 600;
    color: #2D3436;
    margin-bottom: 0.5rem;
}
.empty-state__description {
    font-size: 0.85rem;
    color: #9E9E9E;
    max-width: 300px;
    margin-bottom: 1.25rem;
    line-height: 1.5;
}
</style>
@endpush
@endonce
