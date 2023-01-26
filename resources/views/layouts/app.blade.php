<!doctype html>
{{--<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">--}}
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
{{--    <meta name="csrf-token" content="{{ csrf_token() }}">--}}

    <title>MFX ADMIN - @yield('title')</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet">

    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
{{--    <script src="vendor/chart.js/Chart.min.js"></script>--}}
    <script src="js/sb-admin-2.min.js"></script>
{{--    <script src="js/demo/chart-area-demo.js"></script>--}}
{{--    <script src="js/demo/chart-pie-demo.js"></script>--}}
{{--</head>--}}
<body>
<div id="wrapper">

{{--    @if(Auth::check())--}}
        @section('sidebar')
            <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
                <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ url('login') }}">
                    <div class="sidebar-brand-icon rotate-n-15">
                        <i class="fas fa-laugh-wink"></i>
                    </div>
                    <div class="sidebar-brand-text mx-3">MFX Admin <sup>2</sup></div>
                </a>

                <hr class="sidebar-divider my-0">

                <li class="nav-item {{ (request()->is('home')) ? 'active' : '' }}">
                    <a class="nav-link" href="{{ url('/home') }}">
                        <i class="fas fa-fw fa-tachometer-alt"></i>
                        <span>Dashboard</span></a>
                </li>

                <hr class="sidebar-divider my-0">

                {{--                <li class="nav-item {{ (request()->is('events')) ? 'active' : '' }}">--}}
                {{--                    <a class="nav-link" href="{{ url('/events') }}">--}}
                {{--                        <i class="fas fa-fw fa-calendar-times"></i>--}}
                {{--                        <span>Event</span></a>--}}
                {{--                </li>--}}

{{--                @if(auth()->user()->hasRole('admin'))--}}
                    <hr class="sidebar-divider my-0">
                    <li class="nav-item ">
                        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
                           aria-expanded="true" aria-controls="collapsePages">
                            <i class="fas fa-fw fa-folder"></i>
                            <span>Admin</span>
                        </a>
                        <div id="collapsePages" class="collapse {{ (request()->is('admin/*')) ? 'show' : '' }}"
                             aria-labelledby="headingPages" data-parent="#accordionSidebar">
                            <div class="bg-white py-2 collapse-inner rounded">
                                <a class="collapse-item {{ (request()->is('admin/users/*')) || (request()->is('admin/users')) ? 'active' : '' }}"
                                   href="{{ url('admin/users') }}">Users</a>
                                <a class="collapse-item {{ (request()->is('admin/events')) || (request()->is('admin/events/*')) ? 'active' : '' }}"
                                   href="{{ url('admin/events') }}">Events</a>
                            </div>
                        </div>
                    </li>
{{--                @endif--}}

                <hr class="sidebar-divider d-none d-md-block">

                <div class="text-center d-none d-md-inline">
                    <button class="rounded-circle border-0" id="sidebarToggle"></button>
                </div>
            </ul>
        @show
{{--    @endif--}}
    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">

{{--            @if(Auth::check())--}}
                @section('navbar')
                    <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                        <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                            <i class="fa fa-bars"></i>
                        </button>

                        <ul class="navbar-nav ml-auto">
                            <li class="nav-item dropdown no-arrow mx-1">
                                <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
                                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-bell fa-fw"></i>
                                    <span class="badge badge-danger badge-counter">3+</span>
                                </a>

                                <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                     aria-labelledby="alertsDropdown">
                                    <h6 class="dropdown-header">
                                        Alerts Center
                                    </h6>
                                    <a class="dropdown-item d-flex align-items-center" href="#">
                                        <div class="mr-3">
                                            <div class="icon-circle bg-primary">
                                                <i class="fas fa-file-alt text-white"></i>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="small text-gray-500">December 12, 2019</div>
                                            <span
                                                class="font-weight-bold">A new monthly report is ready to download!</span>
                                        </div>
                                    </a>
                                    <a class="dropdown-item d-flex align-items-center" href="#">
                                        <div class="mr-3">
                                            <div class="icon-circle bg-success">
                                                <i class="fas fa-donate text-white"></i>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="small text-gray-500">December 7, 2019</div>
                                            $290.29 has been deposited into your account!
                                        </div>
                                    </a>
                                    <a class="dropdown-item d-flex align-items-center" href="#">
                                        <div class="mr-3">
                                            <div class="icon-circle bg-warning">
                                                <i class="fas fa-exclamation-triangle text-white"></i>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="small text-gray-500">December 2, 2019</div>
                                            Spending Alert: We've noticed unusually high spending for your account.
                                        </div>
                                    </a>
                                    <a class="dropdown-item text-center small text-gray-500" href="#">Show All
                                        Alerts</a>
                                </div>
                            </li>

                            <li class="nav-item dropdown no-arrow mx-1">
                                <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button"
                                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-envelope fa-fw"></i>
                                    <span class="badge badge-danger badge-counter">7</span>
                                </a>

                                <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                     aria-labelledby="messagesDropdown">
                                    <h6 class="dropdown-header">
                                        Message Center
                                    </h6>
                                    <a class="dropdown-item d-flex align-items-center" href="#">
                                        <div class="dropdown-list-image mr-3">
                                            <img class="rounded-circle" src="{{asset('img/undraw_profile_1.svg')}}"
                                                 alt="...">
                                            <div class="status-indicator bg-success"></div>
                                        </div>
                                        <div class="font-weight-bold">
                                            <div class="text-truncate">Hi there! I am wondering if you can help me with
                                                a
                                                problem I've been having.
                                            </div>
                                            <div class="small text-gray-500">Emily Fowler · 58m</div>
                                        </div>
                                    </a>
                                    <a class="dropdown-item d-flex align-items-center" href="#">
                                        <div class="dropdown-list-image mr-3">
                                            <img class="rounded-circle" src="{{asset("img/undraw_profile_2.svg")}}"
                                                 alt="...">
                                            <div class="status-indicator"></div>
                                        </div>
                                        <div>
                                            <div class="text-truncate">I have the photos that you ordered last month,
                                                how
                                                would you like them sent to you?
                                            </div>
                                            <div class="small text-gray-500">Jae Chun · 1d</div>
                                        </div>
                                    </a>
                                    <a class="dropdown-item d-flex align-items-center" href="#">
                                        <div class="dropdown-list-image mr-3">
                                            <img class="rounded-circle" src="{{asset('img/undraw_profile_3.svg')}}"
                                                 alt="...">
                                            <div class="status-indicator bg-warning"></div>
                                        </div>
                                        <div>
                                            <div class="text-truncate">Last month's report looks great, I am very happy
                                                with
                                                the progress so far, keep up the good work!
                                            </div>
                                            <div class="small text-gray-500">Morgan Alvarez · 2d</div>
                                        </div>
                                    </a>
                                    <a class="dropdown-item d-flex align-items-center" href="#">
                                        <div class="dropdown-list-image mr-3">
                                            <img class="rounded-circle"
                                                 src="https://source.unsplash.com/Mv9hjnEUHR4/60x60"
                                                 alt="...">
                                            <div class="status-indicator bg-success"></div>
                                        </div>
                                        <div>
                                            <div class="text-truncate">Am I a good boy? The reason I ask is because
                                                someone
                                                told me that people say this to all dogs, even if they aren't good...
                                            </div>
                                            <div class="small text-gray-500">Chicken the Dog · 2w</div>
                                        </div>
                                    </a>
                                    <a class="dropdown-item text-center small text-gray-500" href="#">Read More
                                        Messages</a>
                                </div>
                            </li>

                            <div class="topbar-divider d-none d-sm-block"></div>

                            <li class="nav-item dropdown no-arrow">
                                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span
                                    class="mr-2 d-none d-lg-inline text-gray-600 small">{{--{{ auth()->user()->name }}--}}</span>
                                    <img class="img-profile rounded-circle"
                                         src="{{asset('img/undraw_profile.svg')}}">
                                </a>

                                <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                     aria-labelledby="userDropdown">
                                    <a class="dropdown-item" href="#">
                                        <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                        Profile
                                    </a>
                                    <a class="dropdown-item" href="#">
                                        <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                        Settings
                                    </a>
                                    <a class="dropdown-item" href="#">
                                        <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                                        Activity Log
                                    </a>
                                    <div class="dropdown-divider"></div>
{{--                                    <a class="dropdown-item" href="{{ route('logout') }}"--}}
{{--                                       onclick="event.preventDefault();--}}
{{--                               document.getElementById('logout-form').submit();">--}}
{{--                                        --}}{{--                                {{ __('Logout') }}>--}}
{{--                                        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>--}}
{{--                                        Logout--}}
{{--                                    </a>--}}
{{--                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">--}}
{{--                                        @csrf--}}
{{--                                    </form>--}}
                                </div>
                            </li>
                        </ul>
                    </nav>
                @show
{{--            @endif--}}

            <div class="container-fluid">
                @yield('content')
            </div>

        </div>
        <footer class="sticky-footer bg-white">
            <div class="container my-auto">
                <div class="copyright text-center my-auto">
                    <span>Copyright &copy; andaniom 2023</span>
                </div>
            </div>
        </footer>
    </div>
</div>
</body>
</html>
