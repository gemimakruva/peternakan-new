<?php

return [
    'name' => 'GudangPakan',
    'menu' => [
        // ====================   Inventory Bahan Pakan   ============================
        [
            'header' => 'Inventory Bahan Pakan',
            'can'   => [
                'gudang-pakan.supplier-bahan-pakan.menu-supplier-bahan-pakan',
                'gudang-pakan.bahan-pakan-pembelian.menu-bahan-pakan-pembelian',
                'gudang-pakan.bahan-pakan-masuk.menu-bahan-pakan-masuk',
                'gudang-pakan.bahan-pakan-inventory.menu-bahan-pakan-inventory',
            ],
        ],
        [
            'text'  => 'Supplier Bahan Pakan',
            'route' => 'gudang-pakan.supplier-bahan-pakan.index',
            'icon'  => 'fas fa-clipboard-list',
            'active' => ['gudang-pakan/supplier-bahan-pakan/*'],
            'can'   => 'gudang-pakan.supplier-bahan-pakan.menu-supplier-bahan-pakan',
        ],
        [
            'text'  => 'Pembelian Bahan Pakan',
            'route' => 'gudang-pakan.bahan-pakan-pembelian.index',
            'icon'  => 'fas fa-clipboard-list',
            'active' => ['gudang-pakan/bahan-pakan-pembelian/*'],
            'can'   => 'gudang-pakan.bahan-pakan-pembelian.menu-bahan-pakan-pembelian',
        ],
        [
            'text'  => 'Bahan Pakan Masuk',
            'route' => 'gudang-pakan.bahan-pakan-masuk.index',
            'icon'  => 'fas fa-clipboard-list',
            'active' => ['gudang-pakan/bahan-pakan-masuk/*'],
            'can'   => 'gudang-pakan.bahan-pakan-masuk.menu-bahan-pakan-masuk',
        ],
        [
            'text'  => 'Bahan Pakan Keluar',
            'route' => 'gudang-pakan.bahan-pakan-keluar.index',
            'icon'  => 'fas fa-clipboard-list',
            'active' => ['gudang-pakan/bahan-pakan-keluar/*'],
            'can'   => 'gudang-pakan.bahan-pakan-keluar.menu-bahan-pakan-keluar',
        ],
        [
            'text'  => 'Bahan Pakan Opname',
            'route' => 'gudang-pakan.bahan-pakan-opname.index',
            'icon'  => 'fas fa-clipboard-list',
            'active' => ['gudang-pakan/bahan-pakan-opname/*'],
            'can'   => 'gudang-pakan.bahan-pakan-opname.menu-bahan-pakan-opname',
        ],
        [
            'text'  => 'Bahan Pakan Inventory',
            'route' => 'gudang-pakan.bahan-pakan-inventory.index',
            'icon'  => 'fas fa-clipboard-list',
            'active' => ['gudang-pakan/bahan-pakan-inventory/*'],
            'can'   => 'gudang-pakan.bahan-pakan-inventory.menu-bahan-pakan-inventory',
        ],

        // ====================   Mixing Bahan Pakan   ============================
        [
            'header' => 'Mixing Bahan Pakan',
            'can'   => [
                'gudang-pakan.bahan-pakan-formulasi.menu-bahan-pakan-formulasi',
            ],
        ],
        [
            'text'  => 'Formulasi Pakan',
            'route' => 'gudang-pakan.bahan-pakan-formulasi.index',
            'icon'  => 'fas fa-clipboard-list',
            'active' => ['gudang-pakan/bahan-pakan-formulasi/*'],
            'can'   => 'gudang-pakan.bahan-pakan-formulasi.menu-bahan-pakan-formulasi',
        ],
        [
            'text'  => 'Pre Mixing Pakan',
            'route' => 'gudang-pakan.pakan-pre-mixing.index',
            'icon'  => 'fas fa-clipboard-list',
            'active' => ['gudang-pakan/pakan-pre-mixing/*'],
            'can'   => 'gudang-pakan.pakan-pre-mixing.menu-pakan-pre-mixing',
        ],
        [
            'text'  => 'Opname Pre Mixing',
            'route' => 'gudang-pakan.pakan-pre-mixing-opname.index',
            'icon'  => 'fas fa-clipboard-list',
            'active' => ['gudang-pakan/pakan-pre-mixing-opname/*'],
            'can'   => 'gudang-pakan.pakan-pre-mixing-opname.menu-pakan-pre-mixing-opname',
        ],
        [
            'text'  => 'Inventory Pre Mixing',
            'route' => 'gudang-pakan.pakan-pre-mixing-inventory.index',
            'icon'  => 'fas fa-clipboard-list',
            'active' => ['gudang-pakan/pakan-pre-mixing-inventory/*'],
            'can'   => 'gudang-pakan.pakan-pre-mixing-inventory.menu-pakan-pre-mixing-inventory',
        ],
        [
            'text'  => 'Mixing Pakan',
            'route' => 'gudang-pakan.pakan-mixing.index',
            'icon'  => 'fas fa-clipboard-list',
            'active' => ['gudang-pakan/pakan-mixing/*'],
            'can' => 'gudang-pakan.pakan-mixing.menu-pakan-mixing',
        ],
        [
            'text'  => 'Opname Pakan Jadi',
            'route' => 'gudang-pakan.pakan-finished-good-opname.index',
            'icon'  => 'fas fa-clipboard-list',
            'active' => ['gudang-pakan/pakan-finished-good-opname/*'],
            'can' => 'gudang-pakan.pakan-finished-good-opname.menu-pakan-finished-good-opname',
        ],
        [
            'text'  => 'Inventory Pakan Jadi',
            'route' => 'gudang-pakan.pakan-finished-good-inventory.index',
            'icon'  => 'fas fa-clipboard-list',
            'active' => ['gudang-pakan/pakan-finished-good-inventory/*'],
            'can' => 'gudang-pakan.pakan-finished-good-inventory.menu-pakan-finished-good-inventory',
        ],
        [
            'text'  => 'Distribusi Pakan Jadi',
            'route' => 'gudang-pakan.pakan-finished-good-distribusi.index',
            'icon'  => 'fas fa-clipboard-list',
            'active' => ['gudang-pakan/pakan-finished-good-distribusi/*'],
            'can' => 'gudang-pakan.pakan-finished-good-distribusi.menu-pakan-finished-good-distribusi',
        ],
    ]
];
