<aside class="main-sidebar {{ config('adminlte.classes_sidebar', 'sidebar-dark-primary elevation-4') }}">

    {{-- Sidebar brand logo --}}
    @if(config('adminlte.logo_img_xl'))
        @include('adminlte::partials.common.brand-logo-xl')
    @else
        @include('adminlte::partials.common.brand-logo-xs')
    @endif

    {{-- Sidebar menu --}}
    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-1 d-flex">
            <div class="image m-auto">
                <img src="{{Auth::user()->path_image == null ? asset('images/default.png'):asset(Auth::user()->path_image) }}" class="img-circle elevation-1" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{Auth::user()->employee->fname}} {{Auth::user()->employee->lname}} </a>
                <a href="#" class="d-block">{{session('company_name')}} </a>
            </div>
        </div>
        <nav class="pt-2">
            <ul class="nav nav-pills nav-sidebar flex-column {{ config('adminlte.classes_sidebar_nav', '') }}"
                data-widget="treeview" role="menu"
                @if(config('adminlte.sidebar_nav_animation_speed') != 300)
                    data-animation-speed="{{ config('adminlte.sidebar_nav_animation_speed') }}"
                @endif
                @if(!config('adminlte.sidebar_nav_accordion'))
                    data-accordion="false"
                @endif>
                {{-- Configured sidebar links --}}
                @each('adminlte::partials.sidebar.menu-item', $adminlte->menu('sidebar'), 'item')
            </ul>
        </nav>
    </div>

</aside>
