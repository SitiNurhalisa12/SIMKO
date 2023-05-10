@extends('layouts.dashboard')
@section('container')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h2>{{ $title }}</h2>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <form action="/dashboard/user/{{ $user->id }}" method="post" class="d-inline">
                    @method('delete')
                    @csrf
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Hapus Data?')"><i
                            class="bi bi-trash"></i> Hapus Akun</button>
                </form>
            </div>
        </div>
    </div>
    <form action="/dashboard/user/{{ $user->id }}" method="POST" enctype="multipart/form-data">
        @method('put')
        @csrf
        <div class="row">
            <div class="col-lg-6">
                <div class="mb-3">
                    <label for="name" class="form-label">Nama:</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
                        required value="{{ old('name', $user->name) }}">
                    @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <label for="username" class="form-label">Username:</label>
                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1">@</span>
                    <input type="text" class="form-control @error('username') is-invalid @enderror" id="username"
                        name="username" required value="{{ old('username', $user->username) }}">
                    @error('username')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email:</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email"
                        required value="{{ old('email', $user->email) }}">
                    @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password:</label>
                    <span class="border-secondary p-1 px-2 ">
                        <i class="bi bi-eye" id="btn_pw"></i>
                    </span>
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
                    <input type="number" class="form-control @error('nohp') is-invalid @enderror" id="nohp" name="nohp"
                        required value="{{ old('nohp', $nohp) }}">
                    @error('nohp')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="norek" class="form-label">No Rekening:</label>
                    <input type="number" class="form-control @error('norek') is-invalid @enderror" id="norek" name="norek"
                        value="{{ old('norek', $user->norek) }}">
                    @error('norek')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="jenis_rek" class="form-label">Jenis Rekening:</label>
                    <input type="text" class="form-control @error('jenis_rek') is-invalid @enderror" id="jenis_rek"
                        name="jenis_rek" value="{{ old('jenis_rek', $user->jenis_rek) }}">
                    @error('jenis_rek')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="atas_nama" class="form-label">Atas Nama:</label>
                    <input type="text" class="form-control @error('atas_nama') is-invalid @enderror" id="atas_nama"
                        name="atas_nama" value="{{ old('atas_nama', $user->atas_nama) }}">
                    @error('atas_nama')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="alamat" class="form-label">Alamat:</label>
                    <textarea class="form-control  @error('norek') is-invalid @enderror" name="alamat" id="alamat" cols="30" rows="2">{{ old('alamat', $user->alamat) }}</textarea>
                    @error('norek')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="col-lg-6">
                <div class="mb-3">
                    <label for="image" class="form-label">Foto Profil <small>(max: 16mb)</small></label>
                    <input type="hidden" name="oldImage" value="{{ $user->image }}">
                    @if ($user->image)
                        <img src="{{ asset('/storage/' . $user->image) }}" alt="Foto Profil {{ $user->name }}"
                            class="img-preview img-fluid w-25 my-3 d-block">
                    @else
                        <img class="img-preview img-fluid w-25 my-3">
                    @endif
                    <input class="form-control @error('image') is-invalid @enderror" type="file" id="image" name="image"
                        onchange="previewImage()">
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
                <a href="/dashboard" class="text-dark text-decoration-none">
                    < Kembali</a>
                        <button type="submit" class="btn btn-dark">Simpan</button>
            </div>
        </div>
    </form>
    <script>
        const password = document.getElementById('password');
        const btn_pw = document.getElementById('btn_pw');

        btn_pw.addEventListener('click', function() {
            if (password.type == 'password') {
                password.type = 'text';
                btn_pw.className = 'bi bi-eye-slash';
            } else {
                password.type = 'password';
                btn_pw.className = 'bi bi-eye';
            }
        });

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
