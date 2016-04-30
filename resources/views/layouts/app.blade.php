<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title')</title>

    <!-- Fonts -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700" rel='stylesheet' type='text/css'>

    <!-- Styles -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    {{-- <link href="{{ elixir('css/app.css') }}" rel="stylesheet"> --}}

    <!-- <link rel="stylesheet" href="{{ URL::asset('bootstrap-3.3.6-dist/css/bootstrap.min.css') }}"> -->
    <!-- <link rel="stylesheet" href="{{ URL::asset('bootstrap-3.3.6-dist/css/normalize.css') }}"> -->

    <style>
        body {
            font-family: 'Lato';
        }

        .fa-btn {
            margin-right: 6px;
        }

        .container > .row > .col-md-12 > .panel{
            box-shadow: 5px 10px 10px 5px #888888;
        }
    </style>

    @yield('css')
</head>
<body id="app-layout">
    <nav class="navbar navbar-default">
        <div class="container">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ url('/home') }}">
                    CommonClusters
                </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">


                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav navbar-left">
                    <!-- Authentication Links -->
                    @if (Auth::guest())
                    @else
                        @if(Auth::user()->isApproved == 1)
                            @if(Auth::user()->companyrole->role_id != 1)
                                @if(in_array(6,\App\CompanyRoleActivity::where('company_role_id', Auth::user()->companyrole->id)->lists('activity_id')->toArray()))
                                    <li><a href="{{URL::to('/clusters')}}">Clusters</a></li>
                                @endif
                                @if(in_array(7,\App\CompanyRoleActivity::where('company_role_id', Auth::user()->companyrole->id)->lists('activity_id')->toArray()))
                                    <li><a href="{{URL::to('/upload')}}">Upload</a></li>
                                @endif
                                <li><a href="{{URL::to('/structure')}}">Maintain Data</a></li> 
                            @else
                                <li><a href="{{URL::to('/branches')}}">Branches</a></li>

                                <li><a href="{{URL::to('/roles')}}">Roles</a></li>

                                <li><a href="{{URL::to('/users')}}">Users</a></li>
                            @endif
                        @endif
                    @endif
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    @if (Auth::guest())
                    @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    @yield('content')

    <!-- JavaScripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    {{-- <script src="{{ elixir('js/app.js') }}"></script> --}}
    <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
    <!-- // <script src="{{ URL::asset('assets/js/jquery-1.10.2.js') }}"></script> -->
    <!-- // <script src="{{ URL::asset('assets/js/jquery-2.2.3.min.js') }}"></script> -->
    <!-- // <script src="{{ URL::asset('bootstrap-3.3.6-dist/js/bootstrap.min.js') }}"></script> -->
    @yield('javascript')
</body>
</html>
