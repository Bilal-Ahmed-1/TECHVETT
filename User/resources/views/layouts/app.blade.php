<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">

    <title>@yield('title', 'TECHVETT')</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@ffmpeg/ffmpeg@0.11.5/dist/ffmpeg.min.js"></script>  
    <!-- Font Awesome CSS (for icons) -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- Particles.js -->
    <script src="https://cdn.jsdelivr.net/npm/particles.js@2.0.0/particles.min.js"></script>
    <link rel="stylesheet" href="{{ asset('/css/style.css') }}"/>
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
      integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Scripts -->
    {{-- @vite(['resources/sass/app.scss', 'resources/js/app.js']) --}}
    
</head>
<body style="font-family: 'Roboto', sans-serif; font-weight: 400; font-size: 16px;">
    <div>
        <div class="wrapper">
            <aside id="sidebar">
                <div class="d-flex" style="height: 100px;">
                  <button class="toggle-btn" type="button">
                    <img src="{{ asset('/images/logo.png') }}" alt="" srcset="">
                  </button>
                  <div class="sidebar-logo">
                    <a href="#">TECHVETT</a>
                  </div>
                </div>
                <ul class="sidebar-nav">
                  <li class="sidebar-item">
                    <a href="#" class="sidebar-link">
                      <i class="fa-solid fa-layer-group animated-icon"></i>
                      <span>DASHBOARD</span>
                    </a>
                  </li>
                  <li class="sidebar-item">
                    <a
                      href="#"
                      class="sidebar-link collapsed has-dropdown"
                      data-bs-toggle="collapse"
                      data-bs-target="#auth"
                      aria-expanded="false"
                      aria-controls="auth"
                    >
                      <i class="fa-solid fa-list animated-icon"></i>
                      <span>CATEGORIES</span>
                    </a>
                    <ul
                      id="auth"
                      class="sidebar-dropdown list-unstyled collapse"
                      data-bs-parent="#sidebar"
                    >
                      <li class="sidebar-item">
                          <a href="#" class="sidebar-link"><i class="fa-solid fa-bug-slash animated-icon"></i> SQA &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="lock-container"><i class="fa-solid fa-lock animated-icon"></i><i class="fa-solid fa-lock-open animated-icon"></i></span> </a>
                      </li>
                      <li class="sidebar-item">
                          <a href="#" class="sidebar-link"><i class="fa-solid fa-network-wired animated-icon"></i> NETWORK &nbsp;&nbsp;<span class="lock-container"><i class="fa-solid fa-lock animated-icon"></i><i class="fa-solid fa-lock-open animated-icon"></i></span> </a>
                      </li>
                    </ul>
                  </li>
                  <li class="sidebar-item">
                    <a
                      href="#"
                      class="sidebar-link collapsed has-dropdown"
                      data-bs-toggle="collapse"
                      data-bs-target="#asess"
                      aria-expanded="false"
                      aria-controls="asess"
                    >
                      <i class="fa-solid fa-list-check animated-icon"></i>
                      <span>ASSESSMENT</span>
                    </a>
                    <ul
                      id="asess"
                      class="sidebar-dropdown list-unstyled collapse"
                      data-bs-parent="#sidebar"
                    >
                      <li class="sidebar-item">
                          <a href="#" class="sidebar-link"><i class="fa-solid fa-circle-check animated-icon"></i> STAGE 1 &nbsp;&nbsp;&nbsp;&nbsp;<span class="lock-container"><i class="fa-solid fa-lock animated-icon"></i><i class="fa-solid fa-lock-open animated-icon"></i></span> </a>
                      </li>
                      <li class="sidebar-item">
                          <a href="#" class="sidebar-link"><i class="fa-solid fa-circle-check animated-icon"></i> STAGE 2 &nbsp;&nbsp;&nbsp;<span class="lock-container"><i class="fa-solid fa-lock animated-icon"></i><i class="fa-solid fa-lock-open animated-icon"></i></span> </a>
                      </li>
                      <li class="sidebar-item">
                          <a href="#" class="sidebar-link"><i class="fa-solid fa-circle-check animated-icon"></i> STAGE 3 &nbsp;&nbsp;&nbsp;<span class="lock-container"><i class="fa-solid fa-lock animated-icon"></i><i class="fa-solid fa-lock-open animated-icon"></i></span> </a>
                      </li>
                    </ul>
                  </li>
                  <li class="sidebar-item">
                    <a href="#" class="sidebar-link">
                      <i class="fa-regular fa-circle-question animated-icon"></i>
                      <span>FEEDBACK</span>
                    </a>
                  </li>
                  @auth
                    <li class="sidebar-item">
                      <a href="#" class="sidebar-link">
                        <i class="fa-regular fa-user animated-icon"></i>
                        <span>{{ Auth::user()->name }}</span>
                      </a>
                    </li>
                  @endauth
                  {{-- <li class="sidebar-item">
                    <a href="{{ route('logout') }}" class="sidebar-link"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                      <i class="fa-solid fa-right-from-bracket animated-icon"></i>
                      <span>{{ __('Logout') }}</span>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                  </form>
                  </li> --}}
                </ul>
                <div class="sidebar-item">
                  <a href="{{ route('logout') }}" class="sidebar-link"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fa-solid fa-right-from-bracket animated-icon"></i>
                    <span>{{ __('LOGOUT') }}</span>
                  </a>
                  <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                  </form>
                </div>       
              </aside>
              <div class="leftside">
                <div class="tech-banner">
                  <div class="scrolling-text">
                    <span>•&nbsp; WELCOME TO TECHVETT CANDIDATE PORTAL •&nbsp;</span>
                  </div>
                </div>
                <div id="app" class="main" style="background: #212626; display: flex; justify-content: center; align-items: center;">     
                  @yield('content')
                </div>
              </div>
              
        </div>
    </div>
        <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
        crossorigin="anonymous"
      ></script>
      <script src="{{ asset('/js/script.js') }}"></script>
    </body>
</html>

<style>
/* Existing styles */
.tech-banner {
  width: 100%;
  overflow: hidden;
  background: #212626;
  color: #09c3e4;
  font-family: 'Roboto Mono', monospace;
  font-size: 20px;
  font-weight: 400;
  white-space: nowrap;
  border-top: 1px solid #1c1c1c;
  border-bottom: 1px solid #1c1c1c;
  padding: 10px 0;
  position: relative;
}

.scrolling-text {
  display: inline-block;
  padding-left: 100%;
  animation: scroll-left 20s linear infinite;
}

@keyframes scroll-left {
  0% {
    transform: translateX(0%);
  }
  100% {
    transform: translateX(-100%);
  }
}

/* Icon animation - tech styled */
.animated-icon {
    transition: transform 0.3s ease, color 0.3s ease;
    color: #09c3e4;
}

.animated-icon:hover {
    transform: scale(1.2);
    color: #09c3e4;
}

/* Sidebar link hover effect */
.sidebar-link {
    transition: all 0.3s ease-in-out;
}

.sidebar-link:hover {
    background-color: #1f2b35;
    color: #09c3e4;
}

/* Marquee: modern alternative using CSS animation */
.marquee-container {
    overflow: hidden;
    background: #212626;
    height: 45px;
    display: flex;
    align-items: center;
    font-size: 18px;
    padding-left: 100%; /* Starts offscreen */
    white-space: nowrap;
}

.marquee-text {
    display: inline-block;
    animation: scrollText 20s linear infinite;
    color: #09c3e4;
    font-family: 'Roboto Mono', monospace;
    font-weight: 400;
}

@keyframes scrollText {
    0% { transform: translateX(0%); }
    100% { transform: translateX(-100%); }
}

/* Lock icon animation */
.lock-container {
    position: relative;
    display: inline-block;
    width: 1em;
    height: 1.6em;
}

.fa-lock, .fa-lock-open {
    position: absolute;
    top: 0;
    left: 0;
    transition: opacity 0.3s ease, transform 0.3s ease;
}

.sidebar-link:hover .fa-lock {
    opacity: 0;
    transform: rotate(15deg);
}

.sidebar-link:hover .fa-lock-open {
    opacity: 1;
    transform: rotate(0deg);
}

.fa-lock-open {
    opacity: 0;
    transform: rotate(-15deg);
}
</style>