<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Appointment Manager</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/font-awesome.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/slick.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/slick-theme.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/animate.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">
</head>
<body>
    <body class='background' id="background" style="background-image: url('{{ asset('images/bg2.jpg') }}'); background-size: cover; background-position: center; background-repeat: no-repeat;">

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
    <section class="main-banner" id="main-banner">
		{{-- <div class="sec-shape">
			<span class="shape shape1 animate-this"><img src="{{ asset('images/shape1.png') }}" alt="Shape"></span>
			<span class="shape shape2 animate-this"><img src="{{ asset('images/shape2.png') }}" alt="Shape"></span>
			<span class="shape shape3 animate-this"><img src="{{ asset('images/shape3.png') }}" alt="Shape"></span>
			<span class="shape shape4 animate-this "><img src="{{ asset('images/shape2.png') }}" alt="Shape"></span>
			<span class="shape shape5 animate-this"><img src="{{ asset('images/shape1.png') }}" alt="Shape"></span>
		</div> --}}

    <div class="container">
        <div class="row">

            <div class="col-lg-5">
                <img src="{{ asset('images/ramlogin.png') }}" alt="Example Image" class="login-img">
                {{-- <div class="main-banner-slider wow fadeup-animation" data-wow-delay="0.6s">
                    <div class="banner-slider">
                        <div class="banner-img back-img" style="background-image: url('{{ asset('images/ram1.2.png') }}');"></div>
                        <div class="banner-img back-img" style="background-image: url('{{ asset('images/ram1.2.png') }}');"></div>
                    </div>
                </div> --}}
            </div>
            <div class="col-lg-6">
                <div class="banner-content">
                    <h1 class="h1-title wow fadeup-animation" data-wow-delay="0.5s">You set the date, we'll coordinate</h1>
                    <p class="wow fadeup-animation" data-wow-delay="0.6s">Schedule your appointment now!</p>
                    <div class="col-sm-12">
                        <form id="loginForm" action="{{ route('login') }}" method="POST">
                            @csrf
                            <div>
                                <label for="email">Email:</label>
                                <input class="form form-control" type="email" id="email_address" name="email_address" required placeholder="Enter Email">
                            </div>
                            <br>
                            <div>
                                <label for="password">Password:</label>
                                <input class="form form-control" type="password" id="password" name="password" required placeholder="Enter Password">
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-sm-4"></div>
                                <div class="col-sm-8">
                                    <input type="submit" value="Sign In"class="sec-btn" width="100%">
                                </div>
                            </div>
                        </form>
                    </div>
                    <br>
                </div>
            </div>
        </div>
    </div>

</div>
</section>
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

