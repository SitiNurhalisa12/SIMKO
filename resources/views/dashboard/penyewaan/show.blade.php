@extends('layouts.dashboard')
@section('container')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h2>{{ $title }} | {{ $penyewaan->kamar->tipe }} | {{ $penyewaan->kamar->kost->nama }}</h2>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
            </div>
        </div>
    </div>
    <div class="row">
        @if (auth()->user()->id == $penyewaan->user_id)
            <div class="col-lg-3">
                <h5>Data pemilik</h5>
                <div class="card">
                    <center class="mt-3">
                        @if ($pemilik->image)
                            <img src="{{ asset($pemilik->image) }}" alt="Foto Profil {{ $pemilik->name }}"
                                class=" img-fluid w-100 d-block card-img-top rounded-circle">
                        @else
                            <div class="text-center" style="width: 50%">
                                <img src="https://source.unsplash.com/500x500/?male" class="card-img-top rounded-circle"
                                    alt="...">
                            </div>
                        @endif
                    </center>
                    <div class="card-body p-0">
                        <h5 class="card-title mt-3 pb-0 text-center">{{ $pemilik->name }}</h5>
                        <p class="card-title pt-0 text-center"><a class="text-black"
                                href="mailto:{{ $pemilik->email }}">{{ $pemilik->email }}</a></p>
                        <div class="card-text m-0">
                            <table class="table table-bordered mb-1">
                                <tr>
                                    <td colspan="2">
                                        <a class="btn btn-success w-100" href="https://wa.me/{{ $pemilik->nohp }}"
                                            target="_blank">
                                            <i class="bi bi-whatsapp"></i> +{{ $pemilik->nohp }}
                                        </a>
                                    </td>
                                </tr>
                            </table>
                            <ul class="list-group list-group-flush fs-6">
                                <li class="list-group-item"><b>Rekening ({{ $pemilik->jenis_rek }}) :</b> <br>
                                    {{ $pemilik->norek }} (a.n {{ $pemilik->atas_nama }})</li>
                                <li class="list-group-item"><b>Alamat :</b> <br> {{ $pemilik->alamat }}</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="col-lg-3">
                <h5>Data Penyewa</h5>
                <div class="card">
                    <center class="mt-3">
                        @if ($penyewaan->user->image)
                            <img src="{{ asset($penyewaan->user->image) }}"
                                alt="Foto Profil {{ $penyewaan->user->name }}"
                                class=" img-fluid w-100 d-block card-img-top rounded-circle">
                        @else
                            <div class="text-center" style="width: 50%">
                                <img src="https://source.unsplash.com/500x500/?male" class="card-img-top rounded-circle"
                                    alt="...">
                            </div>
                        @endif
                    </center>
                    <div class="card-body p-0">
                        <h5 class="card-title mt-3 pb-0 text-center">{{ $penyewaan->user->name }}</h5>
                        <p class="card-title pt-0 text-center"><a class="text-black"
                                href="mailto:{{ $penyewaan->user->email }}">{{ $penyewaan->user->email }}</a></p>
                        <div class="card-text m-0">
                            <table class="table table-bordered mb-1">
                                <tr>
                                    <td colspan="2">
                                        <a class="btn btn-success w-100"
                                            href="https://wa.me/{{ $penyewaan->user->nohp }}" target="_blank">
                                            <i class="bi bi-whatsapp"></i> +{{ $penyewaan->user->nohp }}
                                        </a>
                                    </td>
                                </tr>
                            </table>
                            <ul class="list-group list-group-flush fs-6">
                                <li class="list-group-item"><b>Rekening ({{ $penyewaan->user->jenis_rek }}) :</b>
                                    <br>
                                    {{ $penyewaan->user->norek }} (a.n {{ $penyewaan->user->atas_nama }})
                                </li>
                                <li class="list-group-item"><b>Alamat :</b> <br> {{ $penyewaan->user->alamat }}</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <table class="table table-borderless text-black">

                </table>
            </div>
        @endif

        <div class="col-lg-4">
            <h5>Data Kamar</h5>
            <div class="card">
                @if ($penyewaan->kamar->image)
                    <img src="{{ asset($penyewaan->kamar->image) }}"
                        alt="Foto Kamar {{ $penyewaan->kamar->tipe }}"
                        class="img-preview img-fluid w-100 card-img-top d-block">
                @else
                    <img class="img-preview img-fluid w-100 card-img-top">
                @endif
                <div class="card-body p-0">
                    <h5 class="card-title my-3 text-center">{{ $penyewaan->kamar->tipe }}</h5>
                    <div class="card-text m-0">
                        <table class="table table-bordered mb-1">
                            <tr>
                                <th>Nama Kosan</th>
                                <td>
                                    <a class="text-black" href="/kostan/{{ $penyewaan->kamar->kost->slug }}">
                                        {{ $penyewaan->kamar->kost->nama }}
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <th>Tipe Kamar</th>
                                <td>{{ $penyewaan->kamar->tipe }}</td>
                            </tr>
                            <tr>
                                <th>Jumlah Kamar</th>
                                <td>{{ $penyewaan->kamar->jumlah_kamar }} (Sisa {{ $penyewaan->kamar->sisa_kamar }})
                                </td>
                            </tr>
                            <tr>
                                <th>Harga Sewa</th>
                                <td>Rp. {{ number_format($penyewaan->kamar->harga) }}</td>
                            </tr>
                        </table>
                        <ul class="list-group list-group-flush fs-6">
                            <li class="list-group-item"><b>Alamat :</b> <br> {{ $penyewaan->kamar->kost->alamat }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-5">
            <h5>Data Penyewaan</h5>
            <table class="table table-bordered table-light">
                <tr>
                    <th>Akhir Sewa</th>
                    <td>{{ DateTime::createFromFormat('Y-m-d', $penyewaan->akhir_sewa)->format('d F Y') }}
                    </td>
                </tr>
                <tr>
                    <th class="w-25">No Kamar</th>
                    <td>{{ $penyewaan->no_kamar }}</td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>{{ $penyewaan->status }}</td>
                </tr>
                <tr class="p-0">
                    <td colspan="2" class="p-0">
                        <ul class="list-group list-group-flush m-0">
                            <li class="list-group-item"><b>Keterangan :</b> <br>
                                @if ($penyewaan->status == 'menunggu')
                                    {{ $penyewaan->keterangan ?? 'Jika tidak membayar selama 1 bulan maka penyewaan akan otomatis terhapus' }}
                                @elseif ($penyewaan->status == 'disetujui')
                                    {{ $penyewaan->keterangan ?? '-' }}
                                @else
                                    {{ $penyewaan->keterangan ?? 'Jika tidak membayar selama 1 bulan maka penyewaan akan otomatis terhapus' }}
                                @endif
                            </li>
                        </ul>
                    </td>
                </tr>
            </table>
            <table class="table table-bordered table-light">
                <tr>
                    <th class="w-25">Durasi Sewa</th>
                    <td>{{ $durasi }} Bulan</td>
                </tr>
                <tr>
                    <th>Harga Kamar</th>
                    <td>
                        <span class="d-flex justify-content-between">
                            <span>
                                Rp. {{ number_format($penyewaan->kamar->harga) }}
                            </span>
                            <span>
                                x
                            </span>
                        </span>
                    </td>
                </tr>
                <tr style="border-top: 2px solid black">
                    <th>Bayar Sewa</th>
                    <td>Rp. {{ number_format($bayar) }}</td>
                </tr>
                <tr>
                    <th>Denda</th>
                    <td>
                        <span class="d-flex justify-content-between">
                            <span>
                                Rp. {{ number_format($denda) }}
                            </span>
                            <span>+</span>
                        </span>
                    </td>
                </tr>
                <tr style="border-top: 2px solid black">
                    <th>Total Bayar</th>
                    <td style="border-bottom: 2px solid black">Rp. {{ number_format($bayar + $denda) }}</td>
                </tr>
            </table>
            <div>
                @if ($penyewaan->status == 'disetujui')
                    @if (auth()->user()->status == 'penyewa')
                        <a href="/dashboard/pelaporan/create/{{ $penyewaan->slug }}" class="btn btn-primary">
                            <i class="bx bx-envelope"></i> Laporan
                        </a>
                    @else
                        <a href="/dashboard/pembayaran/{{ $pembayaran->slug }}" class="btn btn-dark">
                            <i class="bx bx-credit-card"></i> Pembayaran
                        </a>
                    @endif
                @elseif ($penyewaan->status == 'menunggak')
                    <a href="/dashboard/pembayaran/{{ $penyewaan->slug }}/edit" class="btn btn-success">
                        <i class="bx bx-dollar-circle"></i> Perpanjang
                    </a>
                @elseif ($penyewaan->status == 'menunggu')
                    @if (is_null($pembayaran))
                        <a href="/dashboard/pembayaran/create/{{ $penyewaan->slug }}" class="btn btn-success">
                            <i class="bx bx-dollar-circle"></i> Bayar
                        </a>
                    @endif
                @else
                @endif
            </div>
        </div>
    </div>
@endsection
