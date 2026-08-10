@props(['tourId' => 'default'])

@auth
@unless(auth()->user()->has_seen_tour ?? false)
<button type="button"
    class="btn btn-sm btn-panduan"
    id="btn-panduan-{{ $tourId }}"
    onclick="if(typeof startTour==='function')startTour('{{ $tourId }}')">
    <i class="bi bi-lightbulb"></i>
    <span class="d-none d-sm-inline">Panduan</span>
</button>
@endunless
@endauth

@once
@push('css')
<style>
.btn-panduan {
    background: linear-gradient(135deg, #F28B1E, #D97706);
    color: #fff;
    border: none;
    border-radius: 20px;
    padding: 6px 14px;
    font-size: 0.8rem;
    font-weight: 500;
    display: inline-flex;
    align-items: center;
    gap: 5px;
    box-shadow: 0 2px 8px rgba(242, 139, 30, 0.3);
    transition: all 0.2s ease;
}
.btn-panduan:hover {
    background: linear-gradient(135deg, #D97706, #B45309);
    color: #fff;
    box-shadow: 0 4px 12px rgba(242, 139, 30, 0.4);
    transform: translateY(-1px);
}
.btn-panduan .bi {
    font-size: 0.9rem;
}
@media (max-width: 767.98px) {
    .btn-panduan {
        position: fixed;
        bottom: 76px;
        right: 16px;
        z-index: 1040;
        border-radius: 50%;
        width: 44px;
        height: 44px;
        padding: 0;
        justify-content: center;
    }
    .btn-panduan span {
        display: none !important;
    }
}
</style>
@endpush
@endonce
