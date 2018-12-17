<div class="collapse navbar-collapse" id="app-navbar-collapse">
    <!-- Left Side Of Navbar -->
    
    <ul class="nav navbar-nav">
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true">
                Fakultas <span class="caret"></span>
            </a>

            <ul class="dropdown-menu">
                <li><a href="{{ route('admin_fakultas.index') }}"> View </a></li>
                <li><a href="{{ route('admin_fakultas.create') }}"> Add </a></li>
            </ul>
        </li>

        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true">
                Prodi <span class="caret"></span>
            </a>

            <ul class="dropdown-menu">
                <li><a href="{{ route('admin_prodi.index') }}"> View </a></li>
                <li><a href="{{ route('admin_prodi.create') }}"> Add </a></li>
            </ul>
        </li>

        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true">
                Dosen <span class="caret"></span>
            </a>

            <ul class="dropdown-menu">
                <li><a href="{{ route('admin_dosen.index') }}"> View </a></li>
                <li><a href="{{ route('admin_dosen.create') }}"> Add </a></li>
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
                Mahasiswa <span class="caret"></span>
            </a>

            <ul class="dropdown-menu">
                <li><a href="{{ route('admin_mahasiswa.index') }}"> View </a></li>
                <li><a href="{{ route('admin_mahasiswa.create') }}"> Add </a></li>
            </ul>
        </li>

        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true">
                Acara <span class="caret"></span>
            </a>

            <ul class="dropdown-menu">
                <li><a href="{{ route('acara.index') }}"> View </a></li>
                <li><a href="{{ route('acara.create') }}"> Add </a></li>
            </ul>
        </li>
    </ul>

    <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
            <a href="{{ route('logout') }}"> Logout </a>
        </li>
    </ul>
    
</div>