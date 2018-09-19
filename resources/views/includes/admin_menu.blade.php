<div class="collapse navbar-collapse" id="app-navbar-collapse">
    <!-- Left Side Of Navbar -->
    
    <ul class="nav navbar-nav">
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
                Mata Kuliah <span class="caret"></span>
            </a>

            <ul class="dropdown-menu">
                <li><a href="{{ route('matkul.index') }}"> View </a></li>
                <li><a href="{{ route('matkul.create') }}"> Add </a></li>
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
    
</div>