@extends('layouts.dashboard')
@section('container')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h2>{{ $title }}</h2>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a href="/dashboard/kategori/{{ $kategori->slug }}" class="btn btn-success"><i class="bi bi-eye"></i>
                    Lihat</a>
                <form action="/dashboard/kategori/{{ $kategori->slug }}" method="post" class="d-inline">
                    @method('delete')
                    @csrf
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Hapus Data?')"><i
                            class="bi bi-trash"></i> Hapus</button>
                </form>
            </div>
        </div>
    </div>
    <form action="/dashboard/kategori/{{ $kategori->id }}" method="POST" enctype="multipart/form-data">
        @method('put')
        @csrf
        <div class="row">
            <div class="col-lg-6">
                <div class="col-lg-6">
                    <div class="mb-3">
                        <label for="image" class="form-label">Foto kategori <small>(max: 16mb)</small></label>
                        <input type="hidden" name="oldImage" value="{{ $kategori->image }}">
                        <center>
                            @if ($kategori->image)
                                <img src="{{ asset('/storage/' . $kategori->image) }}"
                                    alt="Foto Kategori {{ $kategori->nama }}"
                                    class="img-preview img-fluid w-50 my-3 d-block">
                            @else
                                <img class="img-preview img-fluid w-50 my-3">
                            @endif
                        </center>
                        <input class="form-control @error('image') is-invalid @enderror" type="file" id="image" name="image"
                            onchange="previewImage()">
                        @error('image')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama:</label>
                    <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama"
                        required value="{{ old('nama', $kategori->nama) }}">
                    @error('nama')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="alamat" class="form-label">Alamat:</label>
                    <textarea class="form-control  @error('alamat') is-invalid @enderror" name="alamat" id="alamat" cols="30" rows="2">{{ old('alamat', $kategori->alamat) }}</textarea>
                    @error('alamat')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>

        </div>
        <div class="col-lg-6">
            <div class="d-flex justify-content-between mb-3">
                <a href="/dashboard/user" class="text-dark text-decoration-none">
                    < Kembali</a>
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
