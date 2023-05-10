@extends('layouts.main')
@section('container')
    <article>
        <div class="m-5">
            <h2>{{ $title }} {{ $kost->nama }}</h2>
            <div class="card mt-3">
                <div class="d-flex justify-content-center">
                    <div class="col-lg-6">
                        <center>
                            @if ($kost->image)
                                <img src="{{ asset( $kost->image) }}" alt="Foto Kost {{ $kost->name }}"
                                    class="img-preview img-fluid my-3 d-block" width="500">
                            @else
                                <img src="https://source.unsplash.com/1200x300/?home" class="card-img-top" alt="...">
                            @endif
                        </center>
                    </div>
                    <div class="card-body col-lg-6">
                        <div>
                            <a href="/kost?jenis={{ $kost->jenis }}"
                                class="border border-success text-decoration-none text-success p-1">{{ $kost->jenis }}</a>
                            <a href="/kost?kategori={{ $kost->kategori->slug }}" class="text-decoration-none"><span
                                    class="border border-success text text-success p-1 ">{{ $kost->kategori->nama }}</span></a>
                        </div>
                        <div class="my-3">
                            <span class="m-1"><i class="bi bi-house-door"></i>{{ $jumlah }}
                                {{ $sisa === 0 ? '(Penuh)' : '(sisa ' . $sisa . ')' }}
                            </span>
                            <span class="m-1"><i class="bi bi-badge-wc"></i> {{ $kost->wc }}</span>
                            <span class="m-1"><i class="bi bi-geo-alt"></i> {{ $kost->jarak }} m</span>
                            {{-- <span class="m-1"><i class="bi bi-cash"></i>{{ $post->harga }}</span> --}}
                        </div>
                        <h4 class="card-title">{{ $kost->nama }}</h4>
                        <div class="card-text">
                            @if ($kecil === $besar)
                                <p class="mb-3"><span class="fw-bold"> Harga : </span>
                                    Rp {{ $kecil }}
                                </p>
                            @else
                                <p class="mb-3"><span class="fw-bold"> Harga : </span>
                                    Rp
                                    {{ $kecil }} -
                                    {{ $besar }}
                                </p>
                            @endif
                            <span class="fw-bold">Pemilik : </span>
                            <a href="/kost?user={{ $kost->user->username }}"
                                class="text-decoration-underline text-black">
                                {{ $kost->user->name }}
                            </a>
                            <div class="mt-2 mb-4">
                                <a class="btn btn-success" href="https://wa.me/{{ $kost->user->nohp }}" target="_blank">
                                    <i class="bi bi-whatsapp"></i> +{{ $kost->user->nohp }}
                                </a>
                                <span class="btn btn-primary">
                                    Rek : {{ $kost->user->norek }}
                                </span>
                            </div>
                            <span class="fw-bold">Deskripsi : </span>
                            <p>{{ $kost->deskripsi }}</p>
                            <span class="fw-bold">Alamat : </span>
                            <p>{{ $kost->alamat }}</p>
                        </div>
                    </div>
                </div>
                <div class="mx-4">
                    <div class="dropdown-divider"></div>
                    @if ($kamar->count())
                        <h4>Kamar</h4>
                        <div class="row">
                            @foreach ($kamar as $kmr)
                                <div class="col-lg-4 my-3 ">
                                    <center>
                                        @if ($kmr->image)
                                            <img src="{{ asset($kmr->image) }}"
                                                alt="Foto Kamar {{ $kmr->name }}" class="img-preview img-fluid d-block">
                                        @else
                                            <img src="https://source.unsplash.com/1200x300/?home" class="card-img-top"
                                                alt="...">
                                        @endif
                                    </center>
                                    <table class="m-4 mb-0">
                                        <tr>
                                            <th>Tipe</th>
                                            <td>:</td>
                                            <td>{{ $kmr->tipe }}</td>
                                        </tr>
                                        <tr>
                                            <th>Sisa Kamar</th>
                                            <td>:</td>
                                            <td>{{ $kmr->sisa_kamar }}</td>
                                        </tr>
                                        <tr>
                                            <th>Harga</th>
                                            <td>:</td>
                                            <td>{{ $kmr->harga }}</td>
                                        </tr>
                                        <tr>
                                            <th>Deskripsi</th>
                                            <td>:</td>
                                            <td></td>
                                        </tr>
                                    </table>
                                    <p class=" mx-4 mb-4">
                                        {{ $kmr->deskripsi }}
                                    </p>
                                    <div class="mx-4">
                                        @if ($kost->sisa_kamar === 0)
                                            <span style="cursor: no-drop">
                                                <button type="button" class="btn btn-secondary" style="cursor: nodrop;"
                                                    disabled>Penuh</button>
                                            </span>
                                        @else
                                            <a href="/dashboard/penyewaan/create/{{ $kmr->slug }}" class="btn btn-dark">
                                                Pesan Sekarang
                                            </a>
                                        @endif
                                        {{-- @else
                                            <a href="/dashboard/kamar/{{ $kmr->slug }}" class="btn btn-dark">
                                                Lihat Kamar
                                            </a> --}}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <h5>Tipe Kamar Belum Ada</h5>
                    @endif
                </div>
            </div>
        </div>
    </article>
@endsection
