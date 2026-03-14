<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Title
    |--------------------------------------------------------------------------
    |
    | Here you can change the default title of your admin panel.
    |
    | For detailed instructions you can look the title section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'title'         => 'SPMS',
    'title_prefix'  => '',
    'title_postfix' => '',
    'description'   => '',

    /*
    |--------------------------------------------------------------------------
    | Favicon
    |--------------------------------------------------------------------------
    |
    | Here you can activate the favicon.
    |
    | For detailed instructions you can look the favicon section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'use_ico_only'     => false,
    'use_full_favicon' => false,

    /*
    |--------------------------------------------------------------------------
    | Google Fonts
    |--------------------------------------------------------------------------
    |
    | Here you can allow or not the use of external google fonts. Disabling the
    | google fonts may be useful if your admin panel internet access is
    | restricted somehow.
    |
    | For detailed instructions you can look the google fonts section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'google_fonts' => [
        'allowed' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Admin Panel Logo
    |--------------------------------------------------------------------------
    |
    | Here you can change the logo of your admin panel.
    |
    | For detailed instructions you can look the logo section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'logo'              => '<b>Admin</b>LTE',
    'logo_img'          => 'vendor/adminlte/dist/img/AdminLTELogo.png',
    'logo_img_class'    => 'brand-image img-circle elevation-3',
    'logo_img_xl'       => null,
    'logo_img_xl_class' => 'brand-image-xs',
    'logo_img_alt'      => 'Admin Logo',

    /*
    |--------------------------------------------------------------------------
    | Authentication Logo
    |--------------------------------------------------------------------------
    |
    | Here you can setup an alternative logo to use on your login and register
    | screens. When disabled, the admin panel logo will be used instead.
    |
    | For detailed instructions you can look the auth logo section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'auth_logo' => [
        'enabled' => false,
        'img'     => [
            'path'   => 'vendor/adminlte/dist/img/AdminLTELogo.png',
            'alt'    => 'Auth Logo',
            'class'  => '',
            'width'  => 50,
            'height' => 50,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Preloader Animation
    |--------------------------------------------------------------------------
    |
    | Here you can change the preloader animation configuration. Currently, two
    | modes are supported: 'fullscreen' for a fullscreen preloader animation
    | and 'cwrapper' to attach the preloader animation into the content-wrapper
    | element and avoid overlapping it with the sidebars and the top navbar.
    |
    | For detailed instructions you can look the preloader section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'preloader' => [
        'enabled' => false,
        'mode'    => 'fullscreen',
        'img'     => [
            'path'   => 'vendor/adminlte/dist/img/AdminLTELogo.png',
            'alt'    => 'AdminLTE Preloader Image',
            'effect' => 'animation__shake',
            'width'  => 60,
            'height' => 60,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | User Menu
    |--------------------------------------------------------------------------
    |
    | Here you can activate and change the user menu.
    |
    | For detailed instructions you can look the user menu section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'usermenu_enabled'      => true,
    'usermenu_header'       => true,
    'usermenu_header_class' => 'bg-primary',
    'usermenu_image'        => true,
    'usermenu_desc'         => true,
    'usermenu_profile_url'  => false,

    /*
    |--------------------------------------------------------------------------
    | Layout
    |--------------------------------------------------------------------------
    |
    | Here we change the layout of your admin panel.
    |
    | For detailed instructions you can look the layout section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'layout_topnav'        => null,
    'layout_boxed'         => null,
    'layout_fixed_sidebar' => null,
    'layout_fixed_navbar'  => null,
    'layout_fixed_footer'  => null,
    'layout_dark_mode'     => null,

    /*
    |--------------------------------------------------------------------------
    | Authentication Views Classes
    |--------------------------------------------------------------------------
    |
    | Here you can change the look and behavior of the authentication views.
    |
    | For detailed instructions you can look the auth classes section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'classes_auth_card'   => 'card-outline card-primary',
    'classes_auth_header' => '',
    'classes_auth_body'   => '',
    'classes_auth_footer' => '',
    'classes_auth_icon'   => '',
    'classes_auth_btn'    => 'btn-flat btn-primary',

    /*
    |--------------------------------------------------------------------------
    | Admin Panel Classes
    |--------------------------------------------------------------------------
    |
    | Here you can change the look and behavior of the admin panel.
    |
    | For detailed instructions you can look the admin panel classes here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'classes_body'             => '',
    'classes_brand'            => '',
    'classes_brand_text'       => '',
    'classes_content_wrapper'  => '',
    'classes_content_header'   => '',
    'classes_content'          => '',
    'classes_sidebar'          => 'sidebar-dark-primary elevation-4',
    'classes_sidebar_nav'      => '',
    'classes_topnav'           => 'navbar-white navbar-light',
    'classes_topnav_nav'       => 'navbar-expand',
    'classes_topnav_container' => 'container',

    /*
    |--------------------------------------------------------------------------
    | Sidebar
    |--------------------------------------------------------------------------
    |
    | Here we can modify the sidebar of the admin panel.
    |
    | For detailed instructions you can look the sidebar section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'sidebar_mini'                            => 'lg',
    'sidebar_collapse'                        => false,
    'sidebar_collapse_auto_size'              => false,
    'sidebar_collapse_remember'               => false,
    'sidebar_collapse_remember_no_transition' => true,
    'sidebar_scrollbar_theme'                 => 'os-theme-light',
    'sidebar_scrollbar_auto_hide'             => 'l',
    'sidebar_nav_accordion'                   => true,
    'sidebar_nav_animation_speed'             => 300,

    /*
    |--------------------------------------------------------------------------
    | Control Sidebar (Right Sidebar)
    |--------------------------------------------------------------------------
    |
    | Here we can modify the right sidebar aka control sidebar of the admin panel.
    |
    | For detailed instructions you can look the right sidebar section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'right_sidebar'                     => false,
    'right_sidebar_icon'                => 'fas fa-cogs',
    'right_sidebar_theme'               => 'dark',
    'right_sidebar_slide'               => true,
    'right_sidebar_push'                => true,
    'right_sidebar_scrollbar_theme'     => 'os-theme-light',
    'right_sidebar_scrollbar_auto_hide' => 'l',

    /*
    |--------------------------------------------------------------------------
    | URLs
    |--------------------------------------------------------------------------
    |
    | Here we can modify the url settings of the admin panel.
    |
    | For detailed instructions you can look the urls section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'use_route_url'           => true,
    'dashboard_url'           => 'home',
    'logout_url'              => 'logout',
    'login_url'               => 'login',
    'register_url'            => 'register',
    'password_reset_url'      => 'password/reset',
    'password_email_url'      => 'password/email',
    'profile_url'             => 'profile',
    'disable_darkmode_routes' => true,

    /*
    |--------------------------------------------------------------------------
    | Laravel Asset Bundling
    |--------------------------------------------------------------------------
    |
    | Here we can enable the Laravel Asset Bundling option for the admin panel.
    | Currently, the next modes are supported: 'mix', 'vite' and 'vite_js_only'.
    | When using 'vite_js_only', it's expected that your CSS is imported using
    | JavaScript. Typically, in your application's 'resources/js/app.js' file.
    | If you are not using any of these, leave it as 'false'.
    |
    | For detailed instructions you can look the asset bundling section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Other-Configuration
    |
    */

    'laravel_asset_bundling' => false,
    'laravel_css_path'       => 'css/app.css',
    'laravel_js_path'        => 'js/app.js',

    /*
    |--------------------------------------------------------------------------
    | Menu Items
    |--------------------------------------------------------------------------
    |
    | Here we can modify the sidebar/top navigation of the admin panel.
    |
    | For detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Menu-Configuration
    |
    */

    'menu' => [
        // Notification top right nav
        // [
        //     'type'            => 'navbar-notification',
        //     'id'              => 'my-notification',
        //     'icon'            => 'fas fa-bell',
        //     'url'             => 'notifications/show',
        //     'topnav_right'    => true,
        //     'dropdown_mode'   => true,
        //     'dropdown_flabel' => 'All notifications',
        //     'update_cfg'      => [
        //         'url'    => 'notifications/get',
        //         'period' => 30,
        //     ],
        // ],

        // Navbar items:
        [
            'type'         => 'navbar-search',
            'text'         => 'search',
            'topnav_right' => true,
        ],
        [
            'type'         => 'fullscreen-widget',
            'topnav_right' => true,
        ],

        // Sidebar items:
        [
            'type' => 'sidebar-menu-search',
            'text' => 'search',
        ],
        [
            'text'  => 'Home',
            'route' => 'home',
            'icon'  => 'fas fa-fw fa-home',
        ],
        // ==================== MASTER DATA ==========================
        [
            'header' => 'Master Data',
            'can'     => [
                'master-data.master-data.menu-peternakan',
                'master-data.master-data.menu-kandang',
                'master-data.master-data.menu-flock',
                'master-data.master-data.menu-list',
                'master-data.master-data.menu-jenis-pakan',
                'master-data.master-data.menu-jenis-treatment',
                'master-data.master-data.menu-metode-treatment',
                'master-data.master-data.menu-kemasan',
                'master-data.master-data.menu-bahan-pakan',
                'kandang.strain.menu-strain-list',
            ],
        ],
        [
            'text'    => 'Master Data',
            'icon'    => 'fas fa-database',
            'active'  => ['master-data/*'],
            'can'     => [
                
                
                
                
                
                // 'master-data.master-data.menu-jenis-treatment',
                // 'master-data.master-data.menu-metode-treatment',
                // 'kandang.strain.menu-strain-list',
            ],
            'submenu' => [
                [
                    'text'  => 'Strain Ayam',
                    'route' => 'master-data.strain-ayam.index',
                    'icon'  => 'far fa-circle',
                    'can'   => 'kandang.strain.menu-strain-list',
                ],
                [
                    'text'  => 'Peternakan',
                    'route' => 'master-data.peternakan.index',
                    'icon'  => 'far fa-circle',
                    'active' => ['master-data/peternakan*'],
                    'can'   => 'master-data.master-data.menu-peternakan',
                ],
                [
                    'text'  => 'Kandang',
                    'route' => 'master-data.kandang.index',
                    'icon'  => 'far fa-circle',
                    'active' => ['master-data/kandang*'],
                    'can'   => 'master-data.master-data.menu-kandang',
                ],
                [
                    'text'  => 'Flock',
                    'route' => 'master-data.flock.index',
                    'icon'  => 'far fa-circle',
                    'active' => ['master-data/flock*'],
                    'can'   => 'master-data.master-data.menu-flock',
                ],
                [
                    'text'  => 'Pipa',
                    'route' => 'master-data.pipe.index',
                    'icon'  => 'far fa-circle',
                    'active' => ['master-data/pipe*'],
                    'can'   => 'master-data.master-data.menu-pipe',
                ],
                [
                    'text'  => 'Jenis Pakan',
                    'route' => 'master-data.jenis-pakan.index',
                    'icon'  => 'far fa-circle',
                    'active' => ['master-data/jenis-pakan*'],
                    'can'   => 'master-data.master-data.menu-jenis-pakan',
                ],
                [
                    'text'  => 'Jenis Treatment',
                    'route' => 'master-data.jenis-treatment.index',
                    'icon'  => 'far fa-circle',
                    'active' => ['master-data/jenis-treatment*'],
                    'can'   => 'master-data.master-data.menu-jenis-treatment',
                ],
                [
                    'text'  => 'Metode Treatment',
                    'route' => 'master-data.metode-treatment.index',
                    'icon'  => 'far fa-circle',
                    'active' => ['master-data/metode-treatment*'],
                    'can'   => 'master-data.master-data.menu-metode-treatment',
                ],
                [
                    'text'  => 'Kemasan',
                    'route' => 'gudang-telur.master-data.kemasan.index',
                    'icon'  => 'far fa-circle',
                    'active' => ['gudang-telur/master-data/kemasan*'],
                    'can'   => 'master-data.master-data.menu-kemasan',
                ],
                [
                    'text'  => 'Bahan Pakan',
                    'route' => 'gudang-pakan.master-data.bahan-pakan.index',
                    'icon'  => 'far fa-circle',
                    'active' => ['gudang-pakan/master-data/bahan-pakan*'],
                    'can'   => 'master-data.master-data.menu-bahan-pakan',
                ],
            ],
        ],

        // ==================== REKAPAN PRODUKSI ==========================
        [
            'header' => 'Rekapan Produksi',
            'can'   => 'kandang.rekapan.menu-rekapan-produksi',
        ],
        [
            'text'  => 'Rekapan Produksi',
            'route' => 'rekapan-produksi.index',
            'icon'  => 'fas fa-chart-line',
            'can'   => 'kandang.rekapan.menu-rekapan-produksi',
            'active' => ['rekapan-produksi', 'rekapan-produksi/detail']
        ],
        [
            'text'  => 'Laporan Harian',
            'route' => 'rekapan-produksi.report.daily',
            'icon'  => 'fas fa-chart-line',
            'can'   => 'kandang.rekapan.menu-rekapan-produksi',
        ],
        [
            'text'  => 'Laporan Mingguan',
            'route' => 'rekapan-produksi.report.weekly',
            'icon'  => 'fas fa-chart-line',
            'can'   => 'kandang.rekapan.menu-rekapan-psroduksi',
        ],

        // ====================  POPULASI  ==========================
        [
            'header' => 'Populasi Ayam',
            'can'   => [
                'kandang.populasi.menu-pengadaan-ayam',
                'kandang.populasi.menu-populasi-ayam',
                'kandang.populasi.menu-rekapan-populasi-ayam',
                'kandang.populasi.menu-afkir-ayam',
                'kandang.populasi.menu-karantina-ayam',
                'kandang.populasi.menu-rekapan-karantina',
            ],
        ],
        [
            'text'  => 'Pengadaan Ayam',
            'route' => 'pengadaan-ayam.index',
            'icon'  => 'fas fa-clipboard-list',
            'active' => ['pengadaan-ayam/*'],
            'can'   => 'kandang.populasi.menu-pengadaan-ayam',
        ],
        [
            'text'  => 'Populasi Ayam',
            'route' => 'populasi-ayam-2.index',
            'icon'  => 'fas fa-clipboard-list',
            'active' => ['populasi-ayam-2/*'],
            'can'   => 'kandang.populasi.menu-populasi-ayam',
        ],
        [
            'text'  => 'Rekapan Populasi Ayam',
            'route' => 'rekapan-populasi-ayam.index',
            'icon'  => 'fas fa-chart-line',
            'active' => ['rekapan-populasi-ayam/*'],
            'can'   => 'kandang.populasi.menu-rekapan-populasi-ayam',
        ],
        [
            'text'  => 'Ayam Afkir',
            'route' => 'ayam-afkir.index',
            'icon'  => 'fas fa-clipboard-list',
            'active' => ['ayam-afkir/*'],
            'can'   => 'kandang.populasi.menu-afkir-ayam',
        ],
        [
            'text'  => 'Ayam Karantina',
            'route' => 'ayam-karantina.index',
            'icon' => 'fas fa-clipboard-list',
            'active'  => ['ayam-karantina/*'],
            'can'   => 'kandang.populasi.menu-karantina-ayam',
        ],
        // [
        //     'text'  => 'Rekapan Karantina',
        //     'route' => 'ayam-karantina.overview',
        //     'icon'  => 'fas fa-chart-line',
        //     'active'  => ['ayam-karantina-overview'],
        //     'can'   => 'kandang.populasi.menu-rekapan-karantina',
        // ],
        

        // ====================   PEMBERIAN PAKAN  ==========================
        [
            'header' => 'Pemberian Pakan',
            'can' => [
                'kandang.pakan.menu-perhitungan-pemberian-pakan',
                'kandang.pakan.menu-pemberian-pakan-dan-sisa-pakan',
                'kandang.pakan.menu-rekapan-pakan-harian',
            ],
        ],
        [
            'text'  => 'Perhitungan Pemberian Pakan',
            'route' => 'perhitungan-pakan.index',
            'icon'  => 'fas fa-clipboard-list',
            'active' => ['perhitungan-pakan/*'],
            'can'   => 'kandang.pakan.menu-perhitungan-pemberian-pakan',
        ],
        [
            'text'  => 'Pemberian Pakan Sisa Pakan',
            'route' => 'pemberian-pakan-sisa-pakan.index',
            'icon'  => 'fas fa-clipboard-list',
            'active' => ['pemberian-pakan-sisa-pakan/*'],
            'can'   => 'kandang.pakan.menu-pemberian-pakan-dan-sisa-pakan',
        ],
        [
            'text'  => 'Rekapan Pakan Harian',
            'route' => 'overview-pakan-harian',
            'icon'  => 'fas fa-chart-line',
            'active' => ['overview-pakan-harian'],
            'can'   => 'kandang.pakan.menu-rekapan-pakan-harian',
        ],

        // ====================   PRODUKSI TELUR  ==================
        [
            'header' => 'Produksi Telur',
            'can'   => [
                'kandang.telur.menu-produksi-telur',
                'kandang.telur.menu-rekapan-produksi-telur',
            ]
        ],
        [
            'text'  => 'Produksi Telur',
            'route' => 'recording-telur.index',
            'icon'  => 'fas fa-egg',
            'active' => ['recording-telur/*'],
            'can'   => 'kandang.telur.menu-produksi-telur',
        ],
        [
            'text'  => 'Rekapan Produksi Telur',
            'route' => 'overview-produksi-telur',
            'icon'  => 'fas fa-chart-line',
            'active' => ['overview-produksi-telur'],
            'can'   => 'kandang.telur.menu-rekapan-produksi-telur',
        ],

        // ====================   SAMPLING AYAM MENU    ==========================
        [
            'header' => 'Sampling Bobot Ayam',
            'can'   => [
                'kandang.sampling.menu-sampling-bobot-ayam'
            ],
        ],
        [
            'text'  => 'Sampling Bobot Ayam',
            'route' => 'sampling-ayam.index',
            'icon'  => 'fas fa-clipboard-list',
            'active' => ['sampling-ayam/*'],
            'can'   => 'kandang.sampling.menu-sampling-bobot-ayam',
        ],

        // ====================   PENJADWALAAN TREATMENT  =================
        [
            'header' => 'Kalender Treatment',
            'can'    => [
                'kandang.treatment.menu-penjadwalan-treatment',
                'kandang.treatment.menu-pelaksanaan-treatment',
            ],
        ],
        [
            'text'  => 'Penjadwalan Treatment',
            'icon'  => 'fas fa-clipboard-list',
            'route' => 'treatment.index',
            'active' => ['treatment/*'],
            'can' => 'kandang.treatment.menu-penjadwalan-treatment',
        ],
        [
            'text'  => 'Pelaksanaan Treatment',
            'icon'  => 'fas fa-clipboard-list',
            'route' => 'treatment-pelaksanaan.index',
            'active' => ['treatment-pelaksanaan/*'],
            'can'   => 'kandang.treatment.menu-pelaksanaan-treatment',
        ],

        // ====================   Monitoring Kesehatan  ========================
        [
            'header' => 'Monitoring Kesehatan',
            'can'    => 'kandang.monitoring.menu-monitoring-kesehatan',
        ],
        [
            'text'  => 'Monitoring Kesehatan',
            'route' => 'monitoring-kesehatan.index',
            'icon'  => 'fas fa-clipboard-list',
            'active' => ['monitoring-kesehatan/*'],
            'can'   => 'kandang.monitoring.menu-monitoring-kesehatan',
        ],

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

        // ====================   USER AND ACCESS   ============================
        [
            'header' => 'User and Access',
            'can'    => [
                'master-data.setting.menu-user',
                'master-data.setting.menu-role-permission',
            ],
        ],
        [
            'text'  => 'User',
            'route' => 'user.index',
            'icon'  => 'fas fa-fw fa-cube',
            'can'   => 'master-data.setting.menu-user',
        ],
        [
            'text'  => 'Role',
            'route' => 'role.index',
            'icon'  => 'fas fa-fw fa-cube',
            'can'   => 'master-data.setting.menu-role-permission',
        ],

        // ====================   Setting   ============================
        [
            'text'  => 'Setting',
            'route' => 'setting.general',
            'icon'  => 'fas fa-fw fa-cube',
            'can'   => 'master-data.setting.menu-setting',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Menu Filters
    |--------------------------------------------------------------------------
    |
    | Here we can modify the menu filters of the admin panel.
    |
    | For detailed instructions you can look the menu filters section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Menu-Configuration
    |
    */

    'filters' => [
        JeroenNoten\LaravelAdminLte\Menu\Filters\GateFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\HrefFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\SearchFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ActiveFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ClassesFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\LangFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\DataFilter::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Plugins Initialization
    |--------------------------------------------------------------------------
    |
    | Here we can modify the plugins used inside the admin panel.
    |
    | For detailed instructions you can look the plugins section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Plugins-Configuration
    |
    */

    'plugins' => [
        'AlpineJs' => [
            'active' => true,
            'files'  => [
                [
                    'type'     => 'js',
                    'asset'    => false,
                    'location' => 'https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.13.1/cdn.min.js',
                    'defer'    => true,
                ],
            ]
        ],
        'BootstrapIcons' => [
            'active' => true,
            'files'  => [
                [
                    'type'     => 'css',
                    'asset'    => false,
                    'location' => 'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css',
                ],
            ],
        ],
        'Datatables' => [
            'active' => false,
            'files'  => [
                [
                    'type'     => 'js',
                    'asset'    => false,
                    'location' => '//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js',
                ],
                [
                    'type'     => 'js',
                    'asset'    => false,
                    'location' => '//cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js',
                ],
                [
                    'type'     => 'css',
                    'asset'    => false,
                    'location' => '//cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css',
                ],
            ],
        ],
        'Select2' => [
            'active' => true,
            'files'  => [
                [
                    'type'     => 'js',
                    'asset'    => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js',
                ],
                [
                    'type'     => 'css',
                    'asset'    => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.css',
                ],
                [
                    'type'     => 'css',
                    'asset'    => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-theme/0.1.0-beta.10/select2-bootstrap.min.css',
                ],
                // [
                //     'type' => 'js',
                //     'asset' => true,
                //     'location' => 'vendor/select2/js/select2.full.min.js',
                // ],
                // [
                //     'type' => 'css',
                //     'asset' => true,
                //     'location' => 'vendor/select2/css/select2.min.css',
                // ],
                [
                    'type'     => 'css',
                    'asset'    => true,
                    'location' => 'vendor/select2-bootstrap4-theme/select2-bootstrap4.min.css',
                ],
            ],
        ],
        'Chartjs' => [
            'active' => true,
            'files'  => [
                [
                    'type'     => 'js',
                    'asset'    => false,
                    'location' => '//cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js',
                ],
                [
                    'type'     => 'js',
                    'asset'    => false,
                    'location' => '//cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.2.0',
                ],
            ],
        ],
        'Sweetalert2' => [
            'active' => true,
            'files'  => [
                [
                    'type'     => 'js',
                    'asset'    => false,
                    'location' => 'https://cdn.jsdelivr.net/npm/sweetalert2@11',
                ],
            ],
        ],
        'Pace' => [
            'active' => false,
            'files'  => [
                [
                    'type'     => 'css',
                    'asset'    => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/themes/blue/pace-theme-center-radar.min.css',
                ],
                [
                    'type'     => 'js',
                    'asset'    => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/pace.min.js',
                ],
            ],
        ],
        'BsCustomFileInput' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/bs-custom-file-input/bs-custom-file-input.min.js',
                ],
            ],
        ],
        'BootstrapSwitch' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/bootstrap-switch/js/bootstrap-switch.min.js',
                ],
            ],
        ],
        'Summernote' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/summernote/summernote-bs4.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => 'vendor/summernote/summernote-bs4.min.css',
                ],
            ],
            'defaultConfig' => [
                "height" => "100",
                "toolbar" => [
                    ['style', ['style']],
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['view', ['fullscreen', 'codeview', 'help']],
                ],
            ]
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | IFrame
    |--------------------------------------------------------------------------
    |
    | Here we change the IFrame mode configuration. Note these changes will
    | only apply to the view that extends and enable the IFrame mode.
    |
    | For detailed instructions you can look the iframe mode section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/IFrame-Mode-Configuration
    |
    */

    'iframe' => [
        'default_tab' => [
            'url'   => null,
            'title' => null,
        ],
        'buttons' => [
            'close'           => true,
            'close_all'       => true,
            'close_all_other' => true,
            'scroll_left'     => true,
            'scroll_right'    => true,
            'fullscreen'      => true,
        ],
        'options' => [
            'loading_screen'    => 1000,
            'auto_show_new_tab' => true,
            'use_navbar_items'  => true,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Livewire
    |--------------------------------------------------------------------------
    |
    | Here we can enable the Livewire support.
    |
    | For detailed instructions you can look the livewire here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Other-Configuration
    |
    */

    'livewire' => false,
];
