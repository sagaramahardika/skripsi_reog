<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title> @yield('title') | {{ config('app.name', 'Laravel') }}</title>

        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        @yield('styles')
    </head>
    <body>
        <div id="app">
            @include('includes.header')
            @yield('content')
        </div>

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}"></script>
        <script>
            // global routing js + token
            var config = {
                routes: {
                    fakultas : "{{ route('fakultas.all') }}",
                    prodi : "{{ route('prodi.all') }}",
                },
                token : "{{ Session::token() }}",
            };
        </script>
        <script src="{{ asset('js/admin.js') }}"></script>
        @yield('scripts')
    </body>
</html>
