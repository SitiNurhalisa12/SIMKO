@extends('layouts.dashboard')
@section('container')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h2>{{ $title }} {{ $pelaporan->penyewaan->kamar->tipe }}</h2>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                @if (auth()->user()->status != 'admin')
                    <a href="/dashboard/pelaporan/{{ $pelaporan->slug }}/edit" class="btn btn-warning"><i
                            class="bi bi-pencil"></i>
                        Edit</a>
                @endif
                @if (auth()->user()->status == 'penyewa')
                    <form action="/dashboard/pelaporan/{{ $pelaporan->slug }}/" method="post" class="d-inline">
                        @method('delete')
                        @csrf
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Hapus Data?')"><i
                                class="bi bi-trash"></i> Hapus</button>
                    </form>
                @endif
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-3">
            <h5>Data Pelapor</h5>
            <div class="card">
                <center class="mt-3">
                    @if ($pelaporan->penyewaan->user->image)
                        <img src="{{ asset('/storage/' . $pelaporan->penyewaan->user->image) }}"
                            alt="Foto Profil {{ $pelaporan->penyewaan->user->name }}"
                            class=" img-fluid w-50 d-block card-img-top rounded-circle">
                    @else
                        <div class="text-center">
                            <img src="https://source.unsplash.com/500x500/?male" class="card-img-top rounded-circle w-50"
                                alt="...">
                        </div>
                    @endif
                </center>
                <div class="card-body p-0">
                    <h5 class="card-title mt-3 pb-0 text-center">{{ $pelaporan->penyewaan->user->name }}</h5>
                    <p class="card-title pt-0 text-center"><a class="text-black"
                            href="mailto:{{ $pelaporan->penyewaan->user->email }}">{{ $pelaporan->penyewaan->user->email }}</a>
                    </p>
                    <div class="card-text m-0">
                        <table class="table table-bordered mb-1">
                            <tr>
                                <td colspan="2">
                                    <a class="btn btn-success w-100"
                                        href="https://wa.me/{{ $pelaporan->penyewaan->user->nohp }}" target="_blank">
                                        <i class="bi bi-whatsapp"></i> +{{ $pelaporan->penyewaan->user->nohp }}
                                    </a>
                                </td>
                            </tr>
                        </table>
                        <ul class="list-group list-group-flush fs-6">
                            <li class="list-group-item"><b>Rekening ({{ $pelaporan->penyewaan->user->jenis_rek }}) :</b>
                                <br>
                                {{ $pelaporan->penyewaan->user->norek }} (a.n
                                {{ $pelaporan->penyewaan->user->atas_nama }})
                            </li>
                            <li class="list-group-item"><b>Alamat :</b> <br> {{ $pelaporan->penyewaan->user->alamat }}
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            {{-- <div class="dropdown-divider my-4"></div> --}}
        </div>
        <div class="col-lg-4">
            <h5>Data Kamar</h5>
            <div class="card">
                @if ($pelaporan->penyewaan->kamar->image)
                    <img src="{{ asset('/storage/' . $pelaporan->penyewaan->kamar->image) }}"
                        alt="Foto Kamar {{ $pelaporan->penyewaan->kamar->tipe }}"
                        class="img-preview img-fluid w-100 card-img-top d-block">
                @else
                    <img class="img-preview img-fluid w-100 card-img-top">
                @endif
                <div class="card-body p-0">
                    <h5 class="card-title my-3 text-center">{{ $pelaporan->penyewaan->kamar->tipe }}</h5>
                    <div class="card-text m-0">
                        <table class="table table-bordered mb-1">
                            <tr>
                                <th>Nama Kosan</th>
                                <td>
                                    <a class="text-black"
                                        href="/kostan/{{ $pelaporan->penyewaan->kamar->kost->slug }}">
                                        {{ $pelaporan->penyewaan->kamar->kost->nama }}
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <th>Tipe Kamar</th>
                                <td>{{ $pelaporan->penyewaan->kamar->tipe }}</td>
                            </tr>
                            <tr>
                                <th>Jumlah Kamar</th>
                                <td>{{ $pelaporan->penyewaan->kamar->jumlah_kamar }}</td>
                            </tr>
                            <tr>
                                <th>Harga Sewa</th>
                                <td>Rp. {{ number_format($pelaporan->penyewaan->kamar->harga) }}</td>
                            </tr>
                        </table>
                        <ul class="list-group list-group-flush fs-6">
                            <li class="list-group-item"><b>Alamat :</b> <br>
                                {{ $pelaporan->penyewaan->kamar->kost->alamat }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-5">
            <h5>Data Pelaporan</h5>
            <div class="card">
                @if ($pelaporan->image)
                    <img src="{{ asset('/storage/' . $pelaporan->image) }}" alt="Foto Kamar {{ $pelaporan->nama }}"
                        class="img-preview img-fluid w-100 card-img-top d-block">
                @else
                    <img class="img-preview img-fluid w-100 card-img-top">
                @endif
                <div class="card-body p-0">
                    <h5 class="card-title my-3 text-center">{{ $pelaporan->nama }}</h5>
                    <div class="card-text m-0">
                        <table class="table table-bordered mb-1">
                            <tr>
                                <th class="w-25">Jenis</th>
                                <td>{{ $pelaporan->jenis }}</td>
                            </tr>
                            <tr>
                                <th>Informasi</th>
                                <td>{{ $pelaporan->informasi }}</td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td><span
                                        class="badge @if ($pelaporan->status === 'disetujui') bg-success @elseif ($pelaporan->status === 'ditolak') bg-danger @else bg-secondary @endif">
                                        {{ $pelaporan->status }}
                                    </span></td>
                                {{-- <td>{{ $pelaporan->status }}</td> --}}
                            </tr>
                            <tr>
                                <th>Keterangan</th>
                                <td>{{ $pelaporan->Keterangan ?? '-' }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function previewImage() {
            const image = document.querySelector('#image');
            const imgPreview = document.querySelector('.img-preview');

            imgPreview.style.display = 'block';

            const oFReader = new FileReader();
            oFReader.readAsDataURL(image.files[0]);

            oFReader.onload = function(oFREvent) {
                imgPreview.src = oFREvent.target.result;
            }
        }
    </script>
@endsection
