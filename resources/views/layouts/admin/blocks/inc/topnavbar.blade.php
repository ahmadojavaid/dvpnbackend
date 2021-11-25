<!-- Topbar Start -->
<div class="navbar-custom">
    <ul class="list-unstyled topnav-menu float-right mb-0">

        <li class="dropdown notification-list">
            <a class="nav-link dropdown-toggle nav-user mr-0 waves-effect waves-light" data-toggle="dropdown" href="#"
               role="button" aria-haspopup="false" aria-expanded="false">
                @if(Session::has('profile_image'))
                    <img src="{{ asset(Session::get('profile_image')) }}" alt="user-image" class="rounded-circle">
                @else
                    <img src="{{ asset('assets/admin/images/users/user-1.jpg') }}" alt="user-image"
                         class="rounded-circle">
                @endif
                @if(Session::has('user_name'))
                    <span class="pro-user-name ml-1">
                                {{ Session::get('user_name') }} <i class="mdi mdi-chevron-down"></i>
                            </span>
                @else
                    <span class="pro-user-name ml-1">
                                Admin <i class="mdi mdi-chevron-down"></i>
                            </span>
                @endif
            </a>
            <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                <!-- item-->
                <div class="dropdown-header noti-title">
                    <h6 class="text-overflow m-0">Welcome Admin!</h6>
                </div>

                <div class="dropdown-divider"></div>

                <!-- item-->
                <a href="{{ url('/logout') }}" class="dropdown-item notify-item">
                    <i class="fe-log-out"></i>
                    <span>Logout</span>
                </a>

            </div>
        </li>
    </ul>

    <!-- LOGO -->
    <div class="logo-box">
        <a href="{{ url('/') }}" class="logo text-center">
                        <span class="logo-lg">
                            <img src="{{ asset('assets/admin/images/logo.png') }}" alt="" height="70">
                            <!-- <span class="logo-lg-text-light">UBold</span> -->
                        </span>
            <span class="logo-sm">
                            <!-- <span class="logo-sm-text-dark">U</span> -->
                            <img src="{{ asset('assets/admin/images/favicon.png') }}" alt="" height="70">
                        </span>
        </a>
    </div>

    <ul class="list-unstyled topnav-menu topnav-menu-left m-0">
        <li>
            <button class="button-menu-mobile waves-effect waves-light">
                <i class="fe-menu"></i>
            </button>
        </li>
    </ul>
</div>
<!-- end Topbar -->