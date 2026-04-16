<aside class="main-sidebar sidebar-primary" style="background-color: #F7F7F5; border-right: 1px solid #E5E5E5; position:fixed">
    <!-- Brand Logo -->
    <a href="{{ url('/') }}" class="brand-link">
        <img src="{{ asset('img/sidebarIcon/rateMyPeerLogo.svg') }}" alt="RateMyPeers" class="brand-image"
            style="margin-top:0px">
        <br>
        {{-- <span class="brand-text font-weight-light text-center"></span> --}}
    </a>
    <!-- Sidebar -->
    <div class="sidebar d-flex flex-column justify-content-between" style="justify-content: space-between; height: 89vh">
        <div>
            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                    data-accordion="false">
                    <!-- User Nav Items -->
                    @unless (Auth::check() && Auth::check() && Auth::user()->hasRole('Admin'))
                        <!-- Dashboard -->
                        <li class="nav-item">
                            <a href="{{ Auth::check() ? route('user.dashboard.index') : route('home.index') }}"
                                class="nav-link {{ (Auth::check() && request()->path() === 'user/home') || (!Auth::check() && request()->path() === 'home') ? 'active' : '' }}">
                                <i class="nav-icon">
                                    <img src="{{ request()->path() === 'user/home' || request()->path() === 'home' ? asset('img/sidebarIcon/homeWhite.svg') : asset('img/sidebarIcon/home.svg') }}"
                                        alt="Home" style="height: 24px; width:24px;">
                                </i>
                                <p style="font-size: 15px; font-weight: 500; margin-bottom: 0px;">
                                    Home
                                </p>
                            </a>
                        </li>
                        <!-- Organization -->
                        <li class="nav-item">
                            <a href="{{ Auth::check() ? route('user.organization.listOrganization') : route('organization.listOrganization') }}"
                                class="nav-link {{ ( request()->is('user/organization/*')) || (request()->is('organization/*')) ? 'active' : '' }}">
                                <i class="nav-icon">
                                    <img src="{{ request()->is('user/organization/*') || request()->is('organization/*') ? asset('img/sidebarIcon/organizationWhite.svg') : asset('img/sidebarIcon/organization.svg') }}"
                                        alt="Organization" style="height: 24px; width:24px;">
                                </i>
                                <p style="font-size: 15px; font-weight: 500; margin-bottom: 0px;">
                                    Organizations
                                </p>
                            </a>
                        </li>
                        <!-- Peer -->
                        <li class="nav-item">
                            <a href="{{ Auth::check() ? route('user.peer.listPeer') : route('peer.listPeer') }}"
                                class="nav-link {{ (request()->is('peer/*')) || (request()->is('user/peer/*')) ? 'active' : '' }}">
                                <i class="nav-icon">
                                    <img src="{{ request()->is('peer/*') || request()->is('user/peer/*') ? asset('img/sidebarIcon/peerWhite.svg') : asset('img/sidebarIcon/peer.svg') }}"
                                        alt="Peer" style="height: 24px; width:24px;">
                                </i>
                                <p style="font-size: 15px; font-weight: 500; margin-bottom: 0px;">
                                    Peers
                                </p>
                            </a>
                        </li>

                    @endunless
                    @auth
                        <!-- Authenticated User Side Nav Items -->
                        @if (Auth::user()->hasRole('User'))
                            <!-- Profile Setting -->
                            <li class="nav-item">
                                <a href="{{ route('user.profileSetting.profileSettingForm') }}"
                                    class="nav-link {{ request()->is('user/profile-setting/*') ? 'active' : '' }}">
                                    <i class="nav-icon">
                                        <img src="{{ request()->is('user/profile-setting/*') ? asset('img/sidebarIcon/profileSettingWhite.svg') : asset('img/sidebarIcon/profileSetting.svg') }}"
                                            alt="Profile Setting" style="height: 24px; width:24px;">
                                    </i>
                                    <p style="font-size: 15px; font-weight: 500; margin-bottom: 0px;">
                                        Profile Settings
                                    </p>
                                </a>
                            </li>
                        @endif
                        <!-- Feedback -->

                        <!-- ///.... User Nav Items -->
                        <!-- Admin Nav Items -->
                        @if (auth()->user()->hasRole('Admin'))
                            <!-- Add icons to the links using the .nav-icon class with font-awesome or any other icon font library -->
                            <li class="nav-item">
                                <a href="{{ route('admin.dashboard.index') }}"
                                    class="nav-link {{ request()->is('/admin/*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-tachometer-alt"></i>
                                    <p>
                                        Dashboard
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href=""
                                    class="nav-link {{ request()->is('getUsers') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-tachometer-alt"></i>
                                    <p>
                                        Users
                                    </p>
                                </a>
                            </li>
                            <!-- These 3 technical routes will always be shown in bottom -->
                            <li class="nav-item">
                                <a href="{{ url('telescope') }}"
                                    class="nav-link {{ request()->is('telescope/*') ? 'active' : '' }}" target="_blank">
                                    <i class="nav-icon fas fa-th"></i>
                                    <p>
                                        Telescope
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('configuration-variable') }}"
                                    class="nav-link  {{ request()->is('configuration-variable*') ? 'active' : '' }}">
                                    <i class="nav-icon fa fa-cog"></i>
                                    <p
                                        class="{{ request()->is('configuration-variable*') ? 'sidebar-p-active' : 'sidebar-p' }}">
                                        Configurations
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('get.error.logs') }}"
                                    class="nav-link  {{ request()->is('error-logs') || \Illuminate\Support\Str::startsWith(request()->path(), 'error-log/detail/') ? 'active' : '' }}">
                                    <i class="nav-icon fa fa-bug"></i>
                                    <p
                                        class="{{ request()->is('error-logs') || \Illuminate\Support\Str::startsWith(request()->path(), 'error-log/detail/') ? 'sidebar-p-active' : 'sidebar-p' }}">
                                        Error Logs
                                    </p>
                                </a>
                            </li>
                        @endif
                        <!-- /.......   Authenticated User Side Nav Items -->
                    @endauth
                    @unless (Auth::check() && Auth::check() && Auth::user()->hasRole('Admin'))
                    <li class="nav-item">
                        <a href="{{ route('user.appFeedback.addAppFeedbackForm') }}"
                            class="nav-link {{ request()->is('feedback/*') ? 'active' : '' }}">
                            <i class="nav-icon">
                                <img src="{{ request()->is('feedback/*') ? asset('img/sidebarIcon/feedbackWhite.svg') : asset('img/sidebarIcon/feedback.svg') }}"
                                    alt="Feedback" style="height: 24px; width:24px;">
                            </i>
                            <p style="font-size: 15px; font-weight: 500; margin-bottom: 0px;">
                                Feedback
                            </p>
                        </a>
                    </li>
                    @endunless
                </ul>
            </nav>
        </div>
        <!-- Logout -->
        @if (Auth::check() && (Auth::user()->hasRole('User') || Auth::user()->hasRole('Admin')))
            <nav>
                <ul class="nav nav-pills nav-sidebar flex-column">
                    <li class="nav-item">
                        <a href="#" class="nav-link"
                            onclick="event.preventDefault(); document.getElementById('logoutForm').submit();">
                            <i class="nav-icon">
                                <img src="{{ asset('img/sidebarIcon/logOut.svg') }}" alt="Logout"
                                    style="height: 24px; width:24px;">
                            </i>
                            <p style="font-size: 15px;    font-weight: 500;    margin-bottom: 0px;">
                                Logout
                            </p>
                        </a>
                        <form id="logoutForm" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>
                </ul>
            </nav>
        @endif
    </div>
</aside>
<style>
    /* Media query for mobile devices */
    @media (max-width: 768px) {
        .main-sidebar {
            height: 100vh;
            overflow-y: auto;
        }
        .sidebar {
            height: auto;
        }
        .nav-item p {
            font-size: 14px;
        }
        nav:last-child {
            margin-bottom: 60px;
        }
    }
    </style>
