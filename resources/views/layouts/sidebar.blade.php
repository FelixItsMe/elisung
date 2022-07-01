
<!-- partial:partials/_sidebar.html -->
<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item nav-profile">
        <a href="#" class="nav-link">
            <div class="nav-profile-image">
            <img src="{{ Auth::user()->foto ? asset(Auth::user()->foto) : asset('images/faces/face4.jpg') }}" alt="profile">
            <span class="login-status online"></span>
            <!--change to offline or busy as needed-->
            </div>
            <div class="nav-profile-text d-flex flex-column">
            <span class="font-weight-bold mb-2">{{ Auth::user()->name }}</span>
            </div>
            <i class="mdi mdi-bookmark-check text-success nav-profile-badge"></i>
        </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('elisung.mesin.index') }}">
                <span class="menu-title">Mesin</span>
                <i class="mdi mdi-contacts menu-icon"></i>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('elisung.hasil-panen.index') }}">
                <span class="menu-title">Hasil Panen</span>
                <i class="mdi mdi-leaf menu-icon"></i>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('elisung.telemetri.index') }}">
                <span class="menu-title">Telemetri</span>
                <i class="mdi mdi-leaf menu-icon"></i>
            </a>
        </li>
        {{-- <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#general-pages" aria-expanded="false" aria-controls="general-pages">
                <span class="menu-title">Sample Pages</span>
                <i class="menu-arrow"></i>
                <i class="mdi mdi-medical-bag menu-icon"></i>
            </a>
            <div class="collapse" id="general-pages">
                <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="pages/samples/blank-page.html"> Blank Page </a></li>
                <li class="nav-item"> <a class="nav-link" href="pages/samples/login.html"> Login </a></li>
                <li class="nav-item"> <a class="nav-link" href="pages/samples/register.html"> Register </a></li>
                <li class="nav-item"> <a class="nav-link" href="pages/samples/error-404.html"> 404 </a></li>
                <li class="nav-item"> <a class="nav-link" href="pages/samples/error-500.html"> 500 </a></li>
                </ul>
            </div>
        </li> --}}
    </ul>
</nav>
<!-- partial -->
