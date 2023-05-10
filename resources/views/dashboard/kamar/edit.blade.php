@extends('layouts.dashboard')
@section('container')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h2>{{ $title }}</h2>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a href="/dashboard/kamar/{{ $kamar->slug }}" class="btn btn-success"><i class="bi bi-eye"></i>
                    Lihat</a>
                <form action="/dashboard/kamar/{{ $kamar->slug }}" method="post" class="d-inline">
                    @method('delete')
                    @csrf
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Hapus Data?')"><i
                            class="bi bi-trash"></i> Hapus</button>
                </form>
            </div>
        </div>
    </div>
    <form action="/dashboard/kamar/{{ $kamar->slug }}" method="POST" enctype="multipart/form-data">
        @method('put')
        @csrf
        <div class="row">
            <div class="col-lg-6">
                <div class="mb-3">
                    <label for="tipe" class="form-label">Tipe Kamar:</label>
                    <input type="text" class="form-control @error('tipe') is-invalid @enderror" id="tipe"
                        name="tipe" required value="{{ old('tipe', $kamar->tipe) }}">
                    @error('tipe')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="harga" class="form-label">Harga Kamar (bulan):</label>
                    <input type="number" class="form-control @error('harga') is-invalid @enderror" id="harga"
                        name="harga" required value="{{ old('harga', $kamar->harga) }}">
                    @error('harga')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="denda" class="form-label">Denda (bulan):</label>
                    <input type="number" class="form-control @error('denda') is-invalid @enderror" id="denda"
                        name="denda" required value="{{ old('denda', $kamar->denda) }}">
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
                        name="jumlah_kamar" required value="{{ old('jumlah_kamar', $kamar->jumlah_kamar) }}">
                    @error('jumlah_kamar')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="deskripsi" class="form-label">Deskripsi:</label>
                    <textarea class="form-control  @error('deskripsi') is-invalid @enderror" name="deskripsi" id="deskripsi" cols="30"
                        rows="2">{{ old('deskripsi', $kamar->deskripsi) }}</textarea>
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
                    <input type="hidden" name="oldImage" value="{{ $kamar->image }}">
                    <center>
                        @if ($kamar->image)
                            <img src="{{ asset($kamar->image) }}" alt="Foto Kamar {{ $kamar->name }}"
                                class="img-preview img-fluid w-75 my-3 d-block">
                        @else
                            <img class="img-preview img-fluid w-75 my-3">
                        @endif
                    </center>
                    <input class="form-control @error('image') is-invalid @enderror" type="file" id="image"
                        name="image" onchange="previewImage()">
                    @error('image')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-between mb-3">
            <a href="/dashboard/kost/{{ $kamar->kost }}" class="text-dark text-decoration-none">
                < Kembali</a>
                    <button type="submit" class="btn btn-dark">Simpan</button>
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
