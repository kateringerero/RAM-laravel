<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/styleadmin.css') }}">

    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/font-awesome.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/slick.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/slick-theme.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/animate.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Work+Sans:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">


</head>
<body class='background' id="background" style="background-image: url('{{ asset('images/bg1.jpg') }}'); background-size: cover; background-position: center; background-repeat: no-repeat;">

    <div class="main">
        {{-- loader start --}}
            <div class="loader-box">
                <div class="loader-design">
                    <svg class="gegga">
                        <defs>
                            <filter id="gegga">
                                <feGaussianBlur in="SourceGraphic" stdDeviation="7" result="blur" />
                                <feColorMatrix in="blur" values="1 0 0 0 0 0 1 0 0 0 0 0 1 0 0 0 0 0 20 -10" result="inreGegga" />
                                <feComposite in="SourceGraphic" in2="inreGegga" operator="atop" />
                            </filter>
                        </defs>
                    </svg>
                    <svg class="snurra" width="200" height="200" viewBox="0 0 200 200">
                        <defs>
                            <linearGradient id="linjärGradient">
                                <stop class="stopp1" offset="0" />
                                <stop class="stopp2" offset="1" />
                            </linearGradient>
                            <linearGradient y2="160" x2="160" y1="40" x1="40" gradientUnits="userSpaceOnUse" id="gradient" xlink:href="#linjärGradient" />
                        </defs>
                        <path class="halvan" d="m 164,100 c 0,-35.346224 -28.65378,-64 -64,-64 -35.346224,0 -64,28.653776 -64,64 0,35.34622 28.653776,64 64,64 35.34622,0 64,-26.21502 64,-64 0,-37.784981 -26.92058,-64 -64,-64 -37.079421,0 -65.267479,26.922736 -64,64 1.267479,37.07726 26.703171,65.05317 64,64 37.29683,-1.05317 64,-64 64,-64"
                        />
                        <circle class="strecken" cx="100" cy="100" r="64" />
                    </svg>
                    <svg class="skugga" width="200" height="200" viewBox="0 0 200 200">
                        <path class="halvan" d="m 164,100 c 0,-35.346224 -28.65378,-64 -64,-64 -35.346224,0 -64,28.653776 -64,64 0,35.34622 28.653776,64 64,64 35.34622,0 64,-26.21502 64,-64 0,-37.784981 -26.92058,-64 -64,-64 -37.079421,0 -65.267479,26.922736 -64,64 1.267479,37.07726 26.703171,65.05317 64,64 37.29683,-1.05317 64,-64 64,-64"
                        />
                        <circle class="strecken" cx="100" cy="100" r="64" />
                    </svg>
                </div>
            </div>
        {{-- loader end --}}

<div class="sidebar" id="sidebar">
    <div class="logo">
        <div style="display: flex; justify-content: center;">
            <img src="{{ asset('images/ramlogosmall.png') }}" alt="Logo" width="200">
        </div>
            <div class="navbar-user">
                <span>Welcome, {{ Auth::user()->first_name }}!</span>
            </div>
    </div>

    <ul>
        <li>
            <div class="menu-item">
                @if(auth()->check())
                    @switch(auth()->user()->role)
                        @case('admin')
                            <a class="menu-items" href="{{ route('admin.dashboard') }}"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
                            @break
                        @case('superadmin')
                            <a class="menu-items" href="{{ route('superadmin.dashboard') }}"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
                            @break
                        @default
                            <a class="menu-items" href="{{ route('user') }}"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
                    @endswitch
                @endif
            </div>
        </li>

            @if(auth()->check() && auth()->user()->role == 'superadmin')
            <li class="dropdown">
                <div class="menu-item">
                <a class="menu-items" href="{{ route('manage_admins.index') }}"><i class="fas fa-user-shield"></i> Manage Admins</a>
                </div>
                <ul class="dropdown-content">
                    <li>
                        <div class="menu-item">
                            <a class="sub-menu-items" href="{{ route('create-admin.show') }}"><i class="fas fa-user-plus"></i> Create Admin</a>
                        </div>
                    </li>
                    <li>
                        <div class="menu-item">
                            <a class="sub-menu-items" href="{{ route('admins_manage.show') }}"><i class="fas fa-toggle-off"></i> Enable/Disable Admin</a>
                        </li>
                </ul>
            </li>
            @endif

        <li>
            <div class="menu-item">
                <a class="menu-items" href="{{ route('manage_appointments.index') }}"><i class="fas fa-calendar-check"></i> Manage Appointments</a>
            </div>
        </li>

        <li>
            <div class="menu-item">
                <a class="menu-items" href="{{ route('my-account') }}"><i class="fas fa-user-circle"></i> My Account</a>
            </div>
        </li>
    </ul>
    <div class="logout-container">
    <form action="{{ route('logout') }}" method="POST" style="display: inline;">
        @csrf
        <button type="submit">Logout</button>
    </form>
    </div>
</div>


{{-- <div class="content2">
        <div class="navbar">
            <div class="navbar-title"></div>
            <div class="navbar-user">
                <span>Welcome, {{ Auth::user()->first_name }}!</span>
                <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit">Logout</button>
                </form>
            </div>
        </div>
</div> --}}

<div class="page-content">
    @yield('content')
</div>

{{-- bubbles start --}}
{{-- <div class="bubbles_wrap">
    <div class="bubble x1"></div>
    <div class="bubble x2"></div>
    <div class="bubble x3"></div>
    <div class="bubble x4"></div>
    <div class="bubble x5"></div>
    <div class="bubble x6"></div>
    <div class="bubble x7"></div>
    <div class="bubble x8"></div>
    <div class="bubble x9"></div>
    <div class="bubble x10"></div>
</div> --}}
{{-- bubbles end --}}

<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/popper.min.js') }}"></script>
<script src="{{ asset('js/slick.min.js') }}"></script>
<script src="{{ asset('js/wow.min.js') }}"></script>
<script src="{{ asset('js/custom.js') }}"></script>

</body>
</html>
