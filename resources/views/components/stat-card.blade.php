@props([
    'label',
    'value',
    'icon' => 'fas fa-chart-bar',
    'color' => 'primary',
    'subtitle' => '',
])

@php
    $colorMap = [
        'primary' => ['bg' => '#EEF1FE', 'text' => '#4F6AF6', 'icon' => '#4F6AF6'],
        'success' => ['bg' => '#F0FDF4', 'text' => '#22C55E', 'icon' => '#22C55E'],
        'warning' => ['bg' => '#FFFBEB', 'text' => '#D97706', 'icon' => '#F59E0B'],
        'danger'  => ['bg' => '#FEF2F2', 'text' => '#EF4444', 'icon' => '#EF4444'],
        'info'    => ['bg' => '#EFF6FF', 'text' => '#3B82F6', 'icon' => '#3B82F6'],
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
