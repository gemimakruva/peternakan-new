@auth
@php
$user = auth()->user();
$roleName = $user->roles->first()?->name ?? '';

$navItems = match($roleName) {
    'Superadmin' => [
        ['label' => 'Dashboard', 'icon' => 'bi-house-fill', 'route' => 'home'],
        ['label' => 'Kandang', 'icon' => 'bi-buildings', 'route' => 'master-data.kandang.index'],
        ['label' => 'G. Pakan', 'icon' => 'bi-box-seam-fill', 'route' => 'gudang-pakan.bahan-pakan-formulasi.edit', 'match' => 'gudang-pakan.*'],
        ['label' => 'G. Telur', 'icon' => 'bi-egg-fill', 'route' => 'gudang-telur.telur-masuk.index', 'match' => 'gudang-telur.*'],
    ],
    'Admin User' => [
        ['label' => 'Dashboard', 'icon' => 'bi-house-fill', 'route' => 'home'],
        ['label' => 'Users', 'icon' => 'bi-people-fill', 'route' => 'user.index'],
        ['label' => 'Roles', 'icon' => 'bi-shield-lock-fill', 'route' => 'role.index'],
        ['label' => 'Settings', 'icon' => 'bi-gear-fill', 'route' => 'setting.general'],
    ],
    'Manager Produksi' => [
        ['label' => 'Dashboard', 'icon' => 'bi-house-fill', 'route' => 'home'],
        ['label' => 'Rekapan', 'icon' => 'bi-graph-up', 'route' => 'rekapan-produksi.index'],
        ['label' => 'Populasi', 'icon' => 'bi-bar-chart-fill', 'route' => 'populasi-ayam-2.index'],
        ['label' => 'Telur', 'icon' => 'bi-egg-fill', 'route' => 'recording-telur.index'],
    ],
    'SPV Kandang' => [
        ['label' => 'Dashboard', 'icon' => 'bi-house-fill', 'route' => 'home'],
        ['label' => 'Populasi', 'icon' => 'bi-bar-chart-fill', 'route' => 'populasi-ayam-2.index'],
        ['label' => 'Pakan', 'icon' => 'bi-box-seam-fill', 'route' => 'perhitungan-pakan.index'],
        ['label' => 'Telur', 'icon' => 'bi-egg-fill', 'route' => 'recording-telur.index'],
    ],
    'Petugas Kandang' => [
        ['label' => 'Dashboard', 'icon' => 'bi-house-fill', 'route' => 'home'],
        ['label' => 'Populasi', 'icon' => 'bi-bar-chart-fill', 'route' => 'populasi-ayam-2.index', 'match' => 'populasi-ayam*'],
        ['label' => 'Pakan', 'icon' => 'bi-box-seam-fill', 'route' => 'perhitungan-pakan.index', 'match' => '*pakan*'],
        ['label' => 'Sampling', 'icon' => 'bi-clipboard-data-fill', 'route' => 'sampling-ayam.index'],
    ],
    'Dokter Hewan' => [
        ['label' => 'Dashboard', 'icon' => 'bi-house-fill', 'route' => 'home'],
        ['label' => 'Treatment', 'icon' => 'bi-capsule', 'route' => 'treatment.index'],
        ['label' => 'Monitoring', 'icon' => 'bi-heart-pulse-fill', 'route' => 'monitoring-kesehatan.index'],
    ],
    'Petugas Gudang Telur' => [
        ['label' => 'Dashboard', 'icon' => 'bi-house-fill', 'route' => 'home'],
        ['label' => 'Grading', 'icon' => 'bi-star-fill', 'route' => 'gudang-telur.telur-masuk.index', 'match' => 'gudang-telur.*'],
        ['label' => 'Telur', 'icon' => 'bi-egg-fill', 'route' => 'recording-telur.index'],
        ['label' => 'Supplier', 'icon' => 'bi-truck', 'route' => 'gudang-telur.supplier.index'],
    ],
    'Petugas Gudang Pakan' => [
        ['label' => 'Dashboard', 'icon' => 'bi-house-fill', 'route' => 'home'],
        ['label' => 'Formulasi', 'icon' => 'bi-moisture', 'route' => 'gudang-pakan.bahan-pakan-formulasi.edit', 'match' => '*bahan-pakan*'],
        ['label' => 'Mixing', 'icon' => 'bi-shuffle', 'route' => 'perhitungan-pakan.index', 'match' => '*mixing*'],
        ['label' => 'Stok', 'icon' => 'bi-check2-circle', 'route' => 'gudang-pakan.pakan-finished-good-inventory.show', 'match' => '*finished-good*'],
    ],
    default => [
        ['label' => 'Dashboard', 'icon' => 'bi-house-fill', 'route' => 'home'],
    ],
};

$navItems[] = ['label' => 'Menu', 'icon' => 'bi-list', 'route' => null, 'action' => 'pushmenu'];
@endphp

<nav class="bottom-nav d-md-none" id="bottomNav">
    @foreach($navItems as $item)
        @php
            $isActive = false;
            if (isset($item['route']) && $item['route']) {
                $matchPattern = $item['match'] ?? $item['route'];
                $isActive = request()->routeIs($matchPattern);
            }
            $href = '#';
            if (isset($item['route']) && $item['route']) {
                try { $href = route($item['route']); } catch (\Exception $e) { $href = '#'; }
            }
        @endphp
        <a href="{{ $href }}"
           class="bottom-nav__item {{ $isActive ? 'bottom-nav__item--active' : '' }}"
           @if(isset($item['action']) && $item['action'] === 'pushmenu')
               onclick="event.preventDefault(); document.querySelector('[data-widget=pushmenu]')?.click();"
           @endif
        >
            <i class="bi {{ $item['icon'] }}"></i>
            <span>{{ $item['label'] }}</span>
        </a>
    @endforeach
</nav>

@once
@push('css')
<style>
.bottom-nav {
    position: fixed;
    bottom: 0;
    left: 0;
    right: 0;
    height: 60px;
    background: #FFFFFF;
    border-top: 1px solid #E8E4DF;
    display: flex;
    align-items: stretch;
    justify-content: space-around;
    z-index: 1035;
    box-shadow: 0 -2px 8px rgba(0,0,0,0.06);
    padding-bottom: env(safe-area-inset-bottom, 0);
}
.bottom-nav__item {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    flex: 1;
    min-width: 48px;
    min-height: 48px;
    color: #9E9E9E;
    text-decoration: none;
    font-size: 0.65rem;
    font-weight: 500;
    gap: 2px;
    transition: color 0.15s ease;
    -webkit-tap-highlight-color: transparent;
}
.bottom-nav__item i {
    font-size: 1.25rem;
    line-height: 1;
}
.bottom-nav__item--active {
    color: #F28B1E;
}
.bottom-nav__item:hover,
.bottom-nav__item:focus {
    color: #F28B1E;
    text-decoration: none;
}
</style>
@endpush
@endonce
@endauth
