<aside class="main-sidebar sidebar-primary elevation-4" style="background-color: #F7F7F5;">
    <!-- Brand Logo -->
    <a href="{{ url('/') }}" class="brand-link">
        <svg width="38" height="38" viewBox="0 0 38 38" fill="none" xmlns="http://www.w3.org/2000/svg"
            class="" style="opacity: .8;padding-left: 10px;">
            <path
                d="M36.4426 16.4454C36.4426 24.6678 29.7771 31.3334 21.5549 31.3334C13.3327 31.3334 6.66728 24.6678 6.66728 16.4454C6.66728 8.22291 13.3327 1.55736 21.5549 1.55736C29.7771 1.55736 36.4426 8.22291 36.4426 16.4454Z"
                fill="#F7F7F5" stroke="black" stroke-width="3.11472" />
            <path
                d="M29.4173 16.2857C29.4173 20.54 25.9686 23.9888 21.7144 23.9888C17.4602 23.9888 14.0115 20.54 14.0115 16.2857C14.0115 12.0313 17.4602 8.58254 21.7144 8.58254C25.9686 8.58254 29.4173 12.0313 29.4173 16.2857Z"
                stroke="black" stroke-width="3.11472" />
            <path
                d="M21.4335 26.1849C21.4335 31.6738 16.984 36.1234 11.4953 36.1234C6.00668 36.1234 1.55718 31.6738 1.55718 26.1849C1.55718 20.6961 6.00668 16.2465 11.4953 16.2465C16.984 16.2465 21.4335 20.6961 21.4335 26.1849Z"
                fill="#F7F7F5" stroke="black" stroke-width="3.11472" />
        </svg>

        <br>
        <span class="brand-text font-weight-light text-center"></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar d-flex flex-column justify-content-between"
        style="justify-content: space-between; height: 89vh">
        <div>
            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                    data-accordion="false">

                    <!-- User Nav Items -->
                    <!-- Dashboard -->
                    <li class="nav-item">
                        <a href="{{ route('admin.dashboard.index') }}"
                            class="nav-link {{ (Auth::check() && request()->path() === 'admin/dashboard') || (!Auth::check() && request()->path() === 'dashboard') ? 'active' : '' }}">
                            <i class="nav-icon ">
                                <svg width="24" height="25" viewBox="0 0 24 25" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <mask id="mask0_1280_250" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="0"
                                        y="0" width="24" height="25">
                                        <rect y="0.680664" width="24" height="24" fill="#D9D9D9" />
                                    </mask>
                                    <g mask="url(#mask0_1280_250)">
                                        <path
                                            d="M5 21.6807C4.45 21.6807 3.97917 21.4848 3.5875 21.0932C3.19583 20.7015 3 20.2307 3 19.6807V5.68066C3 5.13066 3.19583 4.65983 3.5875 4.26816C3.97917 3.8765 4.45 3.68066 5 3.68066H19C19.55 3.68066 20.0208 3.8765 20.4125 4.26816C20.8042 4.65983 21 5.13066 21 5.68066V19.6807C21 20.2307 20.8042 20.7015 20.4125 21.0932C20.0208 21.4848 19.55 21.6807 19 21.6807H5ZM10 19.6807V13.6807H5V19.6807H10ZM12 19.6807H19V13.6807H12V19.6807ZM5 11.6807H19V5.68066H5V11.6807Z"
                                            fill="{{ request()->path() === 'admin/dashboard' ? 'white' : '#858181' }}" />
                                    </g>
                                </svg>


                            </i>
                            <p>
                                Dashboard
                            </p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('admin.user.index') }}"
                            class="nav-link {{ request()->segment(1) === 'admin' && request()->segment(2) === 'users' ? 'active' : '' }}">
                            <i class="nav-icon">
                                <svg width="24" height="25" viewBox="0 0 22 17" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M8 8.68066C6.9 8.68066 5.95833 8.289 5.175 7.50566C4.39167 6.72233 4 5.78066 4 4.68066C4 3.58066 4.39167 2.639 5.175 1.85566C5.95833 1.07233 6.9 0.680664 8 0.680664C9.1 0.680664 10.0417 1.07233 10.825 1.85566C11.6083 2.639 12 3.58066 12 4.68066C12 5.78066 11.6083 6.72233 10.825 7.50566C10.0417 8.289 9.1 8.68066 8 8.68066ZM0 16.6807V13.8807C0 13.314 0.145833 12.7932 0.4375 12.3182C0.729167 11.8432 1.11667 11.4807 1.6 11.2307C2.63333 10.714 3.68333 10.3265 4.75 10.0682C5.81667 9.80983 6.9 9.68066 8 9.68066C9.1 9.68066 10.1833 9.80983 11.25 10.0682C12.3167 10.3265 13.3667 10.714 14.4 11.2307C14.8833 11.4807 15.2708 11.8432 15.5625 12.3182C15.8542 12.7932 16 13.314 16 13.8807V16.6807H0ZM2 14.6807H14V13.8807C14 13.6973 13.9542 13.5307 13.8625 13.3807C13.7708 13.2307 13.65 13.114 13.5 13.0307C12.6 12.5807 11.6917 12.2432 10.775 12.0182C9.85833 11.7932 8.93333 11.6807 8 11.6807C7.06667 11.6807 6.14167 11.7932 5.225 12.0182C4.30833 12.2432 3.4 12.5807 2.5 13.0307C2.35 13.114 2.22917 13.2307 2.1375 13.3807C2.04583 13.5307 2 13.6973 2 13.8807V14.6807ZM8 6.68066C8.55 6.68066 9.02083 6.48483 9.4125 6.09316C9.80417 5.7015 10 5.23066 10 4.68066C10 4.13066 9.80417 3.65983 9.4125 3.26816C9.02083 2.8765 8.55 2.68066 8 2.68066C7.45 2.68066 6.97917 2.8765 6.5875 3.26816C6.19583 3.65983 6 4.13066 6 4.68066C6 5.23066 6.19583 5.7015 6.5875 6.09316C6.97917 6.48483 7.45 6.68066 8 6.68066Z"
                                        fill="{{ request()->segment(1) === 'admin' && request()->segment(2) === 'users' ? 'white' : '#858181' }}" />
                                </svg>
                            </i>

                            <p>Users</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('admin.organization.index') }}"
                            class="nav-link {{ request()->segment(1) === 'admin' && request()->segment(2) === 'organizations' ? 'active' : '' }}">
                            <i class="nav-icon">
                                <svg width="24" height="25" viewBox="0 0 24 25" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <mask id="mask0_1280_272" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="0"
                                        y="0" width="24" height="25">
                                        <rect y="0.680664" width="24" height="24" fill="#D9D9D9" />
                                    </mask>
                                    <g mask="url(#mask0_1280_272)">
                                        <path
                                            d="M0 18.6807V0.680664H10V4.68066H20V18.6807H0ZM2 16.6807H8V14.6807H2V16.6807ZM2 12.6807H8V10.6807H2V12.6807ZM2 8.68066H8V6.68066H2V8.68066ZM2 4.68066H8V2.68066H2V4.68066ZM10 16.6807H18V6.68066H10V16.6807ZM12 10.6807V8.68066H16V10.6807H12ZM12 14.6807V12.6807H16V14.6807H12Z"
                                            fill="{{ request()->segment(1) === 'admin' && request()->segment(2) === 'organizations' ? 'white' : '#858181' }}" />
                                    </g>
                                </svg>
                            </i>
                            <p>
                                Organizations
                            </p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('admin.peer.index') }}"
                            class="nav-link {{ request()->segment(1) === 'admin' && request()->segment(2) === 'peers' ? 'active' : '' }}">
                            <i class="nav-icon">
                                <svg width="24" height="25" viewBox="0 0 22 17" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M0 16.6807V13.8807C0 13.314 0.145833 12.7932 0.4375 12.3182C0.729167 11.8432 1.11667 11.4807 1.6 11.2307C2.63333 10.714 3.68333 10.3265 4.75 10.0682C5.81667 9.80983 6.9 9.68066 8 9.68066C9.1 9.68066 10.1833 9.80983 11.25 10.0682C12.3167 10.3265 13.3667 10.714 14.4 11.2307C14.8833 11.4807 15.2708 11.8432 15.5625 12.3182C15.8542 12.7932 16 13.314 16 13.8807V16.6807H0ZM18 16.6807V13.6807C18 12.9473 17.7958 12.2432 17.3875 11.5682C16.9792 10.8932 16.4 10.314 15.65 9.83066C16.5 9.93067 17.3 10.1015 18.05 10.3432C18.8 10.5848 19.5 10.8807 20.15 11.2307C20.75 11.564 21.2083 11.9348 21.525 12.3432C21.8417 12.7515 22 13.1973 22 13.6807V16.6807H18ZM8 8.68066C6.9 8.68066 5.95833 8.289 5.175 7.50566C4.39167 6.72233 4 5.78066 4 4.68066C4 3.58066 4.39167 2.639 5.175 1.85566C5.95833 1.07233 6.9 0.680664 8 0.680664C9.1 0.680664 10.0417 1.07233 10.825 1.85566C11.6083 2.639 12 3.58066 12 4.68066C12 5.78066 11.6083 6.72233 10.825 7.50566C10.0417 8.289 9.1 8.68066 8 8.68066ZM18 4.68066C18 5.78066 17.6083 6.72233 16.825 7.50566C16.0417 8.289 15.1 8.68066 14 8.68066C13.8167 8.68066 13.5833 8.65983 13.3 8.61816C13.0167 8.5765 12.7833 8.53066 12.6 8.48066C13.05 7.94733 13.3958 7.35566 13.6375 6.70566C13.8792 6.05566 14 5.38066 14 4.68066C14 3.98066 13.8792 3.30566 13.6375 2.65566C13.3958 2.00566 13.05 1.414 12.6 0.880664C12.8333 0.797331 13.0667 0.743164 13.3 0.718164C13.5333 0.693164 13.7667 0.680664 14 0.680664C15.1 0.680664 16.0417 1.07233 16.825 1.85566C17.6083 2.639 18 3.58066 18 4.68066ZM2 14.6807H14V13.8807C14 13.6973 13.9542 13.5307 13.8625 13.3807C13.7708 13.2307 13.65 13.114 13.5 13.0307C12.6 12.5807 11.6917 12.2432 10.775 12.0182C9.85833 11.7932 8.93333 11.6807 8 11.6807C7.06667 11.6807 6.14167 11.7932 5.225 12.0182C4.30833 12.2432 3.4 12.5807 2.5 13.0307C2.35 13.114 2.22917 13.2307 2.1375 13.3807C2.04583 13.5307 2 13.6973 2 13.8807V14.6807ZM8 6.68066C8.55 6.68066 9.02083 6.48483 9.4125 6.09316C9.80417 5.7015 10 5.23066 10 4.68066C10 4.13066 9.80417 3.65983 9.4125 3.26816C9.02083 2.8765 8.55 2.68066 8 2.68066C7.45 2.68066 6.97917 2.8765 6.5875 3.26816C6.19583 3.65983 6 4.13066 6 4.68066C6 5.23066 6.19583 5.7015 6.5875 6.09316C6.97917 6.48483 7.45 6.68066 8 6.68066Z"
                                        fill="{{ request()->segment(1) === 'admin' && request()->segment(2) === 'peers' ? 'white' : '#858181' }}" />
                                </svg>
                            </i>

                            <p>
                                Peers
                            </p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('admin.organizationRating.index') }}"
                            class="nav-link {{ (Auth::check() && request()->path() === 'admin/organization-rating') || (!Auth::check() && request()->path() === 'organization-rating') ? 'active' : '' }}">
                            <i class="nav-icon">
                                <svg width="24" height="25" viewBox="0 0 24 25" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <mask id="mask0_1280_1086" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="0"
                                        y="0" width="24" height="25">
                                        <rect y="0.680664" width="24" height="24" fill="#D9D9D9" />
                                    </mask>
                                    <g mask="url(#mask0_1280_1086)">
                                        <path
                                            d="M8.85 17.5057L12 15.6057L15.15 17.5307L14.325 13.9307L17.1 11.5307L13.45 11.2057L12 7.80566L10.55 11.1807L6.9 11.5057L9.675 13.9307L8.85 17.5057ZM5.825 21.6807L7.45 14.6557L2 9.93066L9.2 9.30566L12 2.68066L14.8 9.30566L22 9.93066L16.55 14.6557L18.175 21.6807L12 17.9557L5.825 21.6807Z"
                                            fill="{{ request()->path() === 'admin/organization-rating' ? 'white' : '#858181' }}" />
                                    </g>
                                </svg>
                            </i>
                            <p>
                                Organization Ratings
                            </p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('admin.peerRating.index') }}"
                            class="nav-link {{ (Auth::check() && request()->path() === 'admin/peer-rating') || (!Auth::check() && request()->path() === 'peer-rating') ? 'active' : '' }}">
                            <i class="nav-icon">
                                <svg width="24" height="25" viewBox="0 0 24 25" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <mask id="mask0_1280_271" style="mask-type:alpha" maskUnits="userSpaceOnUse"
                                        x="0" y="0" width="24" height="25">
                                        <rect y="0.680664" width="24" height="24" fill="#D9D9D9" />
                                    </mask>
                                    <g mask="url(#mask0_1280_271)">
                                        <path
                                            d="M8 18.6807L12 15.6307L16 18.6807L14.5 13.7307L18.5 10.8807H13.6L12 5.68066L10.4 10.8807H5.5L9.5 13.7307L8 18.6807ZM12 22.6807C10.6167 22.6807 9.31667 22.4182 8.1 21.8932C6.88333 21.3682 5.825 20.6557 4.925 19.7557C4.025 18.8557 3.3125 17.7973 2.7875 16.5807C2.2625 15.364 2 14.064 2 12.6807C2 11.2973 2.2625 9.99733 2.7875 8.78066C3.3125 7.564 4.025 6.50566 4.925 5.60566C5.825 4.70566 6.88333 3.99316 8.1 3.46816C9.31667 2.94316 10.6167 2.68066 12 2.68066C13.3833 2.68066 14.6833 2.94316 15.9 3.46816C17.1167 3.99316 18.175 4.70566 19.075 5.60566C19.975 6.50566 20.6875 7.564 21.2125 8.78066C21.7375 9.99733 22 11.2973 22 12.6807C22 14.064 21.7375 15.364 21.2125 16.5807C20.6875 17.7973 19.975 18.8557 19.075 19.7557C18.175 20.6557 17.1167 21.3682 15.9 21.8932C14.6833 22.4182 13.3833 22.6807 12 22.6807ZM12 20.6807C14.2333 20.6807 16.125 19.9057 17.675 18.3557C19.225 16.8057 20 14.914 20 12.6807C20 10.4473 19.225 8.55566 17.675 7.00566C16.125 5.45566 14.2333 4.68066 12 4.68066C9.76667 4.68066 7.875 5.45566 6.325 7.00566C4.775 8.55566 4 10.4473 4 12.6807C4 14.914 4.775 16.8057 6.325 18.3557C7.875 19.9057 9.76667 20.6807 12 20.6807Z"
                                            fill="{{ request()->path() === 'admin/peer-rating' ? 'white' : '#858181' }}" />
                                    </g>
                                </svg>
                            </i>
                            <p>
                                Peer Ratings
                            </p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('admin.feedback.index') }}"
                            class="nav-link {{ (Auth::check() && request()->path() === 'admin/feedback') || (!Auth::check() && request()->path() === 'feedback') ? 'active' : '' }}">
                            <i class="nav-icon">
                                <svg width="24" height="25" viewBox="0 0 24 25" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <mask id="mask0_1161_753" style="mask-type:alpha" maskUnits="userSpaceOnUse"
                                        x="0" y="0" width="24" height="25">
                                        <rect y="0.680664" width="24" height="24" fill="#D9D9D9" />
                                    </mask>
                                    <g mask="url(#mask0_1161_753)">
                                        <path
                                            d="M6 14.6807H9.05L14.05 9.68066C14.2 9.53066 14.3125 9.35983 14.3875 9.16816C14.4625 8.9765 14.5 8.789 14.5 8.60566C14.5 8.42233 14.4583 8.24316 14.375 8.06816C14.2917 7.89316 14.1833 7.73066 14.05 7.58066L13.15 6.63066C13 6.48066 12.8333 6.36816 12.65 6.29316C12.4667 6.21816 12.275 6.18066 12.075 6.18066C11.8917 6.18066 11.7042 6.21816 11.5125 6.29316C11.3208 6.36816 11.15 6.48066 11 6.63066L6 11.6307V14.6807ZM7.5 13.1807V12.2307L10.025 9.70566L10.525 10.1557L10.975 10.6557L8.45 13.1807H7.5ZM10.525 10.1557L10.975 10.6557L10.025 9.70566L10.525 10.1557ZM11.175 14.6807H18V12.6807H13.175L11.175 14.6807ZM2 22.6807V4.68066C2 4.13066 2.19583 3.65983 2.5875 3.26816C2.97917 2.8765 3.45 2.68066 4 2.68066H20C20.55 2.68066 21.0208 2.8765 21.4125 3.26816C21.8042 3.65983 22 4.13066 22 4.68066V16.6807C22 17.2307 21.8042 17.7015 21.4125 18.0932C21.0208 18.4848 20.55 18.6807 20 18.6807H6L2 22.6807ZM5.15 16.6807H20V4.68066H4V17.8057L5.15 16.6807Z"
                                            fill="{{ request()->path() === 'admin/feedback' ? 'white' : '#858181' }}" />
                                    </g>
                                </svg>
                            </i>
                            <p>
                                Feedback
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.reportedComments') }}"
                            class="nav-link {{ request()->path() === 'admin/reported-comments' ? 'active' : '' }}">
                            <i class="nav-icon">
                                <svg width="24" height="25" viewBox="0 0 24 25" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M4.5 21.1807V4.18066H13.5L13.9 6.18066H19.5V16.1807H12.5L12.1 14.1807H6.5V21.1807H4.5ZM14.15 14.1807H17.5V8.18066H12.25L11.85 6.18066H6.5V12.1807H13.75L14.15 14.1807Z"
                                        fill="{{ request()->path() === 'admin/reported-comments' ? 'white' : '#858181' }}" />
                                </svg>

                            </i>
                            <p>
                                Reported Comments
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('term-condition.view') }}"
                            class="nav-link {{ request()->is('admin/term-condition') || request()->is('admin/term-condition/view') ? 'active' : '' }}">
                            <i class="nav-icon">
                                <svg width="24" height="25" viewBox="0 0 24 25" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M17 10.9412V5.8C17 4.11984 17 3.27976 16.673 2.63803C16.3854 2.07354 15.9265 1.6146 15.362 1.32698C14.7202 1 13.8802 1 12.2 1H5.8C4.11984 1 3.27976 1 2.63803 1.32698C2.07354 1.6146 1.6146 2.07354 1.32698 2.63803C1 3.27976 1 4.11984 1 5.8V16.2C1 17.8802 1 18.7202 1.32698 19.362C1.6146 19.9265 2.07354 20.3854 2.63803 20.673C3.27976 21 4.11984 21 5.8 21H11M11 10H5M7 14H5M13 6H5M12 16H18"
                                        stroke="#6c757d" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round"
                                        fill="{{ request()->path() === 'admin/term-condition' ? 'white' : 'none' }}" />
                                </svg>

                            </i>
                            <p>
                                Terms & Conditions
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('privacy-policy.view') }}"
                            class="nav-link {{ request()->is('admin/privacy-policy') || request()->is('admin/privacy-policy/view') ? 'active' : '' }}">
                            <i class="nav-icon">
                                <svg width="24" height="25" viewBox="0 0 24 25" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M17 9V5.8C17 4.11984 17 3.27976 16.673 2.63803C16.3854 2.07354 15.9265 1.6146 15.362 1.32698C14.7202 1 13.8802 1 12.2 1H5.8C4.11984 1 3.27976 1 2.63803 1.32698C2.07354 1.6146 1.6146 2.07354 1.32698 2.63803C1 3.27976 1 4.11984 1 5.8V16.2C1 17.8802 1 18.7202 1.32698 19.362C1.6146 19.9265 2.07354 20.3854 2.63803 20.673C3.27976 21 4.11984 21 5.8 21H7.5M10 10H5M8 14H5M13 6H5M16.25 16V14.25C16.25 13.2835 15.4665 12.5 14.5 12.5C13.5335 12.5 12.75 13.2835 12.75 14.25V16M12.6 20H16.4C16.9601 20 17.2401 20 17.454 19.891C17.6422 19.7951 17.7951 19.6422 17.891 19.454C18 19.2401 18 18.9601 18 18.4V17.6C18 17.0399 18 16.7599 17.891 16.546C17.7951 16.3578 17.6422 16.2049 17.454 16.109C17.2401 16 16.9601 16 16.4 16H12.6C12.0399 16 11.7599 16 11.546 16.109C11.3578 16.2049 11.2049 16.3578 11.109 16.546C11 16.7599 11 17.0399 11 17.6V18.4C11 18.9601 11 19.2401 11.109 19.454C11.2049 19.6422 11.3578 19.7951 11.546 19.891C11.7599 20 12.0399 20 12.6 20Z"
                                        stroke="#6c757d" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round"
                                        fill="{{ request()->path() === 'admin/privacy-policy' ? 'white' : 'none' }}" />
                                </svg>

                            </i>
                            <p>
                                Privacy Policy
                            </p>
                        </a>
                    </li>
                    @if(env('APP_ENV') !== 'production')
                    <!-- These 3 technical routes will always be shown in bottom -->
                    <li class="nav-item">
                        <a href="{{ url('telescope') }}"
                            class="nav-link {{ request()->is('telescope/*') ? 'active' : '' }}" target="_blank">
                            <i class="nav-icon fas fa-th"></i>
                            <p style="font-size: 15px; font-weight: 500; margin-bottom: 0px;">
                                Telescope
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('configuration-variable') }}"
                            class="nav-link  {{ request()->is('dashboard/configuration-variable*') ? 'active' : '' }}">
                            <i class="nav-icon fa fa-cog"></i>
                            <p style="font-size: 15px; font-weight: 500; margin-bottom: 0px;"
                                class="{{ request()->is('dashboard/configuration-variable*') ? 'sidebar-p-active' : 'sidebar-p' }}">
                                Configurations
                            </p>
                        </a>
                    </li>
                    @endif

                </ul>
            </nav>
        </div>

        <!-- Logout -->
        @if (Auth::check() &&
                (Auth::user()->hasRole('User') || Auth::user()->hasRole('Admin') || Auth::user()->hasRole('SuperAdmin')))
            <nav>
                <ul class="nav nav-pills nav-sidebar flex-column">
                    <li class="nav-item">
                        <a href="#" class="nav-link"
                            onclick="event.preventDefault(); document.getElementById('logoutForm').submit();">
                            <i class="nav-icon">
                                <img src="{{ asset('img/sidebarIcon/logOut.svg') }}" alt="Logout Logo"
                                    style="height: 24px; width:24px;">
                            </i>
                            <p>
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
