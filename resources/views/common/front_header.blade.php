<!-- HEADER -->
<header class="main-header">
    <div class="container d-flex align-items-center justify-content-between">
        <div class="header-left">
            <a href="{{ route('frontend.home') }}" class="logo"><img src="{{asset('front-assets/images/mantaray-logo.png') }}" alt="Mantaray"></a>
        </div>
        <div class="header-right">
            <div class="d-flex flex-wrap">
                @if (auth()->guest())
                    <a href="{{ route('frontend.login') }}" class="btn btn-primary"><svg xmlns="http://www.w3.org/2000/svg" width="18.818" height="18" viewBox="0 0 18.818 18"><g id="login-icon" transform="translate(0 -0.333)"><path id="Path_1" data-name="Path 1" d="M11.052,220.087H.544a.544.544,0,1,1,0-1.087H11.052a.544.544,0,1,1,0,1.087Zm0,0" transform="translate(0 -210.211)" fill="#fff"/><path id="Path_2" data-name="Path 2" d="M224.547,140.515a.544.544,0,0,1-.384-.928l2.515-2.515-2.515-2.515a.544.544,0,0,1,.769-.769l2.9,2.9a.544.544,0,0,1,0,.769l-2.9,2.9A.539.539,0,0,1,224.547,140.515Zm0,0" transform="translate(-215.104 -127.74)" fill="#fff"/><path id="Path_3" data-name="Path 3" d="M44.968,18.333a9.035,9.035,0,0,1-8.453-5.708.612.612,0,0,1,.349-.8.622.622,0,0,1,.8.347,7.773,7.773,0,1,0,0-5.688.623.623,0,0,1-.8.347.612.612,0,0,1-.349-.8,9.065,9.065,0,1,1,8.453,12.292Zm0,0" transform="translate(-35.233 0)" fill="#fff"/></g></svg> Login</a>
                    <a href="{{ route('frontend.register') }}" class="btn btn-white ms-3"><svg xmlns="http://www.w3.org/2000/svg" width="15.429" height="18" viewBox="0 0 15.429 18"><g id="signup-icon" transform="translate(-4 -2)"><path id="Path_4" data-name="Path 4" d="M15.454,10.663a5.143,5.143,0,1,0-7.479,0C5.4,12.1,4,15.135,4,19.357A.643.643,0,0,0,4.643,20H18.786a.642.642,0,0,0,.643-.643C19.429,15.134,18.024,12.1,15.454,10.663Zm-3.74-7.377A3.857,3.857,0,1,1,7.857,7.143,3.861,3.861,0,0,1,11.714,3.286ZM5.3,18.714c.1-2.722.892-5.91,3.782-7.163a5.092,5.092,0,0,0,5.27,0c2.889,1.253,3.681,4.441,3.781,7.163Z"/></g></svg> Sign Up</a>
                @else
                    <p>Welcome, {{ Auth::user()->full_name }}</p>
                    <!-- <a href="{{ route('frontend.logout') }}" class="btn btn-primary"><svg xmlns="http://www.w3.org/2000/svg" width="18.818" height="18" viewBox="0 0 18.818 18"><g id="login-icon" transform="translate(0 -0.333)"><path id="Path_1" data-name="Path 1" d="M11.052,220.087H.544a.544.544,0,1,1,0-1.087H11.052a.544.544,0,1,1,0,1.087Zm0,0" transform="translate(0 -210.211)" fill="#fff"/><path id="Path_2" data-name="Path 2" d="M224.547,140.515a.544.544,0,0,1-.384-.928l2.515-2.515-2.515-2.515a.544.544,0,0,1,.769-.769l2.9,2.9a.544.544,0,0,1,0,.769l-2.9,2.9A.539.539,0,0,1,224.547,140.515Zm0,0" transform="translate(-215.104 -127.74)" fill="#fff"/><path id="Path_3" data-name="Path 3" d="M44.968,18.333a9.035,9.035,0,0,1-8.453-5.708.612.612,0,0,1,.349-.8.622.622,0,0,1,.8.347,7.773,7.773,0,1,0,0-5.688.623.623,0,0,1-.8.347.612.612,0,0,1-.349-.8,9.065,9.065,0,1,1,8.453,12.292Zm0,0" transform="translate(-35.233 0)" fill="#fff"/></g></svg> Logout</a> -->
                    <div class="profile-dropdown">
                        <button class="profile-btn dropdown-toggle" type="button" data-toggle="dropdown">
                        <span class="caret"></span></button>
                        <ul class=" profile-menu dropdown-menu dropdown-menu-right">
                            <li><a href="{{ route('frontend.user_edit') }}">Profile</a></li>
                            <li><a href="{{ route('frontend.logout') }}">Logout</a></li>
                        </ul>
                    </div>
                @endif 
            </div>
        </div>
    </div>
</header>	
<!-- // END HEADER -->

