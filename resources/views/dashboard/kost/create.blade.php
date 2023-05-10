@extends('layouts.dashboard')
@section('container')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h2>{{ $title }}</h2>
    </div>
    <form action="/dashboard/kost" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-lg-6">
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama Kosan:</label>
                    <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama"
                        required value="{{ old('nama') }}">
                    @error('nama')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="user_id" class="form-label">Pemilik:</label>
                    <select class="form-select @error('user_id') is-invalid @enderror" id="user_id" name="user_id">
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}" @selected(old('user_id') == $user->id)>{{ $user->name }}</option>
                        @endforeach
                    </select>
                    @error('user_id')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="wc" class="form-label">WC:</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="wc" id="wc1" value="dalam"
                            @checked(old('wc') == 'dalam')>
                        <label class="form-check-label" for="wc">
                            Dalam
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="wc" id="wc2" value="luar   "
                            @checked(old('wc') == 'luar')>
                        <label class="form-check-label" for="wc">
                            Luar
                        </label>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="jenis" class="form-label">Jenis:</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="jenis" id="jenis1" value="campuran"
                            @checked(old('jenis') == 'campuran')>
                        <label class="form-check-label" for="jenis">
                            Campuran
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="jenis" id="jenis2" value="putra"
                            @checked(old('jenis') == 'putra')>
                        <label class="form-check-label" for="jenis">
                            Putra
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="jenis" id="jenis3" value="putri"
                            @checked(old('jenis') == 'putri')>
                        <label class="form-check-label" for="jenis">
                            Putri
                        </label>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="kategori_id" class="form-label">kategori:</label>
                    <select class="form-select @error('kategori_id') is-invalid @enderror" id="kategori_id"
                        name="kategori_id">
                        @foreach ($kategori as $kt)
                            <option value="{{ $kt->id }}" @selected(old('kategori_id') == $kt->id)>{{ $kt->nama }}</option>
                        @endforeach
                    </select>
                    @error('kategori_id')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="jarak" class="form-label">Jarak dari Kategori (meter):</label>
                    <input type="number" class="form-control @error('jarak') is-invalid @enderror" id="jarak" name="jarak"
                        required value="{{ old('jarak') }}">
                    @error('jarak')
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
                <div class="mb-3">
                    <label for="alamat" class="form-label">Alamat:</label>
                    <textarea class="form-control  @error('norek') is-invalid @enderror" name="alamat" id="alamat" cols="30" rows="2"
                        required>{{ old('alamat') }}</textarea>
                    @error('norek')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="col-6">
                <div class="mb-3">
                    <label for="image" class="form-label">Foto Kost <small>(max: 16mb)</small></label>
                    <center>
                        <img class="img-preview img-fluid w-75 my-3">
                    </center>
                    <input class="form-control @error('image') is-invalid @enderror" type="file" id="image" name="image"
                        onchange="previewImage()" required>
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
                <a href="/dashboard/kost" class="text-dark text-decoration-none">
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
