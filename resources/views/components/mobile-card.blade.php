@props([
    'title' => '',
    'subtitle' => '',
    'badge' => '',
    'badgeClass' => 'badge-primary',
])

<div {{ $attributes->merge(['class' => 'mobile-data-card']) }}>
    <div class="mobile-data-card__header">
        <div class="mobile-data-card__title-group">
            @if($title)
                <div class="mobile-data-card__title">{{ $title }}</div>
            @endif
            @if($subtitle)
                <div class="mobile-data-card__subtitle">{{ $subtitle }}</div>
            @endif
        </div>
        @if($badge)
            <span class="badge {{ $badgeClass }}">{{ $badge }}</span>
        @endif
    </div>
    <div class="mobile-data-card__body">
        {{ $slot }}
    </div>
    @if(isset($actions))
        <div class="mobile-data-card__actions">
            {{ $actions }}
        </div>
    @endif
</div>

@once
@push('css')
<style>
.mobile-data-card {
    background: #fff;
    border: 1px solid #E2E8F0;
    border-radius: 10px;
    padding: 0;
    margin-bottom: 0.75rem;
    overflow: hidden;
}
.mobile-data-card__header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    padding: 0.85rem 1rem 0.5rem;
    gap: 0.5rem;
}
.mobile-data-card__title-group {
    flex: 1;
    min-width: 0;
}
.mobile-data-card__title {
    font-weight: 600;
    font-size: 0.9rem;
    color: #1E293B;
    line-height: 1.3;
}
.mobile-data-card__subtitle {
    font-size: 0.78rem;
    color: #94A3B8;
    margin-top: 0.15rem;
}
.mobile-data-card__body {
    padding: 0 1rem 0.75rem;
}
.mobile-data-card__body .data-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.3rem 0;
    font-size: 0.82rem;
    border-bottom: 1px solid #F1F5F9;
}
.mobile-data-card__body .data-row:last-child {
    border-bottom: none;
}
.mobile-data-card__body .data-row .data-label {
    color: #64748B;
    flex-shrink: 0;
    margin-right: 0.75rem;
}
.mobile-data-card__body .data-row .data-value {
    color: #1E293B;
    font-weight: 500;
    text-align: right;
}
.mobile-data-card__actions {
    display: flex;
    gap: 0.5rem;
    padding: 0.6rem 1rem;
    border-top: 1px solid #F1F5F9;
    background-color: #FAFBFC;
}
.mobile-data-card__actions .btn {
    flex: 1;
    font-size: 0.78rem;
}
</style>
@endpush
@endonce
