<div class="collapse navbar-collapse" id="app-navbar-collapse">
    <!-- Left Side Of Navbar -->
    
    <ul class="nav navbar-nav">
        <li class="dropdown">
            <a href="{{ route('admin_dosen.index') }}"> Dosen </a>
        </li>

        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true">
                Fakultas <span class="caret"></span>
            </a>

            <ul class="dropdown-menu">
                <li><a href="{{ route('fakultas.index') }}"> View </a></li>
                <li><a href="{{ route('fakultas.create') }}"> Add </a></li>
            </ul>
        </li>

        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true">
                Mahasiswa <span class="caret"></span>
            </a>

            <ul class="dropdown-menu">
                <li><a href="{{ route('mahasiswa.index') }}"> View </a></li>
                <li><a href="{{ route('mahasiswa.create') }}"> Add </a></li>
            </ul>
        </li>

        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true">
                Mata Kuliah <span class="caret"></span>
            </a>

            <ul class="dropdown-menu">
                <li><a href="{{ route('matkul.index') }}"> View </a></li>
                <li><a href="{{ route('matkul.create') }}"> Add </a></li>
            </ul>
        </li>

        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true">
                Periode <span class="caret"></span>
            </a>

            <ul class="dropdown-menu">
                <li><a href="{{ route('periode.index') }}"> View </a></li>
                <li><a href="{{ route('periode.create') }}"> Add </a></li>
            </ul>
        </li>

        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true">
                Prodi <span class="caret"></span>
            </a>

            <ul class="dropdown-menu">
                <li><a href="{{ route('prodi.index') }}"> View </a></li>
                <li><a href="{{ route('prodi.create') }}"> Add </a></li>
            </ul>
        </li>
    </ul>

    <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
            <a href="{{ route('logout') }}"> Logout </a>
        </li>
    </ul>
    
</div>