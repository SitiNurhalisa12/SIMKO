@extends('layouts.dashboard')
@section('container')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h2>{{ $title }} {{ $penyewaan->kamar->tipe }}</h2>
    </div>
    <form action="/dashboard/pelaporan" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" class="form-control @error('user_id') is-invalid @enderror" id="user_id" name="user_id" required
            value="{{ auth()->user()->id }}">
        <input type="hidden" class="form-control @error('penyewaan_id') is-invalid @enderror" id="penyewaan_id"
            name="penyewaan_id" required value="{{ $penyewaan->id }}">
        <div class="row">
            <div class="col-lg-6">
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama Pelaporan:</label>
                    <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama"
                        required value="{{ old('nama') }}">
                    @error('nama')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="jenis" class="form-label">Jenis:</label>
                    <select class="form-select @error('jenis') is-invalid @enderror" id="jenis" name="jenis">
                        <option value="kerusakan" @selected(old('jenis') == 'kerusakan')>Kerusakan</option>
                        <option value="perizinan" @selected(old('jenis') == 'perizinan')>Perizinan</option>
                    </select>
                    @error('jenis')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="informasi" class="form-label">Informasi:</label>
                    <textarea class="form-control  @error('informasi') is-invalid @enderror" name="informasi" id="informasi" cols="30"
                        rows="2">{{ old('informasi') }}</textarea>
                    @error('informasi')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="col-lg-6">
                <div class="mb-3">
                    <label for="image" class="form-label">Foto Bukti Laporan <small>(max: 16mb)</small></label>
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
        <div class="w-50">
            <div class="d-flex justify-content-between mb-3">
                <a href="/dashboard/pelaporan" class="text-dark text-decoration-none">
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
