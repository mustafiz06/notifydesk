<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Title
    |--------------------------------------------------------------------------
    */

    'title' => 'NotifyDesk',
    'title_prefix' => '',
    'title_postfix' => '',

    /*
    |--------------------------------------------------------------------------
    | Favicon
    |--------------------------------------------------------------------------
    */

    'favicon' => ['path' => 'favicon.ico', 'type' => 'image/x-icon'],

    /*
    |--------------------------------------------------------------------------
    | Logo
    |--------------------------------------------------------------------------
    */

    'logo' => '<b>Notify</b>Desk',
    'logo_img' => 'vendor/adminlte/dist/img/AdminLTELogo.png',
    'logo_img_class' => 'brand-image img-circle elevation-3',
    'logo_img_xl' => null,
    'logo_img_xl_class' => 'brand-image-xs',
    'logo_img_alt' => 'NotifyDesk Logo',

    /*
    |--------------------------------------------------------------------------
    | User Menu
    |--------------------------------------------------------------------------
    */

    'usermenu_enabled' => true,
    'usermenu_header' => true,
    'usermenu_header_class' => 'bg-primary',
    'usermenu_image' => true,
    'usermenu_desc' => true,
    'usermenu_profile_url' => false, // ✅ Disabled to avoid adminlte_profile_url() error

    /*
    |--------------------------------------------------------------------------
    | Layout
    |--------------------------------------------------------------------------
    */

    'layout_topnav' => null,
    'layout_boxed' => null,
    'layout_fixed_sidebar' => true,
    'layout_fixed_navbar' => true,
    'layout_fixed_footer' => null,
    'layout_dark_mode' => null,

    /*
    |--------------------------------------------------------------------------
    | Authentication Routes
    |--------------------------------------------------------------------------
    */

    'auth_password_reset_url' => 'password/reset',
    'auth_password_change_url' => 'profile/password',
    'auth_register_url' => 'register',
    'auth_logout_url' => 'logout',
    'auth_profile_url' => 'profile',
    'auth_login_url' => 'login',
    'auth_dashboard_url' => 'dashboard',

    /*
    |--------------------------------------------------------------------------
    | Classes
    |--------------------------------------------------------------------------
    */

    'classes_body' => '',
    'classes_brand' => '',
    'classes_brand_text' => '',
    'classes_content_wrapper' => '',
    'classes_content_header' => '',
    'classes_content' => '',
    'classes_sidebar' => 'sidebar-dark-primary elevation-4',
    'classes_sidebar_nav' => '',
    'classes_topnav' => 'navbar-white navbar-light',
    'classes_topnav_nav' => 'navbar-expand',
    'classes_topnav_container' => 'container',

    /*
    |--------------------------------------------------------------------------
    | Sidebar
    |--------------------------------------------------------------------------
    */

    'sidebar_mini' => 'lg',
    'sidebar_collapse' => false,
    'sidebar_collapse_auto_size' => false,
    'sidebar_collapse_remember' => false,
    'sidebar_collapse_remember_no_transition' => true,
    'sidebar_scrollbar_theme' => 'os-theme-light',
    'sidebar_scrollbar_auto_hide' => 'l',
    'sidebar_nav_accordion' => true,
    'sidebar_nav_animation_speed' => 300,

    /*
    |--------------------------------------------------------------------------
    | Menu
    |--------------------------------------------------------------------------
    */

    'menu' => [
        // Search Bar
        [
            'text' => 'Search',
            'search' => true,
            'top' => true,
        ],

        // Dashboard
        [
            'text' => 'Dashboard',
            'route' => 'home',
            'icon' => 'fas fa-tachometer-alt',
            'active' => ['home'],
            'label' => 'Main',
            'label_color' => 'success',
        ],

        // Campaigns Section
        [
            'header' => 'CAMPAIGNS',
        ],
        [
            'text' => 'All Campaigns',
            'route' => 'campaigns.index',
            'icon' => 'fas fa-rocket',
            'active' => ['campaigns.*'],
        ],
        [
            'text' => 'Create Campaign',
            'route' => 'campaigns.create',
            'icon' => 'fas fa-plus-circle',
            'label' => 'New',
            'label_color' => 'success',
        ],

        // Messages Section
        [
            'header' => 'MESSAGES',
        ],
        [
            'text' => 'Email',
            'route' => 'messages.create',
            'routeParameters' => ['channel' => 'email'],
            'icon' => 'fas fa-envelope',
            'icon_color' => 'primary',
        ],
        [
            'text' => 'SMS',
            'route' => 'messages.create',
            'routeParameters' => ['channel' => 'sms'],
            'icon' => 'fas fa-sms',
            'icon_color' => 'warning',
        ],
        [
            'text' => 'WhatsApp',
            'route' => 'messages.create',
            'routeParameters' => ['channel' => 'whatsapp'],
            'icon' => 'fab fa-whatsapp',
            'icon_color' => 'success',
        ],
        [
            'text' => 'Bulk Messages',
            'route' => 'messages.bulk',
            'icon' => 'fas fa-paper-plane',
            'label' => 'Bulk',
            'label_color' => 'info',
        ],

        // Contacts Section
        [
            'header' => 'CONTACTS',
        ],
        [
            'text' => 'All Contacts',
            'route' => 'contacts.index',
            'icon' => 'fas fa-address-book',
        ],
        [
            'text' => 'Import Contacts',
            'route' => 'contacts.import',
            'icon' => 'fas fa-file-import',
        ],
        [
            'text' => 'Groups',
            'route' => 'contacts.groups',
            'icon' => 'fas fa-users',
        ],

        // Analytics Section
        [
            'header' => 'ANALYTICS',
        ],
        [
            'text' => 'Reports',
            'route' => 'analytics.reports',
            'icon' => 'fas fa-chart-bar',
        ],
        [
            'text' => 'Performance',
            'route' => 'analytics.performance',
            'icon' => 'fas fa-chart-pie',
        ],

        // Account Settings Section
        [
            'header' => 'ACCOUNT SETTINGS',
        ],
        [
            'text' => 'My Profile',
            'route' => 'profile.index',
            'icon' => 'fas fa-user-circle',
            'active' => ['profile.*'],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Menu Filters
    |--------------------------------------------------------------------------
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
    | Plugins
    |--------------------------------------------------------------------------
    */

    'plugins' => [
        'Datatables' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css',
                ],
            ],
        ],
        'Select2' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css',
                ],
            ],
        ],
        'Chartjs' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js',
                ],
            ],
        ],
        'iCheck' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/icheck/1.0.2/icheck.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/icheck/1.0.2/skins/square/blue.css',
                ],
            ],
        ],
        'Sweetalert2' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.jsdelivr.net/npm/sweetalert2@11',
                ],
            ],
        ],
        'Moment' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js',
                ],
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | IFrame
    |--------------------------------------------------------------------------
    */

    'iframe' => [
        'default_tab' => [
            'url' => null,
            'title' => null,
        ],
        'buttons' => [
            'close' => true,
            'close_all' => true,
            'close_all_other' => true,
            'scroll_left' => true,
            'scroll_right' => true,
            'fullscreen' => true,
        ],
        'options' => [
            'loading_screen' => 1000,
            'auto_show_new_tab' => true,
            'use_navbar_items' => true,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Livewire
    |--------------------------------------------------------------------------
    */

    'livewire' => false,

    /*
    |--------------------------------------------------------------------------
    | Additional CSS
    |--------------------------------------------------------------------------
    */

    'extra_css' => [
        'css/custom.css',
    ],

    /*
    |--------------------------------------------------------------------------
    | Additional JS
    |--------------------------------------------------------------------------
    */

    'extra_js' => [
        'js/custom.js',
    ],

    /*
    |--------------------------------------------------------------------------
    | Right Sidebar
    |--------------------------------------------------------------------------
    */

    'right_sidebar' => false,
    'right_sidebar_push' => false,
    'right_sidebar_scrollbar_theme' => 'os-theme-light',
    'right_sidebar_scrollbar_auto_hide' => 'l',

];