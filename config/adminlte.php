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
    'profile_url'             => 'user.index',
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
        ],
        [
            'text'    => 'Master Data',
            'icon'    => 'fas fa-database',
            'active'  => ['master-data/*'],
            'submenu' => [
                [
                    'text'  => 'Strain Ayam',
                    'route' => 'master-data.strain-ayam.index',
                    'icon'  => 'far fa-circle',
                ],
                [
                    'text'  => 'Peternakan',
                    'route' => 'master-data.peternakan.index',
                    'icon'  => 'far fa-circle',
                    'active' => ['master-data/peternakan*'],
                ],
                [
                    'text'  => 'Kandang',
                    'route' => 'master-data.kandang.index',
                    'icon'  => 'far fa-circle',
                    'active' => ['master-data/kandang*'],
                ],
                [
                    'text'  => 'Baris',
                    'route' => 'master-data.flock.index',
                    'icon'  => 'far fa-circle',
                    'active' => ['master-data/flock*'],
                ],
                [
                    'text'  => 'Pipa',
                    'route' => 'master-data.pipe.index',
                    'icon'  => 'far fa-circle',
                    'active' => ['master-data/pipe*'],
                ],
                [
                    'text'  => 'Jenis Pakan',
                    'route' => 'master-data.jenis-pakan.index',
                    'icon'  => 'far fa-circle',
                    'active' => ['master-data/jenis-pakan*'],
                ],
                [
                    'text'  => 'Jenis Disinfektan',
                    'route' => 'master-data.jenis-disinfektan.index',
                    'icon'  => 'far fa-circle',
                    'active' => ['master-data/jenis-disinfektan*'],
                ],
                [
                    'text'  => 'Jenis Treatment',
                    'route' => 'master-data.jenis-treatment.index',
                    'icon'  => 'far fa-circle',
                    'active' => ['master-data/jenis-treatment*'],
                ],
                [
                    'text'  => 'Metode Treatment',
                    'route' => 'master-data.metode-treatment.index',
                    'icon'  => 'far fa-circle',
                    'active' => ['master-data/metode-treatment*'],
                ],
            ],
        ],

        // ==================== RIWAYAT KESELURUHAN ==========================
        [
            'header' => 'Riwayat Keseluruhan',
        ],
        [
            'text'  => 'Rekapan Produksi',
            'route' => '',
            'icon'  => 'fas fa-clipboard-list',
        ],

        // ====================  MENU PENGADAAN AYAM  ==========================
        [
            'header' => 'Pengadaan Ayam',
        ],
        [
            'text'  => 'Overview',
            'route' => 'pengadaan-ayam.index',
            'icon'  => 'fas fa-clipboard-check',
        ],
        [
            'text'  => 'Pengadaan Ayam',
            'route' => 'pengadaan-ayam.create',
            'icon'  => 'fas fa-plus-circle',
        ],

        // ====================  MENU RECORDING HARIAN  ==========================

        [
            'header' => 'Recording Harian',
        ],
        [
            'text'  => 'Pencatatan Harian',
            'route' => 'populasi-ayam.create',
            'icon'  => 'fas fa-clipboard-list',
        ],

        // ====================   PENGADAAN AYAM AFKIR  ==========================

        [
            'header' => 'Ayam Afkir',
        ],
        [
            'text'  => 'Riwayat Ayam Afkir',
            'route' => 'ayam-afkir.index',
            'icon'  => 'fas fa-clipboard-list',
        ],
        [
            'text'  => 'Form Ayam Afkir',
            'route' => 'ayam-afkir.create',
            'icon'  => 'fas fa-plus-circle',
        ],

        // ====================   PENGADAAN AYAM KARANTINA  ==========================

        [
            'header' => 'Ayam Karantina',
        ],
        [
            'text'    => 'Ayam Karantina',
            'icon'    => 'fas fa-home',
            'submenu' => [
                [
                    'text'  => 'Overview',
                    'route' => 'ayam-karantina.overview',
                    'icon'  => 'fas fa-clipboard-check',
                ],
                [
                    'text'  => 'Form Ayam Karantina',
                    'route' => 'ayam-karantina.create',
                    'icon'  => 'fas fa-plus-circle',
                ],
                [
                    'text'  => 'Riwayat Karantina',
                    'route' => 'ayam-karantina.index',
                    'icon'  => 'fas fa-history',
                ],
                [
                    'text'  => 'Ayam Masuk Karantina',
                    'route' => 'ayam-karantina.masuk',
                    'icon'  => 'fas fa-arrow-right',
                ],
                [
                    'text'  => 'Ayam Keluar Karantina',
                    'route' => 'ayam-karantina.keluar',
                    'icon'  => 'fas fa-arrow-left',
                ],
            ]
        ],
        

        // ====================   PEMBERIAN PAKAN  ==========================
        [
            'header' => 'Pemberian Pakan',
        ],
        [
            'text'    => 'Pakan Harian',
            'icon'    => 'fas fa-calculator',
            'submenu' => [
                [
                    'text'  => 'List Data Harian',
                    'route' => 'perhitungan-pakan.listdata',
                    'icon'  => 'fas fa-history',
                ],
                [
                    'text'  => 'Form Harian',
                    'route' => 'perhitungan-pakan.create',
                    'icon'  => 'fas fa-plus',
                ],
            ],
        ],
        [
            'text'    => 'Sisa pakan',
            'icon'    => 'fas fa-box-open',
            'submenu' => [
                [
                    'text'  => 'List Data Sisa Pakan',
                    'route' => 'sisa-pakan.listDataSisaPakanHarian',
                    'icon'  => 'fas fa-history',
                ],
                [
                    'text'  => 'Form Sisa Pakan',
                    'route' => 'sisa-pakan.create',
                    'icon'  => 'fas fa-plus',
                ],
            ],
        ],
        [
            'text'  => 'Rekapan Pakan Harian',
            'route' => 'perhitungan-pakan.index',
            'icon'  => 'fas fa-clipboard-list',
        ],

        // ====================   RECORDING PRODUKSI TELUR  ==================
        [
            'header' => 'Recording Telur',
        ],
        [
            'text'  => 'Tambah Recording Telur',
            'route' => 'recording-telur.create',
            'icon'  => 'fas fa-plus-circle',
        ],
        [
            'text'  => 'Overview',
            'route' => 'recording-telur.index',
            'icon'  => 'fas fa-clipboard-check',
        ],

        // ====================   SAMPLING AYAM MENU    ==========================
        [
            'header' => 'Sampling Ayam',
        ],
        [
            'text'  => 'Rekapan Sampling',
            'route' => 'sampling-ayam.index',
            'icon'  => 'fas fa-clipboard-list',
        ],
        [
            'text'  => 'Tambah Sampling',
            'route' => 'sampling-ayam.create',
            'icon'  => 'fas fa-plus-circle',
        ],

        // ====================   PENJADWALAAN TREATMENT  =================
        [
            'header' => 'Kalender Treatment',
        ],
        [
            'text'  => 'Treatment',
            'icon'  => 'fas fa-calendar-alt',
            'submenu' =>[
                [
                    'text'  => 'Form Treatment',
                    'route' => 'penjadwalan-treatment.create',
                    'icon'  => 'fas fa-plus',
                ],
                [
                    'text'  => 'Jadwalan Treatment',
                    'route' => 'penjadwalan-treatment.index',
                    'icon'  => 'fas fa-calendar',
                ],
            ]
        ],
        [
            'text'  => 'Disinfektan',
            'icon'  => 'fas fa-calendar-alt',
            'submenu' => [
                [
                    'text'  => 'List Penjadwalan',
                    'route' => 'penjadwalan-disinfektan.index',
                    'icon'  => 'fas fa-history',
                ],
                [
                    'text'  => 'Form Penjadwalan Disinfektan',
                    'route' => 'penjadwalan-disinfektan.create',
                    'icon'  => 'fas fa-plus',
                ],
            ],
        ],

        // ====================   Perhitungan Obat  =================
        [
            'header' => 'Perhitungan Obat',
        ],
        [
            'text'  => 'OVK via Pakan',
            'icon'  => 'fas fa-clipboard-list',
             'submenu' => [
                [
                    'text'  => 'Jadwal OVK',
                    'route' => 'ovk-pakan.index',
                    'icon'  => 'fas fa-history',
                ],
                  
                [
                    'text'  => 'Create OVK',
                    'route' => 'ovk-pakan.create',
                    'icon'  => 'fas fa-plus',
                ],
              
            ],
        ],
        [
            'text'  => 'Order OVK',
            'icon'  => 'fas fa-clipboard-list',
            'submenu' => [
                [
                    'text'  => 'List Order ',
                    'route' => 'order-ovk.index',
                    'icon' => 'fas fa-clipboard-list',
                    'can'   => 'Request order bahan untuk OVK ',
                ],
                [
                    'text'  => 'Form Order',
                    'route' => 'order-ovk.create',
                    'icon'  => 'fas fa-plus',
                    'can'   => 'tambah list penjadwalan disinfektan',
                ],
            ],
        ],
        [
            'text'  => 'Vaksin Minum',
            'icon'  => 'fas fa-clipboard-list',
            'can'   => 'Lihat Rekapan Pakan Harian',
            'submenu' => [
                [
                    'text'  => 'List Data Vaksin Minum',
                    'route' => 'vaksin-minum.index',
                    'icon'  => 'fas fa-history',
                    'can'   => 'Lihat list data vaksin minum',
                ],
                [
                    'text'  => 'Form Vaksin Minum',
                    'route' => 'vaksin-minum.create',
                    'icon'  => 'fas fa-plus',
                    'can'   => 'Lihat list data vaksin minum',
                ],
            ],
        ],

        [
            'text'  => 'Vitamin Obat Minum',
            'route' => '',
            'icon'  => 'fas fa-clipboard-list',
            'can'   => 'Lihat obat vitamin minum',
            'submenu' => [
                [
                    'text'  => 'List Vitamin Obat Minum',
                    'route' => 'perhitungan-obat.vitamin-obat-minum.index',
                    'icon'  => 'fas fa-history',
                    'can'   => 'Lihat obat vitamin minum',
                ],
                [
                    'text'  => 'Tambah Vitamin Obat Minum',
                    'route' => 'perhitungan-obat.vitamin-obat-minum.create',
                    'icon'  => 'fas fa-plus',
                    'can'   => 'Tambah obat vitamin minum',
                ],
            ],
        ],
        [
            'text'  => 'Bahan Treatment',
            'route' => '',
            'icon'  => 'fas fa-vials',
            'can'   => 'Lihat Rekapan Pakan Harian',
        ],
        [
            'text'  => 'Form Pelaksanaan',
            'route' => '',
            'icon'  => 'fas fa-file-signature',
            'can'   => 'Lihat Rekapan Pakan Harian',
        ],

        // ====================   Monitoring Kesehatan  ========================
        [
            'header' => 'Monitoring Kesehatan',
            'can'    => [
                'Lihat Pemberian Pakan',
                'Lihat Perhitungan Pakan',
                'Lihat Sisa Pakan',
                'Lihat Rekapan Pakan Harian',
            ],
        ],
        [
            'text'  => 'Form Monitoring',
            'route' => 'monitoring-kesehatan.create',
            'icon'  => 'fas fa-clipboard-check',
            'can'   => 'Lihat Rekapan Pakan Harian',
        ],
        [
            'text'  => 'Riwayat Monitoring',
            'route' => 'monitoring-kesehatan.index',
            'icon'  => 'fas fa-history',
            'can'   => 'Lihat Rekapan Pakan Harian',
        ],

        // ====================   USER AND ACCESS   ============================

        [
            'header' => 'User and Access',
            'can'    => [
                'Lihat Semua User',
                'Lihat Semua Role',
            ],
        ],
        [
            'text'  => 'User',
            'route' => 'user.index',
            'icon'  => 'fas fa-fw fa-cube',
            'can'   => 'Lihat Semua User',
        ],
        [
            'text'  => 'Role',
            'route' => 'role.index',
            'icon'  => 'fas fa-fw fa-cube',
            'can'   => 'Lihat Semua Role',
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
        'BootstrapIcons' => [
            'active' => true,
            'files'  => [
                [
                    'type'     => 'css',
                    'asset'    => false,
                    'location' => 'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css',
                ],
                [
                    'type'     => 'js',
                    'asset'    => false,
                    'location' => 'https://cdn.jsdelivr.net/npm/chart.js',
                ],
                [
                    'type'     => 'js',
                    'asset'    => false,
                    'location' => 'https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.13.1/cdn.min.js',
                    'defer'    => true,
                ],
            ],
            [
                'type'     => 'js',
                'asset'    => false,
                'location' => 'https://cdn.jsdelivr.net/npm/sweetalert2@11',
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
            'active' => false,
            'files'  => [
                [
                    'type'     => 'js',
                    'asset'    => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.0/Chart.bundle.min.js',
                ],
            ],
        ],
        'Sweetalert2' => [
            'active' => true,
            'files'  => [
                [
                    'type'     => 'js',
                    'asset'    => false,
                    'location' => '//cdn.jsdelivr.net/npm/sweetalert2@8',
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
