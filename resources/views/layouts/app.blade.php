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
                        kelas : "{{ route('admin_kelas.all') }}",
                        mahasiswa : "{{ route('mahasiswa.all') }}",
                        matkul : "{{ route('matkul.all') }}",
                        prodi : "{{ route('prodi.all') }}",
                    },
                    kaprodi: {
                        matkul : "{{ route('submatkul.all') }}",
                        pengajar : "{{ route('submatkul.dosen_submatkul') }}",
                        laporan : "{{ route('submatkul.submatkul_laporan') }}",
                        periode : "{{ route('periode.all') }}",
                        submatkul_data : "{{ route('mengajar.submatkul_data') }}"
                    },
                    dosen: {
                        rencana_submatkul : "{{ route('rencana.rencana_submatkul') }}",
                        submatkul : "{{ route('rencana.submatkul') }}"
                    }
                },
                token : "{{ Session::token() }}",
            };
        </script>
        @yield('scripts')
    </body>
</html>
