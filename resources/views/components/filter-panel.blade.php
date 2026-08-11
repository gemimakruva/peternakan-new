@props([
    'action' => '',
    'method' => 'GET',
    'title' => 'Filter',
    'resetUrl' => '',
])

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center" data-toggle="collapse" data-target="#filterCollapse" role="button" style="cursor: pointer;">
        <h3 class="card-title mb-0">
            <i class="fas fa-filter mr-1" style="font-size: 0.8rem;"></i> {{ $title }}
        </h3>
        <i class="fas fa-chevron-down d-sm-none" style="font-size: 0.75rem; transition: transform 0.2s;"></i>
    </div>

    <div class="collapse show" id="filterCollapse">
        <div class="card-body">
            <form action="{{ $action }}" method="{{ $method }}" class="filter-form" {{ $attributes }}>
                <div class="row align-items-end">
                    {{ $slot }}
                    <div class="col-12 col-sm-auto mt-2 mt-sm-0">
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search"></i>
                                <span class="d-sm-none ml-1">Cari</span>
                            </button>
                            @if($resetUrl)
                                <a href="{{ $resetUrl }}" class="btn btn-secondary">
                                    <i class="fas fa-undo"></i>
                                    <span class="d-sm-none ml-1">Reset</span>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@once
@push('css')
<style>
@media (max-width: 575.98px) {
    .filter-form .row > [class*="col"] {
        margin-bottom: 0.5rem;
    }
    .filter-form .row > [class*="col"]:last-child {
        margin-bottom: 0;
    }
}
</style>
@endpush
@endonce
