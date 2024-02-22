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

    'title' => 'Organics Stock',
    'title_prefix' => '',
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

    'use_ico_only' => false,
    'use_full_favicon' => false,

    /*
    |--------------------------------------------------------------------------
    | Logo
    |--------------------------------------------------------------------------
    |
    | Here you can change the logo of your admin panel.
    |
    | For detailed instructions you can look the logo section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'logo' => '&nbsp',
    'logo_img' => 'images/organicslogo.png',
    'logo_img_class' => 'brand-image img-circle elevation-0',
    'logo_img_xl' => null,
    'logo_img_xl_class' => 'brand-image-xs',
    'logo_img_alt' => 'OrganicsCosme',

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

    'usermenu_enabled' => true,
    'usermenu_header' => false,
    'usermenu_header_class' => 'bg-primary',
    'usermenu_image' => false,
    'usermenu_desc' => false,
    'usermenu_profile_url' => false,

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

    'layout_topnav' => null,
    'layout_boxed' => null,
    'layout_fixed_sidebar' => null,
    'layout_fixed_navbar' => null,
    'layout_fixed_footer' => null,
    'layout_dark_mode' => null,

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

    'classes_auth_card' => 'card-outline ogn-stock-cream',
    'classes_auth_header' => 'ogn-stock-green text-white',
    'classes_auth_body' => '',
    'classes_auth_footer' => 'ogn-stock-grey text-ogn-green rounded-bottom',
    'classes_auth_icon' => '',
    'classes_auth_btn' => 'btn-flat rounded btn-default text-ogn-green',

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

    'classes_body' => 'accent-success text-sm',
    'classes_brand' => '',
    'classes_brand_text' => '',
    'classes_content_wrapper' => '',
    'classes_content_header' => '',
    'classes_content' => '',
    'classes_sidebar' => 'sidebar-light-ogn-green elevation-2',
    'classes_sidebar_nav' => 'nav-legacy',
    'classes_topnav' => 'navbar-ogn-green navbar-light',
    'classes_topnav_nav' => 'navbar-expand',
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
    | Control Sidebar (Right Sidebar)
    |--------------------------------------------------------------------------
    |
    | Here we can modify the right sidebar aka control sidebar of the admin panel.
    |
    | For detailed instructions you can look the right sidebar section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'right_sidebar' => false,
    'right_sidebar_icon' => 'fas fa-cogs',
    'right_sidebar_theme' => 'dark',
    'right_sidebar_slide' => true,
    'right_sidebar_push' => true,
    'right_sidebar_scrollbar_theme' => 'os-theme-light',
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

    'use_route_url' => false,
    'dashboard_url' => 'home',
    'logout_url' => 'logout',
    'login_url' => 'login',
    'register_url' => '',
    'password_reset_url' => '',
    'password_email_url' => 'password/email',
    'profile_url' => false,

    /*
    |--------------------------------------------------------------------------
    | Laravel Mix
    |--------------------------------------------------------------------------
    |
    | Here we can enable the Laravel Mix option for the admin panel.
    |
    | For detailed instructions you can look the laravel mix section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Other-Configuration
    |
    */

    'enabled_laravel_mix' => true,
    'laravel_mix_css_path' => 'css/app.css',
    'laravel_mix_js_path' => 'js/app.js',

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
        // Navbar items:
        //        [
        //            'type'         => 'navbar-search',
        //            'text'         => 'search',
        //            'topnav_right' => false,
        //        ],
        [
            'type'         => 'fullscreen-widget',
            'topnav_right' => true,
        ],

        // Sidebar items:
        //        [
        //            'type' => 'sidebar-menu-search',
        //            'text' => 'search',
        //        ],
        //        [
        //            'text' => 'blog',
        //            'url'  => 'admin/blog',
        //            'can'  => 'manage-blog',
        //        ],
        [
            'text' => 'แผงควบคุม',
            'url'  => '/home',
            'icon' => 'fas fa-chart-pie',
            'active'     => ['regex:@^home@'],
            //            'can'  => 'admin',
        ],
        [
            'text' => 'กำหนดแผนงาน',
            'url'  => '/set_plan',
            'icon' => 'fas fa-calendar-alt',
            'active'     => ['regex:@^set_plan@'],
            'can' => 'admin'
        ],

        [
            'header' => "วัตถุดิบ",
            'can'  => ['material', 'qcmaterial', 'stockmaterial'],
        ],
        [

            'text'    => 'รับวัตถุดิบ',
            'icon'    => 'fas fa-arrow-alt-circle-down',
            'can'  => ['material', 'qcmaterial', 'stockmaterial'],
            'submenu' =>
            [
                [
                    'text' => 'เพิ่มรายการรับวัตถุดิบ',
                    'url'  => '/material/receive',
                    'icon' => 'fas fa-plus-circle',
                    'active' => ['regex:@^material/receive|^material/inspect/receive/transport/view@'],
                    'can'  => ['material', 'stockmaterial']
                    //                    'can'  => 'stock',
                ],
                [
                    'text' => 'ตรวจสอบวัตถุดิบ',
                    'url'  => '/material/inspect/receive',
                    'icon' => 'fas fa-clipboard-check',
                    'active'     => ['regex:@^material/inspect/receive(?!/transport/view)@'],
                    'can'  => ['material', 'qcmaterial']
                    //                    'can'  => 'qc',
                ],
                [
                    'text' => 'กรอก Lot.No RM',
                    'url'  => '/material/update/lot-no-pm',
                    'icon' => 'fas fa-tag',
                    'active' => ['regex:@^material/update/lot-no-pm@'],
                    'can'  => ['material', 'stockmaterial'],
                    //                    'can'  => 'qc',
                ],
                //                [
                //                    'text' => 'รายการรอดำเนินการรับเข้า',
                //                    'url'  => '/material/pending/receive',
                //                    'icon' => 'fas fa-paper-plane',
                //                    'active'     => ['regex:@^material/pending/receive@'],
                ////                    'can'  => 'stock',
                //                ],
                [
                    'text' => 'ประวัติการนำเข้าวัตถุดิบ',
                    'url'  => '/material/receive/master',
                    'icon' => 'fas fa-history',
                    'active'     => ['regex:@^material/receive/master@'],
                    'can'  => ['material', 'qcmaterial', 'stockmaterial']
                ],
            ]
        ],
        [
            'text'    => 'เบิกวัตถุดิบ',
            'icon'    => 'fas fa-arrow-alt-circle-up',
            'can'  => ['material', 'stockmaterial'],
            'submenu' =>
            [
                [
                    'text' => 'รายการเบิกวัตถุดิบ',
                    'url'  => '/material/requsition',
                    'icon' => 'fas fa-list',
                    'active'     => ['regex:@^material/requsition@'],
                    'can'  => ['material', 'stockmaterial']
                ],
                [
                    'text' => 'ตรวจสอบรายการเบิกวัตถุดิบ',
                    'url'  => '/material/inspect/requsition',
                    'icon' => 'fas fa-tasks',
                    'active'     => ['regex:@^material/inspect/requsition@'],
                    'can'  => ['material'],
                ],
                //                [
                //                    'text' => 'รายการรอดำเนินการเบิก',
                //                    'url'  => '/material/pending/requsition',
                //                    'icon' => 'fas fa-paper-plane',
                //                    'active'     => ['regex:@^material/pending/requsition@'],
                //                ],
                [
                    'text' => 'คืนวัตถุดิบ',
                    'url'  => '/material/return',
                    'icon' => 'fas fa-arrow-alt-circle-left',
                    'active'     => ['regex:@^material/requsition/return@'],
                    'can'  => ['material', 'stockmaterial']
                ],
                [
                    'text' => 'ตรวจสอบรายการคืนวัตถุดิบ',
                    'url'  => '/material/inspect/return/requsition/material',
                    'icon' => 'fas fa-clipboard-check',
                    'active'     => ['regex:@^material/inspect/return/requsition/material@'],
                    'can'  => ['material'],
                ],
                //                [
                //                    'text' => 'รายการรอดำเนินการคืน',
                //                    'url'  => '/material/pending/return/requsition',
                //                    'icon' => 'fas fa-paper-plane',
                //                    'active'     => ['regex:@^material/pending/return/requsition@'],
                //                ],
                [
                    'text' => 'ประวัติการเบิกวัตถุดิบ',
                    'url'  => '/material/history/requsition',
                    'icon' => 'fas fa-history',
                    'active'     => ['regex:@^material/history/requsition@'],
                    'can'  => ['material', 'stockmaterial']
                ],
            ]
        ],

        [
            'header' => "บรรจุภัณฑ์",
            'can'  => ['packagingsupply', 'qcpackaging', 'stockpackaging'],
        ],
        [

            'text'    => 'รับบรรจุภัณฑ์',
            'icon'    => 'fas fa-arrow-alt-circle-down',
            'can'  => ['packagingsupply', 'qcpackaging', 'stockpackaging'],
            'submenu' =>
            [
                [
                    'text' => 'เพิ่มรายการรับบรรจุภัณฑ์',
                    'url'  => '/packaging/receive',
                    'icon' => 'fas fa-plus-circle',
                    'active'     => ['regex:@^packaging/receive@'],
                    'can'  => ['packagingsupply', 'stockpackaging'],
                ],
                [
                    'text' => 'ตรวจสอบบรรจุภัณฑ์',
                    'url'  => '/packaging/inspect/receive',
                    'icon' => 'fas fa-clipboard-check',
                    'active'     => ['regex:@^/packaging/inspect/receive@'],
                    'can'  => ['packagingsupply', 'qcpackaging'],
                ],
                [
                    'text' => 'กรอก Lot.No PM',
                    'url'  => '/packaging/update/lot-no-pm',
                    'icon' => 'fas fa-tag',
                    'active'     => ['regex:@^packaging/update/lot-no-pm@'],
                    'can'  => ['packagingsupply', 'stockpackaging']
                ],
                [
                    'text' => 'รายการรอดำเนินการ',
                    'url'  => '/packaging/pending/receive',
                    'icon' => 'fas fa-paper-plane',
                    'active'     => ['regex:@^packaging/pending/receive@'],
                    'can'  => ['packagingsupply', 'stockpackaging']
                ],
                [
                    'text' => 'ประวัติการนำเข้าบรรจุภัณฑ์',
                    'url'  => '/packaging/history/receive',
                    'icon' => 'fas fa-history',
                    'active'     => ['regex:@^packaging/history/receive@'],
                    'can'  => ['packagingsupply', 'qcpackaging', 'stockpackaging']
                ],
            ]
        ],
        [

            'text'    => 'เบิกบรรจุภัณฑ์',
            'icon'    => 'fas fa-arrow-alt-circle-up',
            'can'  => ['packagingsupply', 'stockpackaging'],
            'submenu' =>
            [
                [
                    'text' => 'รายการเบิกบรรจุภัณฑ์.',
                    'url'  => '/packaging/requsition',
                    'icon' => 'fas fa-list',
                    'active'     => ['regex:@^packaging/requsition@'],
                    'can'  => ['packagingsupply', 'stockpackaging']
                ],
                [
                    'text' => 'ตรวจสอบรายการเบิกบรรจุภัณฑ์',
                    'url'  => '/packaging/inspect/requsition',
                    'icon' => 'fas fa-tasks',
                    'active'     => ['regex:@^packaging/requsition/inspect@'],
                    'can'  => ['packagingsupply']
                ],
                [
                    'text' => 'รายการรอดำเนินการเบิก',
                    'url'  => '/packaging/pending/requsition',
                    'icon' => 'fas fa-paper-plane',
                    'active'     => ['regex:@^packaging/pending/requsition@'],
                    'can'  => ['packagingsupply', 'stockpackaging'],
                ],
                [
                    'text' => 'คืนบรรจุภัณฑ์',
                    'url'  => '/packaging/return',
                    'icon' => 'fas fa-arrow-alt-circle-left',
                    'active'     => ['regex:@^packaging/return@'],
                    'can'  => ['packagingsupply', 'stockpackaging'],
                ],
                [
                    'text' => 'เคลมบรรจุภัณฑ์',
                    'url'  => '/packaging/claim',
                    'icon' => 'fas fa-history',
                    'active'     => ['regex:@^packaging/claim@'],
                    'can'  => ['packagingsupply', 'stockpackaging'],
                ],
                [
                    'text' => 'ตรวจสอบรายการคืนบรรจุภัณฑ์',
                    'url'  => '/packaging/inspect/return/requsition/packaging',
                    'icon' => 'fas fa-clipboard-check',
                    'active'     => ['regex:@^packaging/inspect/return/requsition/packaging@'],
                    'can'  => ['packagingsupply']
                ],
                [
                    'text' => 'รายการรอดำเนินการคืน',
                    'url'  => '/packaging/pending/return/requsition',
                    'icon' => 'fas fa-paper-plane',
                    'active'     => ['regex:@^packaging/pending/return/requsition@'],
                    'can'  => ['packagingsupply', 'stockpackaging'],
                ],
                [
                    'text' => 'ประวัติการเบิกบรรจุภัณฑ์',
                    'url'  => '/packaging/history/requsition',
                    'icon' => 'fas fa-history',
                    'active'     => ['regex:@^packaging/history/requsition@'],
                    'can'  => ['packagingsupply', 'stockpackaging']
                ],
            ]
        ],

        [
            'header' => "สินค้า",
            'can'  => 'finishproduct',
        ],
        [

            'text'    => 'รับสินค้า',
            'icon'    => 'fas fa-arrow-alt-circle-down',
            'can'  => 'finishproduct',
            'submenu' =>
            [
                [
                    'text' => 'เพิ่มรายการรับสินค้า',
                    'url'  => '/product/receive',
                    'icon' => 'fas fa-plus-circle',
                    'active'     => ['regex:@^product/receive@'],
                ],
                [
                    'text' => 'ตรวจสอบสินค้า',
                    'url'  => '/product/inspect/receive',
                    'icon' => 'fas fa-clipboard-check',
                    'active'     => ['regex:@^product/inspect/receive@'],
                ],
                [
                    'text' => 'รายการรอดำเนินการ',
                    'url'  => '/product/pending/receive',
                    'icon' => 'fas fa-paper-plane',
                    'active'     => ['regex:@^product/pending/receive@'],
                ],
                [
                    'text' => 'ประวัติการนำเข้าสินค้า',
                    'url'  => '/product/history/receive',
                    'icon' => 'fas fa-history',
                    'active'     => ['regex:@^product/history/receive@'],
                ],
            ]
        ],
        [

            'text'    => 'ส่งออกสินค้า',
            'icon'    => 'fas fa-arrow-alt-circle-up',
            'can'  => 'finishproduct',
            'submenu' =>
            [
                [
                    'text' => 'เพิ่มรายการส่งออกสินค้า',
                    'url'  => '/product/requsition',
                    'icon' => 'fas fa-plus-circle',
                    'active'     => ['regex:@^product/requsition@'],
                ],
                [
                    'text' => 'ตรวจสอบรายการส่งออก',
                    'url'  => '/product/inspect/requsition',
                    'icon' => 'fas fa-clipboard-check',
                    'active'     => ['regex:@^product/inspect/requsition@'],
                ],
                [
                    'text' => 'รายการรอดำเนินการ',
                    'url'  => '/product/pending/requsition',
                    'icon' => 'fas fa-paper-plane',
                    'active'     => ['regex:@^product/pending/requsition@'],
                ],
                [
                    'text' => 'ประวัติการส่งออกสินค้า',
                    'url'  => '/product/history/requsition',
                    'icon' => 'fas fa-history',
                    'active'     => ['regex:@^product/history/requsition@'],
                ],
            ]
        ],
        [
            'header' => "วัสดุสิ้นเปลือง",
            'can'  => 'packagingsupply',
        ],
        [

            'text'    => 'รับวัสดุสิ้นเปลือง',
            'icon'    => 'fas fa-arrow-alt-circle-down',
            'can'  => 'packagingsupply',
            'submenu' =>
            [
                [
                    'text' => 'เพิ่มรายการรับวัสดุสิ้นเปลือง',
                    'url'  => '/supply/receive',
                    'icon' => 'fas fa-plus-circle',
                    'active'     => ['regex:@^supply/receive@'],
                ],
                [
                    'text' => 'รายการรอดำเนินการ',
                    'url'  => '/supply/pending',
                    'icon' => 'fas fa-paper-plane',
                    'active'     => ['regex:@^supply/pending@'],
                ],
                [
                    'text' => 'ประวัติการนำเข้าวัสดุสิ้นเปลือง',
                    'url'  => '/supply/history/receive',
                    'icon' => 'fas fa-history',
                    'active'     => ['regex:@^supply/history/receive@'],
                ],
            ]
        ],
        [

            'text'    => 'เบิกวัสดุสิ้นเปลือง',
            'icon'    => 'fas fa-arrow-alt-circle-up',
            'can'  => 'packagingsupply',
            'submenu' =>
            [
                [
                    'text' => 'เพิ่มรายการเบิกวัสดุสิ้นเปลือง.',
                    'url'  => '/supply/requsition/create',
                    'icon' => 'fas fa-list',
                    'active'     => ['regex:@^supply/requsition@'],
                ],
                [
                    'text' => 'ประวัติการเบิกวัสดุสิ้นเปลือง',
                    'url'  => '/supply/history/requsition',
                    'icon' => 'fas fa-history',
                    'active'     => ['regex:@^supply/history/requsition@'],
                ],
            ]
        ],



        [
            'header' => "รายงาน",
            'can'  => 'admin',
        ],
        [

            'text'    => 'รายงานรับเข้า',
            'icon'    => 'fas fa-file-download',
            'can'  => 'admin',
            'submenu' =>
            [
                [
                    'text'    => 'รายงานการรับเข้าวัตถุดิบ',
                    'icon'    => 'fas fa-file-pdf',
                    'url'  => '/report/receive/material/list',
                    'active'     => ['regex:@^report/receive/material@'],
                ],
                [
                    'text'    => 'รายงานการรับเข้าบรรจุภัณฑ์',
                    'icon'    => 'fas fa-file-pdf',
                    'url'  => '/report/receive/packaging/list',
                    'active'     => ['regex:@^report/receive/packaging@'],
                ],
                [
                    'text'    => 'รายงานการรับเข้าสินค้า',
                    'icon'    => 'fas fa-file-pdf',
                    'url'  => '/report/receive/product/list',
                    'active'     => ['regex:@^report/receive/product@'],
                ],
                [
                    'text'    => 'รายงานการรับเข้าวัสดุสิ้นเปลือง',
                    'icon'    => 'fas fa-file-pdf',
                    'url'  => '/report/receive/supply/list',
                    'active'     => ['regex:@^report/receive/supply@'],
                ],
            ]
        ],
        [

            'text'    => 'รายงานเบิกออก',
            'icon'    => 'fas fa-file-upload',
            'can'  => 'admin',
            'submenu' =>
            [
                [
                    'text'    => 'รายงานการเบิกวัตถุดิบ',
                    'icon'    => 'fas fa-file-pdf',
                    'url'  => '/report/requsition/material/list',
                    'active'     => ['regex:@^report/requsition/material@'],
                ],
                [
                    'text'    => 'รายงานการเบิกบรรจุภัณฑ์',
                    'icon'    => 'fas fa-file-pdf',
                    'url'  => '/report/requsition/packaging/list',
                    'active'     => ['regex:@^report/requsition/packaging@'],
                ],
                [
                    'text'    => 'รายงานการเบิกสินค้า',
                    'icon'    => 'fas fa-file-pdf',
                    'url'  => '/report/requsition/product/list',
                    'active'     => ['regex:@^report/requsition/product@'],
                ],
                [
                    'text'    => 'รายงานการเบิกวัสดุสิ้นเปลือง',
                    'icon'    => 'fas fa-file-pdf',
                    'url'  => '/report/requsition/supply/list',
                    'active'     => ['regex:@^report/requsition/supply@'],
                ],
            ]
        ],

        [
            'header' => "รายการคงคลัง",
            'can'  => 'stockviewer',
        ],
        [

            'text'    => 'วัตถุดิบ',
            'icon'    => 'fas fa-balance-scale',
            'url'  => '/inventory/material/list',
            'active'     => ['regex:@^inventory/material@'],
            'can'  => 'stockviewer',
        ],
        [

            'text'    => 'บรรจุภัณฑ์',
            'icon'    => 'fas fa-box-open',
            'url'  => '/inventory/packaging/list',
            'active'     => ['regex:@^inventory/packaging@'],
            'can'  => 'stockviewer',
        ],
        [

            'text'    => 'สินค้า',
            'icon'    => 'fas fa-box',
            'url'  => '/inventory/product/list',
            'active'     => ['regex:@^inventory/product@'],
            'can'  => 'stockviewer',
        ],
        [

            'text'    => 'วัสดุสิ้นเปลือง',
            'icon'    => 'fas fa-box-tissue',
            'url'  => '/inventory/supply/list',
            'active'     => ['regex:@^inventory/supply@'],
            'can'  => 'stockviewer',
        ],


        [
            'header' => "ผู้ดูแลระบบ",
            'can' => 'admin'
        ],
        [

            'text'    => 'ตั้งค่าระดับแอดมิน',
            'icon'    => 'fas fa-fw fa-tools',
            'can' => 'admin',
            'submenu' =>
            [
                [
                    'text' => 'จัดการพนักงาน',
                    'url'  => '/employee',
                ],
                [
                    'text' => 'จัดการผู้ใช้',
                    'url'  => '/user',
                ],
                [
                    'text' => 'ประเภทสินค้า',
                    'url'  => '/category',
                ],
                [
                    'text' => 'วัตถุดิบ',
                    'url'  => '/material',
                ],
                [
                    'text' => 'บรรจุภัณฑ์',
                    'url'  => '/packaging',
                ],
                [
                    'text' => 'ผลิตภัณฑ์สำเร็จรูป',
                    'url'  => '/product',
                ],
                [
                    'text' => 'วัสดุสิ้นเปลือง',
                    'url'  => '/supply',
                ],
                [
                    'text' => 'บริษัทในเครือ',
                    'url'  => '/company',
                ],
                [
                    'text' => 'ตำแหน่ง',
                    'url'  => '/role',
                ],
                [
                    'text' => 'รถขนส่ง',
                    'url'  => '/vehicle',
                ],
                [
                    'text' => 'หัวข้อการตรวจสอบ',
                    'url'  => '/inspect-topic',
                ],
                [
                    'text' => 'แบบฟอร์มการตรวจสอบ',
                    'url'  => '/inspect-template',
                ],
                [
                    'text' => 'บริษัทคู่ค้า',
                    'url'  => '/view-vendor',
                ],
                [
                    'text' => 'ประเภทบรรจุภัณฑ์',
                    'url'  => '/packaging-type',
                ],
                [
                    'text' => 'หน่วยนับของวัตถุดิบ',
                    'url'  => '/material-unit',
                ],
                [
                    'text' => 'หน่วยนับของสินค้า',
                    'url'  => '/product-unit',
                ],
                [
                    'text' => 'หน่วยบรรจุของสินค้า',
                    'url'  => '/unit',
                ],
                [
                    'text' => 'ประเภทเครื่องสำอาง',
                    'url'  => '/cosmetics',
                ],
                [
                    'text' => 'ประเภทเครื่องอาหารเสริม',
                    'url'  => '/supplement',
                ],
                [
                    'text' => 'คำนำหน้าชื่อ',
                    'url'  => '/prefix',
                ],
            ]
        ],






        // [
        //     'text' => 'change_password',
        //     'url'  => 'admin/settings',
        //     'icon' => 'fas fa-fw fa-lock',
        // ],
        // [
        //     'text'    => 'multilevel',
        //     'icon'    => 'fas fa-fw fa-share',
        //     'submenu' => [
        //         [
        //             'text' => 'level_one',
        //             'url'  => '#',
        //         ],
        //         [
        //             'text'    => 'level_one',
        //             'url'     => '#',
        //             'submenu' => [
        //                 [
        //                     'text' => 'level_two',
        //                     'url'  => '#',
        //                 ],
        //                 [
        //                     'text'    => 'level_two',
        //                     'url'     => '#',
        //                     'submenu' => [
        //                         [
        //                             'text' => 'level_three',
        //                             'url'  => '#',
        //                         ],
        //                         [
        //                             'text' => 'level_three',
        //                             'url'  => '#',
        //                         ],
        //                     ],
        //                 ],
        //             ],
        //         ],
        //         [
        //             'text' => 'level_one',
        //             'url'  => '#',
        //         ],
        //     ],
        // ],
        // ['header' => 'labels'],
        // [
        //     'text'       => 'important',
        //     'icon_color' => 'red',
        //     'url'        => '#',
        // ],
        // [
        //     'text'       => 'warning',
        //     'icon_color' => 'yellow',
        //     'url'        => '#',
        // ],
        // [
        //     'text'       => 'information',
        //     'icon_color' => 'cyan',
        //     'url'        => '#',
        // ],
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
        'Datatables' => [
            'active' => false,
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
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.css',
                ],
            ],
        ],
        'Chartjs' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.0/Chart.bundle.min.js',
                ],
            ],
        ],
        'Sweetalert2' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.jsdelivr.net/npm/sweetalert2@8',
                ],
            ],
        ],
        'Pace' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/themes/blue/pace-theme-center-radar.min.css',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/pace.min.js',
                ],
            ],
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
    */

    'livewire' => false,
];
