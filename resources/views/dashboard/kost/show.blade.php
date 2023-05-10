@extends('layouts.dashboard')
@section('container')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h2>{{ $title }}</h2>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a href="/dashboard/kost/{{ $kost->slug }}/edit" class="btn btn-warning mx-1"><i class="bi bi-pencil"></i>
                    Edit</a>
                @if ($kamar->count())
                    <button type="submit" class="btn btn-danger mx-1"
                        onclick="return alert('Tidak bisa dihapus karena terdapat data kamar')">
                        <i class="bi bi-trash"> Hapus</i>
                    </button>
                @else
                    <form action="/dashboard/kost/{{ $kost->id }}" method="post" class="d-inline">
                        @method('delete')
                        @csrf
                        <button type="submit" class="btn btn-danger mx-1" onclick="return confirm('Hapus Data?')"><i
                                class="bi bi-trash"></i> Hapus</button>
                    </form>
                @endif
            </div>
        </div>
    </div>
    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show mt-4" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="row">
        <div class="col-lg-4">
            <div class="card">
                @if ($kost->image)
                    <img src="{{ asset('/storage/' . $kost->image) }}" alt="Foto Kost {{ $kost->name }}"
                        class="img-preview img-fluid w-100 d-block card-img-top">
                @else
                    <img class="img-preview img-fluid w-100 card-img-top">
                @endif
                <div class="card-body p-0">
                    <h5 class="card-title my-3 text-center">{{ $kost->nama }}</h5>
                    <div class="card-text m-0">
                        <table class="table table-bordered fs-6 mb-1">
                            <tr>
                                <th>Status</th>
                                <td>{{ $kost->status }}</td>
                            </tr>
                            <tr>
                                <th>Komentar</th>
                                <td>{{ $kost->komentar ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Nama</th>
                                <td>{{ $kost->nama }}</td>
                            </tr>
                            <tr>
                                <th>WC</th>
                                <td>{{ $kost->wc }}</td>
                            </tr>
                            <tr>
                                <th>Jenis</th>
                                <td>{{ $kost->jenis }}</td>
                            </tr>
                            <tr>
                                <th>Jarak</th>
                                <td>{{ $kost->jarak }} meter</td>
                            </tr>
                            <tr>
                                <th>Jumlah</th>
                                <td>{{ $jumlah }} Kamar</td>
                            </tr>
                            <tr>
                                <th>Sisa</th>
                                <td>{{ $sisa }} Kamar</td>
                            </tr>
                            <tr>
                                <th>Harga Sewa</th>
                                @if ($min === $max)
                                    <td>Rp. {{ number_format($min) }}</td>
                                @else
                                    <td>Rp. {{ number_format($min) }} - Rp. {{ number_format($max) }}</td>
                                @endif
                            </tr>
                        </table>
                        <ul class="list-group list-group-flush fs-6">
                            <li class="list-group-item"><b>Kategori :</b> <br> {{ $kost->kategori->nama }}</li>
                            <li class="list-group-item"><b>Deskripsi :</b> <br> {{ $kost->deskripsi }}</li>
                            <li class="list-group-item"><b>Alamat :</b> <br> {{ $kost->alamat }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="d-flex justify-content-between mb-3">
                <h3>Kamar</h3>
                <a href="/dashboard/kamar/create/{{ $kost->slug }}" class="btn btn-dark"><i
                        class="bi bi-clipboard-plus"></i>
                    Tambah Kamar</a>
            </div>
            <table class="table table-bordered table-light table-sm text-center">
                <thead class="table-dark">
                    <tr>
                        <th scope="col" style="color: white">#</th>
                        <th scope="col" style="color: white">Foto</th>
                        <th scope="col" style="color: white">Tipe</th>
                        <th scope="col" style="color: white">Harga</th>
                        <th scope="col" style="color: white">Jumlah</th>
                        <th scope="col" style="color: white">Sisa</th>
                        <th scope="col" style="color: white">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($kamar as $kmr)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <center>
                                    <img src="{{ asset('/storage/' . $kmr->image) }}"
                                        alt="Foto Kost {{ $kost->nama }} Kamar {{ $kmr->tipe }}"
                                        class="img-preview img-fluid mb-3 d-block" width="125">
                                </center>
                            </td>
                            <td>{{ $kmr->tipe }}</td>
                            <td>Rp. {{ number_format($kmr->harga) }}</td>
                            <td>{{ $kmr->jumlah_kamar }}</td>
                            <td>{{ $kmr->sisa_kamar }}</td>
                            <td>
                                <a href="/dashboard/kamar/{{ $kmr->slug }}" class="btn btn-success"><i
                                        class="bx bx-info-circle"></i></a>
                                <a href="/dashboard/kamar/{{ $kmr->slug }}/edit" class="btn btn-warning"><i
                                        class="bx bx-pencil"></i></a>
                                @if ($penyewaan->where('kamar_id', $kmr->id)->where('status', '<>', 'menunggu')->count())
                                    <button type="submit" class="btn btn-danger"
                                        onclick="return alert('Tidak bisa dihapus karena terdapat data penyewaan')">
                                        <i class="bx bx-trash"></i>
                                    </button>
                                @else
                                    <form action="/dashboard/kamar/{{ $kmr->slug }}" method="post" class="d-inline">
                                        @method('delete')
                                        @csrf
                                        <button type="submit" class="btn btn-danger"
                                            onclick="return confirm('Hapus Data?')"><i class="bi bi-trash"></i></button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="d-flex justify-content-between my-5">
        <a href="/dashboard/kost" class="text-dark text-decoration-none">
            < Kembali</a>
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
