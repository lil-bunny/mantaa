<!-- BEGIN: Header-->
<header class="page-topbar" id="header">
    <div class="navbar navbar-fixed"> 
        <nav class="navbar-main navbar-color nav-collapsible sideNav-lock navbar-dark gradient-45deg-indigo-purple no-shadow">
            <div class="nav-wrapper">
                <ul class="navbar-list right">
                <li><a class="waves-effect waves-block waves-light" href="javascript:void(0);">Welcome, {{ $user_name }}</a></li>
                    @if ($notification_count_unread != 0)
                        <li><a class="waves-effect waves-block waves-light notification-button" href="javascript:void(0);" data-target="notifications-dropdown"><i class="material-icons">notifications_none<small class="notification-badge">{{ $notification_count_unread }}</small></i></a></li>
                    @endif
                    <li><a class="waves-effect waves-block waves-light profile-button" href="javascript:void(0);" data-target="profile-dropdown"><span class="avatar-status avatar-online"><img src="{{ asset('images/avatar/avatar-7.png') }}" alt="avatar"><i></i></span></a></li>
                </ul>
                <!-- notifications-dropdown-->
                <ul class="dropdown-content" id="notifications-dropdown">
                    <li>
                        @if ($notification_count_unread != 0)
                            <h6>NOTIFICATIONS<span class="new badge">{{ $notification_count_unread }}</span></h6>
                        @endif
                    </li>
                    <li class="divider"></li>
                    @if ($notifications->count())
                        @foreach($notifications as $notification)
                        <li>
                            <a class="black-text" href="{{ route('admin.area_edit', ['id' => $notification->object_id]) }}"><span class="material-icons icon-bg-circle cyan small">add_shopping_cart</span> {{ $notification->title }}</a>
                            <time class="media-meta grey-text darken-2" datetime="2015-06-12T20:50:48+08:00">on {{ $notification->created_at }}</time>
                        </li>
                        @endforeach
                    @endif
                </ul>
                <!-- profile-dropdown-->
                <ul class="dropdown-content" id="profile-dropdown">
                    <li><a class="grey-text text-darken-1" href="javascript:void(0)"><i class="material-icons">person_outline</i> Profile</a></li>
                    <li><a class="grey-text text-darken-1" href="{{ route('admin.logout') }}"><i class="material-icons">keyboard_tab</i> Logout</a></li>
                </ul>
            </div>
        </nav>
    </div>
</header>
<!-- END: Header-->