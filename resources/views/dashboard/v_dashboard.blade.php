@extends('layouts.dashboard')
@section('container')
    <div class="row">
        <div class="col-lg-12 mb-4 order-0">
            <div class="card">
                <div class="d-flex align-items-end row">
                    <div class="col-sm-7">
                        <div class="card-body">
                            <h5 class="card-title text-primary">Hai
                                {{ auth()->user()->name }}! 🎉</h5>
                            <p class="mb-4">
                                Selamat Datang di Dashboard Sistem Informasi Pengelolaan Indekost.
                                {{-- You have done <span class="fw-bold">72%</span> more sales today.
                                Check your new badge in
                                your profile. --}}
                            </p>
                            <a href="/dashboard/profil" class="btn btn-sm btn-outline-primary">Lihat Profil</a>
                        </div>
                    </div>
                    <div class="col-sm-5 text-center text-sm-left">
                        <div class="card-body pb-0 px-0 px-md-4">
                            <img src="{{ asset('template') }}/assets/img/illustrations/man-with-laptop-light.png"
                                height="140" alt="View Badge User"
                                data-app-dark-img="illustrations/man-with-laptop-dark.png"
                                data-app-light-img="illustrations/man-with-laptop-light.png" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-md-8 col-lg-4">
            <div class="row">
                <div class="col-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title d-flex align-items-start justify-content-between">
                                <div class="avatar flex-shrink-0">
                                    <a href="/dashboard/penyewaan">
                                        <i class="text-danger bx bx-book-bookmark fs-1"></i>
                                    </a>
                                </div>
                            </div>
                            <span class="fw-semibold d-block mb-1">Penyewaan</span>
                            <h3 class="card-title mb-2">{{ $penyewaan['jumlah'] }}</h3>
                            <div class="d-flex justify-content-between">
                                <small class="text-success">
                                    <i class="bx bx-up-arrow-alt"></i> {{ $penyewaan['setuju'] }}
                                </small>
                                <small class="text-danger">
                                    <i class="bx bx-down-arrow-alt"></i> {{ $penyewaan['tolak'] }}
                                </small>
                                <small class="text-secondary">
                                    <i class="bx bx-minus"></i> {{ $penyewaan['tunggu'] }}
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title d-flex align-items-start justify-content-between">
                                <div class="avatar flex-shrink-0">
                                    <a href="/dashboard/pembayaran">
                                        <i class="text-success bx bx-credit-card fs-1"></i>
                                    </a>
                                </div>
                            </div>
                            <span class="fw-semibold d-block mb-1">Pembayaran</span>
                            <h3 class="card-title mb-2">{{ $pembayaran['jumlah'] }}</h3>
                            <div class="d-flex justify-content-between">
                                <small class="text-success">
                                    <i class="bx bx-up-arrow-alt"></i> {{ $pembayaran['setuju'] }}
                                </small>
                                <small class="text-danger">
                                    <i class="bx bx-down-arrow-alt"></i> {{ $pembayaran['tolak'] }}
                                </small>
                                <small class="text-secondary">
                                    <i class="bx bx-minus"></i> {{ $pembayaran['tunggu'] }}
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-12 col-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title d-flex align-items-start justify-content-between">
                                <div class="avatar flex-shrink-0">
                                    <a href="/dashboard/pelaporan">
                                        <i class="text-warning bx bx-receipt fs-1"></i>
                                    </a>
                                </div>
                            </div>
                            <span class="fw-semibold d-block mb-1">Pelaporan</span>
                            <h3 class="card-title mb-2">{{ $pelaporan['jumlah'] }}</h3>
                            <div class="d-flex justify-content-between">
                                <small class="text-success">
                                    <i class="bx bx-up-arrow-alt"></i> {{ $pelaporan['setuju'] }}
                                </small>
                                <small class="text-danger">
                                    <i class="bx bx-down-arrow-alt"></i> {{ $pelaporan['tolak'] }}
                                </small>
                                <small class="text-secondary">
                                    <i class="bx bx-minus"></i> {{ $pelaporan['tunggu'] }}
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
                @if (auth()->user()->status != 'penyewa')
                    <div class="col-lg-6 col-md-12 col-6 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title d-flex align-items-start justify-content-between">
                                    <div class="avatar flex-shrink-0">
                                        <a href="/dashboard/pengajuan">
                                            <i class="text-primary bx bx-archive fs-1"></i>
                                        </a>
                                    </div>
                                </div>
                                <span class="fw-semibold d-block mb-1">Pengajuan</span>
                                <h3 class="card-title mb-2">{{ $pengajuan['jumlah'] }}</h3>
                                <div class="d-flex justify-content-between">
                                    <small class="text-success">
                                        <i class="bx bx-up-arrow-alt"></i> {{ $pengajuan['setuju'] }}
                                    </small>
                                    <small class="text-danger">
                                        <i class="bx bx-down-arrow-alt"></i> {{ $pengajuan['tolak'] }}
                                    </small>
                                    <small class="text-secondary">
                                        <i class="bx bx-minus"></i> {{ $pengajuan['tunggu'] }}
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            @if (auth()->user()->status == 'admin')
                <div class="row">
                    <div class="col-lg-6 col-md-12 col-6 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title d-flex align-items-start justify-content-between">
                                    <div class="avatar flex-shrink-0">
                                        <a href="/dashboard/pelaporan">
                                            <i class="text-secondary bx bx-group fs-1"></i>
                                        </a>
                                    </div>
                                </div>
                                <span class="fw-semibold d-block mb-1">User</span>
                                <h3 class="card-title mb-2">{{ $user['jumlah'] }}</h3>
                                <div class="d-flex justify-content-between">
                                    <small class="text-success">
                                        <i class="bx bx-up-arrow-alt"></i> {{ $user['pemilik'] }}
                                    </small>
                                    <small class="text-danger">
                                        <i class="bx bx-down-arrow-alt"></i> {{ $user['penyewa'] }}
                                    </small>
                                    <small class="text-secondary">
                                        <i class="bx bx-minus"></i> {{ $user['admin'] }}
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12 col-6 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title d-flex align-items-start justify-content-between">
                                    <div class="avatar flex-shrink-0">
                                        <a href="/dashboard/pengajuan">
                                            <i class="text-info bx bx-bed fs-1"></i>
                                        </a>
                                    </div>
                                </div>
                                <span class="fw-semibold d-block mb-1">Kamar : {{ $kamar['jumlah'] }}</span>
                                <h3 class="card-title mb-2">{{ $kamar['jenis'] }}</h3>
                                <div class="d-flex justify-content-evenly">
                                    <small class="text-success">
                                        <i class="bx bx-up-arrow-alt"></i> {{ $kamar['tersedia'] }}
                                    </small>
                                    <small class="text-danger">
                                        <i class="bx bx-down-arrow-alt"></i> {{ $kamar['terisi'] }}
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
        @if (auth()->user()->status != 'penyewa')
            <div class="col-md-6 col-lg-4 col-xl-4 order-0 mb-4">
                <div class="card h-100">
                    <div class="card-header d-flex align-items-center justify-content-between pb-0">
                        <div class="card-title mb-0">
                            <h5 class="m-0 me-2">Pemasukan</h5>
                            {{-- <small class="text-muted">42.82k Jumlah Pembayaran</small> --}}
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="d-flex flex-column align-items-center gap-1">
                                <h2 class="my-3 ">Rp. {{ number_format($pembayaran['total']) }}</h2>
                            </div>
                        </div>
                        <ul class="p-0 m-0">
                            @foreach ($pembayaran['data'] as $pb)
                                @if ($pb->penyewaan->kamar->kost->user->id == auth()->user()->id)
                                    <li class="d-flex mb-4 pb-1">
                                        <div class="avatar flex-shrink-0 me-3">
                                            <a href="/dashboard/pembayaran/{{ $pb->slug }}">
                                                <span class="avatar-initial rounded bg-label-success">
                                                    <i class="bx bx-dollar"></i>
                                                </span>
                                            </a>
                                        </div>
                                        <div
                                            class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                            <div class="me-2">
                                                <h6 class="mb-0">
                                                    {{ $pb->durasi_sewa }} Bulan
                                                </h6>
                                                <small class="text-muted">
                                                    {{ $pb->penyewaan->kamar->tipe . ' No ' . $pb->penyewaan->no_kamar }}
                                                </small>
                                            </div>
                                            <div class="user-progress">
                                                <small class="fw-semibold">Rp.
                                                    {{ number_format($pb->total_bayar) }}</small>
                                            </div>
                                        </div>
                                    </li>
                                @else
                                    <li class="d-flex mb-4 pb-1">
                                        <div class="avatar flex-shrink-0 me-3">
                                            <a href="/dashboard/pembayaran/{{ $pb->slug }}">
                                                <span class="avatar-initial rounded bg-label-success">
                                                    <i class="bx bx-dollar"></i>
                                                </span>
                                            </a>
                                        </div>
                                        <div
                                            class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                            <div class="me-2">
                                                <h6 class="mb-0">
                                                    {{ $pb->penyewaan->kamar->tipe, $pb->penyewaan->no_kamar }}</h6>
                                                <small class="text-muted">
                                                    {{ $pb->penyewaan->kamar->tipe }},
                                                    {{ $pb->durasi_sewa }} Bulan,
                                                </small>
                                            </div>
                                            <div class="user-progress">
                                                <small class="fw-semibold">Rp.
                                                    {{ number_format($pb->total_bayar) }}</small>
                                            </div>
                                        </div>
                                    </li>
                                @endif
                            @endforeach
                            <li class="d-flex justify-content-center">
                                <div class="flex-shrink-0">
                                    <a href="/dashboard/pembayaran">
                                        <span class="rounded bg-label-success py-2 px-3">
                                            Lihat Lebih Banyak Data Pembayaran
                                        </span>
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4 order-2 mb-4">
                <div class="card h-100">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="card-title m-0 me-2">Pelaporan</h5>
                    </div>
                    <div class="card-body">
                        <ul class="p-0 m-0">
                            @foreach ($pelaporan['data'] as $pl)
                                @if ($pl->penyewaan->kamar->kost->user->id == auth()->user()->id)
                                    <li class="d-flex mb-4 pb-1">
                                        <div class="avatar flex-shrink-0 me-3">
                                            <a href="/dashboard/pelaporan/{{ $pl->slug }}">
                                                <span class="avatar-initial rounded bg-label-warning">
                                                    <i class="bx bx-receipt"></i>
                                                </span>
                                            </a>
                                        </div>
                                        <div
                                            class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                            <div class="me-2">
                                                <small class="text-muted d-block mb-1">{{ $pl->penyewaan->kamar->tipe }}
                                                    No. {{ $pl->penyewaan->no_kamar }}</small>
                                                <h6 class="mb-0">{{ $pl->nama }}</h6>
                                            </div>
                                            <div class="user-progress d-flex align-items-center gap-1">
                                                <span class="text-muted">{{ strtoupper($pl->status) }}</span>
                                            </div>
                                        </div>
                                    </li>
                                @else
                                    <li class="d-flex mb-4 pb-1">
                                        <div class="avatar flex-shrink-0 me-3">
                                            <a href="/dashboard/pelaporan/{{ $pl->slug }}">
                                                <span class="avatar-initial rounded bg-label-warning">
                                                    <i class="bx bx-receipt"></i>
                                                </span>
                                            </a>
                                        </div>
                                        <div
                                            class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                            <div class="me-2">
                                                <small class="text-muted d-block mb-1">{{ $pl->penyewaan->kamar->tipe }}
                                                    No. {{ $pl->penyewaan->no_kamar }}</small>
                                                <h6 class="mb-0">{{ $pl->nama }}</h6>
                                            </div>
                                            <div class="user-progress d-flex align-items-center gap-1">
                                                <span class="text-muted">{{ strtoupper($pl->status) }}</span>
                                            </div>
                                        </div>
                                    </li>
                                @endif
                            @endforeach
                            <li class="d-flex justify-content-center">
                                <div class="flex-shrink-0">
                                    <a href="/dashboard/pelaporan">
                                        <span class="rounded bg-label-warning py-2 px-3">
                                            Lihat Lebih Banyak Data Pelaporan
                                        </span>
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
