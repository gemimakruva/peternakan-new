<?php

return [
    'name' => 'GudangTelur',
    'menu' => [
        // ====================   Kemasan  ========================
        [
            'header' => 'Inventory Kemasan',
            'can'   => [
                'gudang-telur.supplier-kemasan.menu-supplier-kemasan',
                'gudang-telur.inventory-kemasan.menu-inventory-kemasan',
                'gudang-telur.input-kemasan.menu-input-kemasan',
                'gudang-telur.output-kemasan.menu-output-kemasan',
                'gudang-telur.opname-kemasan.menu-opname-kemasan',
            ],
        ],
        [
            'text'  => 'Supplier',
            'route' => 'gudang-telur.supplier.index',
            'icon'  => 'fas fa-clipboard-list',
            'active' => ['gudang-telur/supplier/*'],
            'can'   => 'gudang-telur.supplier-kemasan.menu-supplier-kemasan',
        ],
        [
            'text'  => 'Inventory Kemasan',
            'route' => 'gudang-telur.kemasan-inventory.index',
            'icon'  => 'fas fa-clipboard-list',
            'active' => ['gudang-telur/kemasan-inventory/*'],
            'can'   => 'gudang-telur.inventory-kemasan.menu-inventory-kemasan',
        ],
        [
            'text'  => 'Input Kemasan',
            'route' => 'gudang-telur.kemasan-input.index',
            'icon'  => 'fas fa-clipboard-list',
            'active' => ['gudang-telur/kemasan-input/*'],
            'can'   => 'gudang-telur.input-kemasan.menu-input-kemasan',
        ],
        [
            'text'  => 'Output Kemasan',
            'route' => 'gudang-telur.kemasan-output.index',
            'icon'  => 'fas fa-clipboard-list',
            'active' => ['gudang-telur/kemasan-output/*'],
            'can'   => 'gudang-telur.output-kemasan.menu-output-kemasan',
        ],
        [
            'text'  => 'Opname Kemasan',
            'route' => 'gudang-telur.kemasan-opname.index',
            'icon'  => 'fas fa-clipboard-list',
            'active' => ['gudang-telur/kemasan-opname/*'],
            'can'   => 'gudang-telur.opname-kemasan.menu-opname-kemasan',
        ],

        // ====================   Inventory Telur  ========================
        [
            'header' => 'Inventory Telur',
            'can'   => [
                'gudang-telur.telur-masuk.menu-telur-masuk',
                'gudang-telur.telur-keluar.menu-telur-keluar',
                'gudang-telur.telur-opname.menu-telur-opname',
                'gudang-telur.inventory-telur.menu-inventory-telur',
            ]
        ],
        [
            'text'  => 'Telur Masuk',
            'route' => 'gudang-telur.telur-masuk.index',
            'icon'  => 'fas fa-clipboard-list',
            'active' => ['gudang-telur/telur-masuk/*'],
            'can'   => 'gudang-telur.telur-masuk.menu-telur-masuk',
        ],
        [
            'text'  => 'Telur Keluar',
            'route' => 'gudang-telur.telur-keluar.index',
            'icon'  => 'fas fa-clipboard-list',
            'active' => ['gudang-telur/telur-keluar/*'],
            'can'   => 'gudang-telur.telur-keluar.menu-telur-keluar',
        ],
        [
            'text'  => 'Telur Opname',
            'route' => 'gudang-telur.telur-opname.index',
            'icon'  => 'fas fa-clipboard-list',
            'active' => ['gudang-telur/telur-opname/*'],
            'can'   => 'gudang-telur.telur-opname.menu-telur-opname',
        ],
        [
            'text'  => 'Inventory Telur',
            'route' => 'gudang-telur.telur-inventory.index',
            'icon'  => 'fas fa-clipboard-list',
            'active' => ['gudang-telur/telur-inventory/*'],
            'can'   => 'gudang-telur.inventory-telur.menu-inventory-telur',
        ],

        // ====================   Grading Telur  ========================
        [
            'header' => 'Grading Telur',
            'can'   => 'gudang-telur.grading-telur.menu-grading-telur',
        ],
        [
            'text'  => 'Grading Telur',
            'route' => 'gudang-telur.telur-grading.index',
            'icon'  => 'fas fa-clipboard-list',
            'active' => ['gudang-telur/telur-grading/*'],
            'can'   => 'gudang-telur.grading-telur.menu-grading-telur',
        ],
    ]
];
