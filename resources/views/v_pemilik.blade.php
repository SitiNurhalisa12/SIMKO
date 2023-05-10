@extends('layouts.main')
@section('container')
    <div class="row m-5">
        <h2 class="my-3">{{ $title }} {{ $user->name }}</h2>
        @foreach ($kost as $k)
            @if ($k->status === 'disetujui')
                <div class="col-md-4">
                    <div class="card" style="width: 25rem;">
                        <a href="/kostan/{{ $k->id }}">
                            <img src="{{ asset('/storage/' . $k->image) }}" alt="Foto Kosan {{ $k->name }}"
                                class="img-preview img-fluid mb-3 d-block">
                        </a>
                        <div class="card-body">
                            <div class="my-3">
                                <a href="/jenis/{{ $k->jenis }}"
                                    class="border border-success text-decoration-none text-success p-1">{{ $k->jenis }}</a>
                                <a href="/kategori/{{ $k->kategori_id }}" class="text-decoration-none"><span
                                        class="border border-success text text-success p-1">{{ $k->kategori->nama }}</span></a>
                                <span class="border border-success text-success p-1">Rp {{ $k->harga_sewa }}</span>
                            </div>
                            <h5 class="card-title">{{ $k->nama }}</h5>
                            <div class="my-3">
                                <span class="m-1"><i class="bi bi-house-door"></i>{{ $k->jumlah_kamar }}
                                    {{ $k->sisa_kamar === 0 ? '(Penuh)' : '(sisa ' . $k->sisa_kamar . ')' }}
                                </span>
                                <span class="m-1"><i class="bi bi-badge-wc"></i> {{ $k->wc }}</span>
                                <span class="m-1"><i class="bi bi-geo-alt"></i> {{ $k->jarak }} m</span>
                            </div>
                            <span class="mb-5">Pemilik :
                                <a href="/pemilik/{{ $k->user_id }}"
                                    class="badge bg-outline-success text-black">{{ $k->user->name }}</a>
                                <a class="badge bg-success text-decoration-none link-light"
                                    href="https://wa.me/{{ $k->user->nohp }}" target="_blank">
                                    <i class="bi bi-whatsapp"></i> +{{ $k->user->nohp }}
                                </a>
                            </span>
                            <p class="card-text mt-3">Alamat : {{ $k->alamat }}</p>
                            @if ($k->sisa_kamar === 0)
                                <span style="cursor: no-drop">
                                    <button type="button" class="btn btn-secondary" style="cursor: nodrop;"
                                        disabled>Penuh</button>
                                </span>
                            @else
                                <a href="/dashboard/penyewaan/{{ $k->id }}/create" class="btn btn-dark">Pesan
                                    Sekarang</a>
                            @endif
                        </div>
                    </div>
                </div>
            @else
            @endif
        @endforeach
    </div>
@endsection
