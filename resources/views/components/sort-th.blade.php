@props([
    'label',
    'name'
])

@php
    $route = request()->route()->getName();

    // Ambil semua order (array)
    $orders = request()->query('orders', []);

    // Sort saat ini untuk kolom ini
    $sort = $orders[$name] ?? null;

    $nextOrders = match ($sort) {
        'asc'  => array_merge($orders, [$name => 'desc']),
        'desc' => collect($orders)->except($name)->toArray(),
        default => array_merge($orders, [$name => 'asc']),
    };

    $sortUrl = route(
        $route,
        array_merge(
            request()->except('orders'),
            empty($nextOrders) ? [] : ['orders' => $nextOrders]
        )
    );
@endphp


<th {{ $attributes->merge(['class' => 'user-select-none']) }}>
    <a href="{{ $sortUrl }}">
        <div class="d-flex justify-content-center align-items-center gap-1" style="cursor: pointer;">
            <span class="text-dark">{{ $label }}</span>

            @if ($sort === 'asc')
                <i class="fas fa-sort-up"></i>        
            @elseif ($sort === 'desc')
                <i class="fas fa-sort-down"></i>
            @else
                <i class="fas fa-sort text-muted"></i>
            @endif
        </div>
    </a>
</th>
