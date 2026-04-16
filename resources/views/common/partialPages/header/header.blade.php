<nav class="main-header navbar navbar-expand-lg navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#"><i class="fa fa-bars"></i></a>
        </li>
    </ul>
    <span class="navbar-text ml-3"
        style="font-size: 16px; font-weight: 400; color: #00000080;  pading-top:3px">@yield('headerHeading')</span>
    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto   @if (Auth::check() && (Auth::user()->hasRole('Admin') || Auth::user()?->hasRole('SuperAdmin'))) flex-row @endif">
        @if (Auth::check() && Auth::user()->hasRole('User'))
            @php
            // Array of possible background colors
                $backgroundColors = ['#B6BC9E', '#FF47B5', '#FF8947'];
                // Select a random color
                $randomColor = $backgroundColors[array_rand($backgroundColors)];
                // Prepare the initials and encode them for the fallback SVG
                $initials = Auth::user()->getUserInitialsAttribute();
                $svg = "<svg xmlns='http://www.w3.org/2000/svg' width='40' height='40'>
                <rect width='100%' height='100%' fill='$randomColor' />
                <text x='50%' y='50%' font-family='Poppins, sans-serif' font-size='16' font-weight='600' fill='white' dy='.3em' text-anchor='middle'>$initials</text>
                </svg>";
                $encodedSvg = base64_encode($svg);
            @endphp

            <li class="nav-item d-flex align-items-center">
                <img src="{{ Auth::user()->getAvatarFullUrlAttribute() }}" alt="rounded-circle"
                    class="rounded-circle mx-auto d-block"
                    style="width: 40px; height: 40px; border:2px solid; border-color: aliceblue; object-fit: cover; border-radius:999px;"
                    onerror="this.onerror=null; this.src='data:image/svg+xml;base64,{{ $encodedSvg }}';">
            </li>

            @elseif(Auth::user()?->hasRole('Admin') || Auth::user()?->hasRole('SuperAdmin'))
            <a href="{{ url('/') }}" class="brand-link">
                <svg width="30" height="30" viewBox="0 0 38 38" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
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
            </a>
            <span
                class="pt-3 brand-text  text-center">{{ auth()->user()->firstName ? auth()->user()->firstName : 'Administrator' }}</span>
        @else
            <li class="nav-item">
                <a href="{{ route('user.auth.signInForm') }}" class="btn btn-primary customBtnColor login-btn"
                    style="border-radius: 4px; font-size: 14px; font-weight: 600;">Login</a>
            </li>
        @endif

    </ul>
</nav>
