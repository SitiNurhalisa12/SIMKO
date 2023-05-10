@extends('layouts.dashboard')
@section('container')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h2>{{ $title }} {{ $kost->nama }}</h2>
    </div>
    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show mt-4" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <form action="/dashboard/kamar" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" class="form-control @error('kost_id') is-invalid @enderror" id="kost_id" name="kost_id"
            required value="{{ $kost->id }}">
        <div class="row">
            <div class="col-lg-6">
                <div class="mb-3">
                    <label for="tipe" class="form-label">Nama/Tipe Kamar:</label>
                    <input type="text" class="form-control @error('tipe') is-invalid @enderror" id="tipe"
                        name="tipe" required value="{{ old('tipe') }}">
                    @error('tipe')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="harga" class="form-label">Harga Kamar (bulan):</label>
                    <input type="number" class="form-control @error('harga') is-invalid @enderror" id="harga"
                        name="harga" min="0" required value="{{ old('harga') }}">
                    @error('harga')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="denda" class="form-label">Denda (bulan):</label>
                    <input type="number" class="form-control @error('denda') is-invalid @enderror" id="denda"
                        name="denda" min="0" required value="{{ old('denda') }}">
                    <small>*Denda akan muncul ketika tidak melakukan pembayaran dalam waktu 1 minggu</small>
                    @error('denda')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="jumlah_kamar" class="form-label">Jumlah Kamar:</label>
                    <input type="number" class="form-control @error('jumlah_kamar') is-invalid @enderror" id="jumlah_kamar"
                        name="jumlah_kamar" required value="{{ old('jumlah_kamar') }}">
                    @error('jumlah_kamar')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="deskripsi" class="form-label">Deskripsi:</label>
                    <textarea class="form-control  @error('deskripsi') is-invalid @enderror" name="deskripsi" id="deskripsi" cols="30"
                        rows="2" required>{{ old('deskripsi') }}</textarea>
                    @error('deskripsi')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="col-lg-6">
                <div class="mb-3">
                    <label for="image" class="form-label">Foto Kamar <small>(max: 16mb)</small></label>
                    <center>
                        <img class="img-preview img-fluid w-75 my-3">
                    </center>
                    <input class="form-control @error('image') is-invalid @enderror" type="file" id="image"
                        name="image" onchange="previewImage()" required>
                    @error('image')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="d-flex justify-content-between mb-3">
                @if (auth()->user()->status == 'pemilik')
                    <a href="/dashboard/pengajuan/{{ $kost->slug }}" class="text-dark text-decoration-none">
                        < Kembali</a>
                        @else
                            <a href="/dashboard/kost/{{ $kost->slug }}" class="text-dark text-decoration-none">
                                < Kembali</a>
                @endif
                <button type="submit" class="btn btn-dark">Simpan</button>
            </div>
        </div>
    </form>
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
