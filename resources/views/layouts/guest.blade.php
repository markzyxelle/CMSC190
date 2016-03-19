<html>
    <head>
        <title>App Name - @yield('title')</title>

        <link rel="stylesheet" href="{{ URL::asset('bootstrap-3.3.6-dist/css/bootstrap.css') }}">
        <link rel="stylesheet" href="{{ URL::asset('bootstrap-3.3.6-dist/css/normalize.css') }}">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <style> 
            body { padding-top: 70px; }
        </style>
       
    </head>
    <body>
        <nav class="navbar navbar-default navbar-fixed-top">
            
        </nav>
        <div class="container">
            @yield('content')
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="{{ URL::asset('bootstrap-3.3.6-dist/js/bootstrap.min.js') }}"></script>
    </body>
</html>