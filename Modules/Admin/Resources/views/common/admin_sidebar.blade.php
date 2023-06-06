<!-- BEGIN: SideNav-->
<aside class="sidenav-main nav-expanded nav-lock nav-collapsible sidenav-light sidenav-active-square" id="sidebar">
    <!-- BEGIN: SideNav-->
    <div class="brand-sidebar">
        <h1 class="logo-wrapper"><a class="brand-logo darken-1" href="{{ route('admin.dashboard') }}"><img src="{{asset('front-assets/images/mantaray-logo.png') }}" alt="Mantaray"></a></h1>
    </div>
    <ul class="sidenav sidenav-collapsible leftside-navigation collapsible sidenav-fixed menu-shadow" id="slide-out" data-menu="menu-navigation" data-collapsible="menu-accordion">
        <li class="active bold"><a class="waves-effect waves-cyan" href="{{ route('admin.dashboard') }}"><i class="material-icons">settings_input_svideo</i><span class="menu-title" data-i18n="Dashboard">Dashboard</span></a>
        </li>
        @foreach ($menus_sidebar as $menu)
            <li class="bold"><a class="waves-effect waves-cyan " href="{{ route($menu->route) }}"><i class="material-icons">person</i><span class="menu-title" data-i18n="Chat">{{ $menu->title }}</span></a>
            </li>
        @endforeach
    </ul>
    <div class="navigation-background"></div><a class="sidenav-trigger btn-sidenav-toggle btn-floating btn-medium waves-effect waves-light hide-on-large-only" href="#" data-target="slide-out"><i class="material-icons">menu</i></a>
</aside>