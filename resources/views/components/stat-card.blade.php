@props([
    'label',
    'value',
    'icon' => 'fas fa-chart-bar',
    'color' => 'primary',
    'subtitle' => '',
])

@php
    $colorMap = [
        'primary' => ['bg' => '#FFF7ED', 'text' => '#D97706', 'icon' => '#F28B1E'],
        'success' => ['bg' => '#F1F8E9', 'text' => '#388E3C', 'icon' => '#4CAF50'],
        'warning' => ['bg' => '#FFFDE7', 'text' => '#F57F17', 'icon' => '#FFB300'],
        'danger'  => ['bg' => '#FBE9E7', 'text' => '#D84315', 'icon' => '#E64A19'],
        'info'    => ['bg' => '#E3F2FD', 'text' => '#1976D2', 'icon' => '#42A5F5'],
    ];
    $c = $colorMap[$color] ?? $colorMap['primary'];
@endphp

<div {{ $attributes->merge(['class' => 'card mb-3']) }}>
    <div class="card-body py-3">
        <div class="d-flex align-items-center">
            <div class="rounded-circle d-flex align-items-center justify-content-center mr-3"
                 style="width: 48px; height: 48px; background: {{ $c['bg'] }}; flex-shrink: 0;">
                <i class="{{ $icon }}" style="color: {{ $c['icon'] }}; font-size: 1.1rem;"></i>
            </div>
            <div class="flex-1 min-width-0">
                <div class="text-muted" style="font-size: 0.78rem; font-weight: 500;">{{ $label }}</div>
                <div style="font-size: 1.35rem; font-weight: 700; color: #1E293B; line-height: 1.2;">{{ $value }}</div>
                @if($subtitle)
                    <div style="font-size: 0.72rem; color: {{ $c['text'] }};">{{ $subtitle }}</div>
                @endif
            </div>
        </div>
    </div>
</div>
