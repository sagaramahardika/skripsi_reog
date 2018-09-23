<div class="collapse navbar-collapse" id="app-navbar-collapse">
    <!-- Left Side Of Navbar -->
    
    <ul class="nav navbar-nav">

        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true">
                Matakuliah <span class="caret"></span>
            </a>

            <ul class="dropdown-menu">
                <li><a href="{{ route('submatkul.index') }}"> View </a></li>
                <li><a href="{{ route('submatkul.create') }}"> Add </a></li>
            </ul>
        </li>

        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true">
                Pengajar <span class="caret"></span>
            </a>

            <ul class="dropdown-menu">
                <li><a href="{{ route('mengajar.index') }}"> View </a></li>
                <li><a href="{{ route('mengajar.create') }}"> Add </a></li>
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
    </ul>

    <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
            <a href="{{ route('logout') }}"> Logout </a>
        </li>
    </ul>
    
</div>