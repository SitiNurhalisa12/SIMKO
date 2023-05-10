@extends('layouts.dashboard')
@section('container')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h2>{{ $title }} tipe {{ $kamar->tipe }}</h2>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a href="/dashboard/kamar/{{ $kamar->slug }}/edit" class="btn btn-warning"><i class="bi bi-pencil"></i>
                    Edit</a>
                <form action="/dashboard/kamar/{{ $kamar->slug }}" method="post" class="d-inline">
                    @method('delete')
                    @csrf
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Hapus Data?')"><i
                            class="bi bi-trash"></i> Hapus</button>
                </form>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4">
            <div class="card">
                @if ($kamar->image)
                    <img src="{{ asset('/storage/' . $kamar->image) }}" alt="Foto Kamar {{ $kamar->name }}"
                        class="img-preview img-fluid w-100 d-block card-img-top">
                @else
                    <img class="img-preview img-fluid w-100  card-img-top">
                @endif
                <div class="card-body p-0">
                    <h5 class="card-title my-3 text-center">{{ $kamar->tipe }}</h5>
                    <div class="card-text m-0">
                        <table class="table table-bordered fs-6 mb-1 align-middle">
                            <tr>
                                <th>Tipe</th>
                                <td>{{ $kamar->tipe }}</td>
                            </tr>
                            <tr>
                                <th>Harga</th>
                                <td>Rp. {{ number_format($kamar->harga) }}/Bulan</td>
                            </tr>
                            <tr>
                                <th>Denda</th>
                                <td>Rp. {{ number_format($kamar->denda) }} <br> <small class="text-secondary">(Penunggakan
                                        1
                                        minggu)</small></td>
                            </tr>
                            <tr>
                                <th>Jumlah</th>
                                <td>{{ $kamar->jumlah_kamar }} Kamar</td>
                            </tr>
                        </table>
                        <ul class="list-group list-group-flush fs-6">
                            <li class="list-group-item"><b>Deskripsi :</b> <br> {{ $kamar->deskripsi }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <h5>Data Penyewa</h5>
            <table class="table table-bordered table-light table-sm text-center">
                <thead class="table-dark">
                    <tr>
                        <th scope="col" style="color: white">#</th>
                        <th scope="col" style="color: white">Penyewa</th>
                        <th scope="col" style="color: white">Akhir Sewa</th>
                        <th scope="col" style="color: white">No Kamar</th>
                        <th scope="col" style="color: white">Status</th>
                        <th scope="col" style="color: white">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($penyewa as $py)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $py->user->name }}</td>
                            <td>{{ DateTime::createFromFormat('Y-m-d', $py->akhir_sewa)->format('d F Y') }}</td>
                            <td>{{ $py->no_kamar }}</td>
                            <td>{{ $py->status }}</td>
                            <td>
                                <a href="/dashboard/penyewaan/{{ $py->slug }}" class="btn btn-success"><i
                                        class="bx bx-info-circle"></i></a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    </div>
    <div class="d-flex justify-content-between my-5">
        <a href="/dashboard/kost/{{ $kamar->kost->slug }}" class="text-dark text-decoration-none">
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
