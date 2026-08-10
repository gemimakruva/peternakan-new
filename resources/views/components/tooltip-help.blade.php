@props(['text', 'position' => 'top', 'icon' => 'question-circle'])

<span class="tooltip-help" onclick="this.classList.toggle('tooltip-open')" data-tooltip-pos="{{ $position }}">
    <i class="bi bi-{{ $icon }} tooltip-help-icon"></i>
    <span class="tooltip-help-bubble tooltip-{{ $position }}">{{ $text }}</span>
</span>

@once
@push('css')
<style>
.tooltip-help {
    position: relative;
    display: inline-flex;
    align-items: center;
    cursor: pointer;
    margin-left: 4px;
    vertical-align: middle;
}
.tooltip-help-icon {
    color: #9E9E9E;
    font-size: 0.85rem;
    transition: color 0.15s ease;
}
.tooltip-help:hover .tooltip-help-icon {
    color: #F28B1E;
}
.tooltip-help-bubble {
    position: absolute;
    z-index: 1050;
    background: #2D3436;
    color: #fff;
    font-size: 0.78rem;
    font-weight: 400;
    line-height: 1.4;
    padding: 8px 12px;
    border-radius: 8px;
    white-space: normal;
    width: max-content;
    max-width: 260px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    opacity: 0;
    pointer-events: none;
    transition: opacity 0.15s ease;
}
.tooltip-open .tooltip-help-bubble {
    opacity: 1;
    pointer-events: auto;
}
.tooltip-top {
    bottom: calc(100% + 8px);
    left: 50%;
    transform: translateX(-50%);
}
.tooltip-bottom {
    top: calc(100% + 8px);
    left: 50%;
    transform: translateX(-50%);
}
.tooltip-left {
    right: calc(100% + 8px);
    top: 50%;
    transform: translateY(-50%);
}
.tooltip-right {
    left: calc(100% + 8px);
    top: 50%;
    transform: translateY(-50%);
}
.tooltip-help-bubble::after {
    content: '';
    position: absolute;
    border: 6px solid transparent;
}
.tooltip-top::after {
    top: 100%;
    left: 50%;
    transform: translateX(-50%);
    border-top-color: #2D3436;
}
.tooltip-bottom::after {
    bottom: 100%;
    left: 50%;
    transform: translateX(-50%);
    border-bottom-color: #2D3436;
}
.tooltip-left::after {
    left: 100%;
    top: 50%;
    transform: translateY(-50%);
    border-left-color: #2D3436;
}
.tooltip-right::after {
    right: 100%;
    top: 50%;
    transform: translateY(-50%);
    border-right-color: #2D3436;
}
@media (max-width: 767.98px) {
    .tooltip-help-icon {
        font-size: 1rem;
        padding: 4px;
    }
    .tooltip-help-bubble {
        max-width: 220px;
        font-size: 0.82rem;
    }
}
</style>
@endpush
@push('js')
<script>
document.addEventListener('click', function(e) {
    if (!e.target.closest('.tooltip-help')) {
        document.querySelectorAll('.tooltip-help.tooltip-open').forEach(function(el) {
            el.classList.remove('tooltip-open');
        });
    }
});
</script>
@endpush
@endonce
