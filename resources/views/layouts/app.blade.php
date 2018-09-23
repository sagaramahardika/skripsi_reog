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
        <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/css/bootstrap.min.css" rel="stylesheet">
        @yield('styles')
    </head>
    <body>
        <div id="app">
            @include('includes.header')
            @yield('content')
        </div>

        <!-- Scripts -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>
        <script>
            // global routing js + token
            var config = {
                routes: {
                    admin: {
                        dosen : "{{ route('admin_dosen.all') }}",
                        fakultas : "{{ route('fakultas.all') }}",
                        mahasiswa : "{{ route('mahasiswa.all') }}",
                        matkul : "{{ route('matkul.all') }}",
                        prodi : "{{ route('prodi.all') }}",
                    },
                    kaprodi: {
                        matkul : "{{ route('submatkul.all') }}",
                        pengajar : "{{ route('mengajar.all') }}",
                        periode : "{{ route('periode.all') }}",
                    },
                    dosen: {
                        
                    }
                },
                token : "{{ Session::token() }}",
            };
        </script>
        @yield('scripts')
    </body>
</html>
