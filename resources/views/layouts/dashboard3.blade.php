<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.88.1">
    <title>{{ $title }}</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/5.1/examples/dashboard/">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <link rel="icon" href="{{ url('img/logo.png') }}">

    <!-- Bootstrap core CSS -->

    <style>
        html {
            background-color: white
        }

        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }
    </style>


    <!-- Custom styles for this template -->
    <link href="{{ asset('/css/dashboard.css') }}" rel="stylesheet">
</head>

<body>

    <header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
        <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="/">INDEKOST</a>
        <div class="d-flex justify-content-end w-100">
            <a class="nav-link col-md-3 col-lg-2 me-0 px-3 text-white" href="/">Beranda</a>
            <a class="nav-link col-md-3 col-lg-2 me-0 px-3 text-white" href="/kost">Kosan</a>
            <a class="nav-link col-md-3 col-lg-2 me-0 px-3 text-white" href="/kategori">Kategori</a>
            <a class="nav-link col-md-3 col-lg-2 me-0 px-3 text-white" href="/tentang">Tentang</a>
        </div>
        <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse"
            data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="navbar-nav">
            <div class="nav-item text-nowrap">
                <form action="/logout" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-dark"
                        onclick="return confirm('Yakin ingin Keluar')">Logout</button>
                </form>
                {{-- <a class="" href="#">Sign out</a> --}}
            </div>
        </div>
    </header>

    <div class="container-fluid mb-5">
        <div class="row">
            <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
                <div class="position-sticky pt-3">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('dashboard') ? 'active ' : '' }}" aria-current="page"
                                href="/dashboard">
                                <i class="bi bi-speedometer"></i>
                                Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('dashboard/profil*') ? 'active ' : '' }}"
                                href="/dashboard/profil">
                                <i class="bi bi-person-circle"></i>
                                Profil
                            </a>
                        </li>
                        @if (auth()->user()->status === 'penyewa')
                            <li class="nav-item">
                                <a class="nav-link {{ Request::is('dashboard/pelaporan*') ? 'active ' : '' }}"
                                    href="/dashboard/pelaporan">
                                    <i class="bi bi-envelope-heart"></i>
                                    Pelaporan
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ Request::is('dashboard/penyewaan*') ? 'active ' : '' }}"
                                    href="/dashboard/penyewaan">
                                    <i class="bi bi-book"></i>
                                    Penyewaan
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ Request::is('dashboard/pembayaran*') ? 'active ' : '' }}"
                                    href="/dashboard/pembayaran">
                                    <i class="bi bi-cash-stack"></i>
                                    Pembayaran Kost
                                </a>
                            </li>
                        @elseif (auth()->user()->status === 'pemilik')
                            <li class="nav-item">
                                <a class="nav-link {{ Request::is('dashboard/pengajuan*', auth()->user()->status == 'pemilik' ? 'dashboard/kamar*' : '') ? 'active ' : '' }}"
                                    href="/dashboard/pengajuan">
                                    <i class="bi bi-send"></i>
                                    Pengajuan
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ Request::is('dashboard/pelaporan*') ? 'active ' : '' }}"
                                    href="/dashboard/pelaporan">
                                    <i class="bi bi-envelope-heart"></i>
                                    Pelaporan
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ Request::is('dashboard/penyewaan*') ? 'active ' : '' }}"
                                    href="/dashboard/penyewaan">
                                    <i class="bi bi-book"></i>
                                    Penyewaan
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ Request::is('dashboard/pembayaran*') ? 'active ' : '' }}"
                                    href="/dashboard/pembayaran">
                                    <i class="bi bi-cash-stack"></i>
                                    Pembayaran Kost
                                </a>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="nav-link {{ Request::is('dashboard/user*') ? 'active ' : '' }}"
                                    href="/dashboard/user">
                                    <i class="bi bi-people"></i>
                                    Akun
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ Request::is('dashboard/kost*', 'dashboard/kamar*') ? 'active ' : '' }}"
                                    href="/dashboard/kost">
                                    <i class="bi bi-house-door"></i>
                                    Kost-kostan
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ Request::is('dashboard/pengajuan*') ? 'active ' : '' }}"
                                    href="/dashboard/pengajuan">
                                    <i class="bi bi-send"></i>
                                    Pengajuan
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ Request::is('dashboard/pelaporan*') ? 'active ' : '' }}"
                                    href="/dashboard/pelaporan">
                                    <i class="bi bi-envelope-heart"></i>
                                    Pelaporan
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ Request::is('dashboard/penyewaan*') ? 'active ' : '' }}"
                                    href="/dashboard/penyewaan">
                                    <i class="bi bi-book"></i>
                                    Penyewaan
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ Request::is('dashboard/pembayaran*') ? 'active ' : '' }}"
                                    href="/dashboard/pembayaran">
                                    <i class="bi bi-cash-stack"></i>
                                    Pembayaran
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ Request::is('dashboard/kategori*') ? 'active ' : '' }}"
                                    href="/dashboard/kategori">
                                    <i class="bi bi-folder-plus"></i>
                                    Kategori
                                </a>
                            </li>
                        @endif
                    </ul>
                </div>
            </nav>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                @yield('container')
            </main>
        </div>
    </div>

    @include('partials.footer')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>
    <script src="{{ asset('/js/dashboard.js') }}"></script>
</body>

</html>
