@extends('layouts.main')
@section('container')
    <div class="row m-5">
        <div class="text-center">
            <h2>{{ $title }}</h2>
            <center>
                <div class="col-lg-5 mt-4">
                    <form action="/kost" class="shadow" method="get">
                        @if (request('kategori'))
                            <input type="hidden" name="kategori" value="{{ request('kategori') }}">
                        @elseif (request('user'))
                            <input type="hidden" name="user" value="{{ request('user') }}">
                        @elseif (request('jenis'))
                            <input type="hidden" name="jenis" value="{{ request('jenis') }}">
                        @endif
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="Cari Kosan" aria-label="Cari Kosan"
                                aria-describedby="button-addon2" name="search" value="{{ request('search') }}">
                            <button class="btn btn-success" type="submit">Cari</button>
                        </div>
                    </form>
                </div>
            </center>
        </div>
        @if ($kost->count())
            @foreach ($kost as $k)
                @if ($k->status === 'disetujui')
                    <div class="col-md-4 mt-5">
                        <div class="card" style="width: 25rem;">
                            <!-- <a href="/kostan/{{ $k->slug }}">
                                <img src="{{ asset('/storage/' . $k->image) }}" alt="Foto Kosan {{ $k->name }}"
                                    class="img-preview img-fluid mb-3 d-block">
                            </a> -->
                            <div class="card-body">
                                <div class="my-3">
                                    <a href="/kost?jenis={{ $k->jenis }}"
                                        class="border border-success text-decoration-none text-success p-1 my-3">{{ $k->jenis }}</a>
                                    <a href="/kost?kategori={{ $k->kategori->slug }}" class="text-decoration-none my-3">
                                        <span class="border border-success text-success p-1 my-3">
                                            {{ $k->kategori->nama }}
                                        </span>
                                    </a> <br> <br>
                                </div>
                                <h4 class="card-title">{{ $k->nama }}</h4>
                                <div class="my-3">
                                    <span class="m-1">
                                        <i class="bi bi-house-door"></i>
                                        {{ $kamar->where('kost_id', $k->id)->sum('jumlah_kamar') }}
                                        {{ $kamar->where('kost_id', $k->id)->sum('sisa_kamar') === 0 ? '(Penuh)' : '(sisa ' . $kamar->where('kost_id', $k->id)->sum('sisa_kamar') . ')' }}
                                    </span>
                                    <span class="m-1"><i class="bi bi-badge-wc"></i> {{ $k->wc }}</span>
                                    <span class="m-1"><i class="bi bi-geo-alt"></i> {{ $k->jarak }}
                                        m</span>
                                </div>
                                <div class="card-text">
                                    @if ($kamar->where('kost_id', $k->id)->min('harga') == $kamar->where('kost_id', $k->id)->max('harga'))
                                        <p class="mb-3"><span class="fw-bold"> Harga : </span>
                                            Rp. {{ $kamar->where('kost_id', $k->id)->min('harga') }}
                                        </p>
                                    @else
                                        <p class="mb-3"><span class="fw-bold"> Harga : </span>
                                            Rp. {{ $kamar->where('kost_id', $k->id)->min('harga') }} - Rp.
                                            {{ $kamar->where('kost_id', $k->id)->min('harga') }}
                                        </p>
                                    @endif
                                    <p class="mb-3"><span class="fw-bold"> Pemilik : </span>
                                        <a href="/kost?user={{ $k->user->username }}"
                                            class="badge bg-outline-success text-black">{{ $k->user->name }}</a>
                                        <a class="badge bg-success text-decoration-none link-light"
                                            href="https://wa.me/{{ $k->user->nohp }}" target="_blank">
                                            <i class="bi bi-whatsapp"></i> +{{ $k->user->nohp }}
                                        </a>
                                    </p>
                                    <p class="card-text mt-3"> <span class="fw-bold"> Alamat : <br></span>
                                        {{ $k->alamat }}</p>
                                    <a href="/kostan/{{ $k->slug }}" class="btn btn-dark">Lihat Kosan</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                @endif
            @endforeach
        @else
            <center class="mt-5">
                <h4 class="mt-5">Kosan Tidak Ditemukan</h4>
            </center>
        @endif
    </div>
@endsection
