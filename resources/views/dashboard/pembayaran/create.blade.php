@extends('layouts.dashboard')
@section('container')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h2>{{ $title }} Kamar {{ $kamar->tipe }}, Kost {{ $kost->nama }}</h2>
    </div>
    <div class="row">
        <div class="col-lg-7">
            <form action="/dashboard/pembayaran" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" class="form-control @error('user_id') is-invalid @enderror" id="user_id" name="user_id"
                    required value="{{ auth()->user()->id }}">
                <input type="hidden" class="form-control @error('penyewaan_id') is-invalid @enderror" id="penyewaan_id"
                    name="penyewaan_id" required value="{{ $penyewaan->id }}">
                <div class="mb-3">
                    <label for="no_transfer" class="form-label">No Transaksi:</label>
                    <input type="text" class="form-control @error('no_transfer') is-invalid @enderror" id="no_transfer"
                        name="no_transfer" required value="{{ old('no_transfer') }}">
                    @error('no_transfer')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="image" class="form-label">Foto Bukti Transaksi <small>(max: 16mb)</small></label>
                    <img class="img-preview img-fluid w-50 my-3">
                    <input class="form-control @error('image') is-invalid @enderror" type="file" id="image" name="image"
                        onchange="previewImage()" required>
                    @error('image')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="d-flex justify-content-between mb-3">
                    <a href="/dashboard/pembayaran" class="text-dark text-decoration-none">
                        < Kembali </a>
                            <button type="submit" class="btn btn-dark">Simpan</button>
                </div>
            </form>
        </div>
        <div class="col-lg-4">
            <h6>Detail Pembayaran</h6>
            <table class="table table-bordered">
                <tr class="p-0">
                    <td colspan="2" class="p-0">
                        <ul class="list-group list-group-flush m-0">
                            <li class="list-group-item"><b>Rekening Pemilik :</b> <br> BRI {{ $pemilik->norek }}
                                (a.n {{ $pemilik->atas_nama }})</li>
                        </ul>
                    </td>
                </tr>
                <tr>
                    <th>Durasi Sewa</th>
                    <td>{{ $durasi }} Bulan</td>
                </tr>
                <tr style="border-bottom:2px solid black">
                    <th>Harga Kamar</th>
                    <td>
                        <span class="d-flex justify-content-between">
                            <span>
                                Rp. {{ number_format($kamar->harga) }}
                            </span>
                            <span>x</span>
                        </span>
                    </td>
                </tr>
                <tr>
                    <th>Jumlah</th>
                    <td>Rp. {{ number_format($bayar) }}</td>
                </tr>
                <tr style="border-bottom: 2px solid black">
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
                <tr>
                    <th>Total Bayar</th>
                    <td style="border-bottom:2px solid black">Rp. {{ number_format($bayar + $denda) }}</td>
                </tr>
            </table>
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
