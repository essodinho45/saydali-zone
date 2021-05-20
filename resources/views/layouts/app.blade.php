<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/jquery.js') }}"></script>    

    <!-- Fonts -->
    <link href="{{ asset('fontawesome/css/all.css') }}" rel="stylesheet">
    <link href="{{ asset('css/tajwal.css') }}" rel="stylesheet">
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    {{-- <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Tajawal:100,200,300,400,500,700,800,900&display=swap" rel="stylesheet"> --}}
    

    <!-- Styles -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    

</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-dark bg-navyblue shadow-sm text-lightkiwi" style="line-height: normal;">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img src="../images/SZlogo112.png">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            {{-- @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif --}}
                        @else
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('news') }}">{{ __('News') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('items') }}">{{ __('Items') }}</a>
                            </li>
                            @if(Auth::user()->user_category_id != 1)
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('orders') }}">{{ __('Orders') }}</a>
                            </li>
                            @endif
                            @if(Auth::user()->user_category_id != 5)
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown2" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{__('Reports')}} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown2">
                                    <a class="dropdown-item" href="{{ route('ordersReport') }}">{{__('Orders Report')}}</a>
                                </div>
                            </li>
                            @endif
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->f_name }}&nbsp;{{Auth::user()->s_name}} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('home') }}">{{__('Dashboard')}}</a>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                            @if(Auth::user()->user_category_id == 5)
                            <li class="nav-item">
                                    <a class="nav-link center-things" href="{{ route('cart') }}">
                                        <span class="fa-stack fa-1x has-badge" @if(Auth::user()->cartsFromUser->count() > 0)data-count="{{Auth::user()->cartsFromUser->count()}}"@endif>
                                            <i class="fa fa-circle fa-stack-2x"></i>
                                            <i class="fas fa-shopping-cart fa-stack-1x fa-inverse"></i>
                                        </span>
                                        {{-- <i class="fas fa-shopping-cart"></i> --}}
                                        {{-- <span class="fa-stack">
                                            <!-- The icon that will wrap the number -->
                                            <span class="fas fa-shopping-cart fa-stack-3x"></span>
                                            <!-- a strong element with the custom content, in this case a number -->
                                            @if(Auth::user()->cartsFromUser->count() > 0)
                                            <small class="text-danger fa-stack-2x">
                                                <span class="fas fa-circle">
                                                    <small class="fa-stack-1x text-light">
                                                        {{Auth::user()->cartsFromUser->count()}}
                                                    </small>
                                                </span>
                                            </small>
                                            @endif
                                        </span> --}}
                                    </a>
                            </li>
                            @endif
                            {{-- @if(Auth::user()->user_category_id == 0 || Auth::user()->user_category_id == 1)
                            <li class="nav-item">
                                    <a class="nav-link" href="{{ route('offers') }}"><i class="fas fa-star"></i></a>
                            </li>
                            @endif --}}
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main>
            @yield('content')
        </main>
    </div>
</body>

<script src="{{ asset('js/app.js') }}"></script>


@yield('scripts')
</html>

