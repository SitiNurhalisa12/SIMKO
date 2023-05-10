@extends('layouts.main')
@section('container')
    <div class="container my-5" style="width: 500px">
        <h2>{{ $title }}</h2>
        <form class="p-5 border shadow" action="/registrasi" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Nama</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" required
                    autofocus value="{{ old('name') }}">
                @error('name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <label for="username" class="form-label">Username:</label>
            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1">@</span>
                <input type="text" class="form-control @error('username') is-invalid @enderror" id="username" name="username"
                    required value="{{ old('username') }}">
                @error('username')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-select @error('status') is-invalid @enderror" id="status" name="status">
                    <option value="penyewa" @selected(old('status') == 'penyewa')>Penyewa</option>
                    <option value="pemilik" @selected(old('status') == 'pemilik')>Pemilik</option>
                </select>
                @error('status')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email"
                    required value="{{ old('email') }}">
                @error('email')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password"
                    name="password" required>
                @error('password')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <label for="nohp" class="form-label">No HP:</label> <br>
            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1">+62</span>
                <input type="number" class="form-control @error('nohp') is-invalid @enderror" id="nohp" name="nohp" required
                    value="{{ old('nohp') }}">
                @error('nohp')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="norek" class="form-label">No Rekening</label>
                <input type="number" class="form-control @error('norek') is-invalid @enderror" id="norek" name="norek"
                    value="{{ old('norek') }}" required>
                @error('norek')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="jenis_rek" class="form-label">Jenis Rekening</label>
                <input type="text" class="form-control @error('jenis_rek') is-invalid @enderror" id="jenis_rek"
                    name="jenis_rek" value="{{ old('jenis_rek') }}" required>
                @error('jenis_rek')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="atas_nama" class="form-label">Atas Nama Rekening</label>
                <input type="text" class="form-control @error('atas_nama') is-invalid @enderror" id="atas_nama"
                    name="atas_nama" value="{{ old('atas_nama') }}" required>
                @error('atas_nama')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Foto Profil <small>(max: 16mb)</small></label>
                <img class="img-preview img-fluid w-25 my-3">
                <input class="form-control @error('image') is-invalid @enderror" type="file" id="image" name="image"
                    onchange="previewImage()">
                @error('image')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="alamat" class="form-label">Alamat:</label>
                <textarea class="form-control  @error('alamat') is-invalid @enderror" name="alamat" id="alamat" cols="30" rows="2">{{ old('alamat') }}</textarea>
                @error('alamat')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
                <small>Sudah punya akun?<b><a href="/login" class="text-dark">Login</a></b></small>
            </div>
            <button type="submit" class="btn btn-success">Daftar</button>
            {{-- <a href="/login" class="btn btn-success">Daftar</a> --}}
        </form>
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
