<!-- BEGIN: SideNav-->
<aside class="sidenav-main nav-expanded nav-lock nav-collapsible sidenav-light sidenav-active-square" id="sidebar">
    <!-- BEGIN: SideNav-->
    <div class="brand-sidebar">
        <h1 class="logo-wrapper"><a class="brand-logo darken-1" href="{{ route('admin.dashboard') }}"><span class="logo-text hide-on-med-and-down">Mantaray Admin</span></a><a class="navbar-toggler" href="#"><i class="material-icons">radio_button_unchecked</i></a></h1>
    </div>
    <ul class="sidenav sidenav-collapsible leftside-navigation collapsible sidenav-fixed menu-shadow" id="slide-out" data-menu="menu-navigation" data-collapsible="menu-accordion">
        <li class="active bold"><a class="waves-effect waves-cyan" href="dashboard.html"><i class="material-icons">settings_input_svideo</i><span class="menu-title" data-i18n="Dashboard">Dashboard</span></a>
        </li>
        <li class="bold"><a class="waves-effect waves-cyan " href="{{ route('admin.user') }}"><i class="material-icons">person</i><span class="menu-title" data-i18n="Chat">Manage Users</span></a>
        </li>
        <li class="bold"><a class="waves-effect waves-cyan " href="{{ route('admin.role') }}"><i class="material-icons">person</i><span class="menu-title" data-i18n="Chat">Manage Roles</span></a>
        </li>
        <li class="bold"><a class="waves-effect waves-cyan " href="{{ route('admin.state') }}"><i class="material-icons">person</i><span class="menu-title" data-i18n="Chat">Manage States</span></a>
        </li>
        <li class="bold"><a class="waves-effect waves-cyan " href="{{ route('admin.city') }}"><i class="material-icons">person</i><span class="menu-title" data-i18n="Chat">Manage Cities</span></a>
        </li>
        <li class="bold"><a class="waves-effect waves-cyan " href="javascript:void(0)"><i class="material-icons">settings</i><span class="menu-title" data-i18n="Chat">Manage Settings</span></a>
        </li>
    </ul>
    <div class="navigation-background"></div><a class="sidenav-trigger btn-sidenav-toggle btn-floating btn-medium waves-effect waves-light hide-on-large-only" href="#" data-target="slide-out"><i class="material-icons">menu</i></a>
</aside>