<nav class="navbar sticky-top navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand mx-4 text-success" href="/">SIMKO</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <div class="" style="position: absolute; right:0;">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item px-4">
                        <a class="nav-link {{ Request::is('/') ? 'active text-success border-bottom border-success border-3' : '' }}"
                            aria-current="page" href="/">Beranda</a>
                    </li>
                    <li class="nav-item px-4">
                        <a class="nav-link {{ Request::is('kost', 'kostan*', 'pemilik*', 'jenis*') ? 'active text-success border-bottom border-success border-3' : '' }}"
                            href="/kost">Kosan</a>
                    </li>
                    <li class="nav-item px-4">
                        <a class="nav-link {{ Request::is('kategori*') ? 'active text-success border-bottom border-success border-3' : '' }}"
                            href="/kategori">Kategori</a>
                    </li>
                    <li class="nav-item px-4">
                        <a class="nav-link {{ Request::is('tentang') ? 'active text-success border-bottom border-success border-3' : '' }}"
                            href="/tentang">Tentang</a>
                    </li>
                    <li class="nav-item dropdown px-5">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person-circle"></i>
                        </a>
                        @auth
                            <ul class="dropdown-menu shadow" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item {{ Request::is('dashboard/profil') ? 'active' : '' }}"
                                        href="/dashboard/profil">Profil</a></li>
                                <li><a class="dropdown-item {{ Request::is('dashboard') ? 'active' : '' }}"
                                        href="/dashboard">Dashboard</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <form action="/logout" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item">Logout</button>
                                    </form>
                                </li>
                            </ul>
                        @else
                            <ul class="dropdown-menu shadow" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item {{ Request::is('login') ? 'active' : '' }}"
                                        href="/login">Login</a></li>
                                <li><a class="dropdown-item {{ Request::is('registrasi') ? 'active' : '' }}"
                                        href="/registrasi">Registrasi</a></li>
                            </ul>
                        @endauth
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>
