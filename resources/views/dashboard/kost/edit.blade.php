@extends('layouts.dashboard')
@section('container')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h2>{{ $title }}</h2>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a href="/dashboard/kost/{{ $kost->slug }}" class="btn btn-success mx-1"><i class="bi bi-eye"></i>
                    Lihat</a>
                <form action="/dashboard/kost/{{ $kost->slug }}" method="post" class="d-inline">
                    @method('delete')
                    @csrf
                    <button type="submit" class="btn btn-danger mx-1" onclick="return confirm('Hapus Data?')"><i
                            class="bi bi-trash"></i> Hapus</button>
                </form>
            </div>
        </div>
    </div>
    <form action="/dashboard/kost/{{ $kost->id }}" method="POST" enctype="multipart/form-data">
        @method('put')
        @csrf
        <div class="row">
            <div class="col-lg-6">
                <div class="mb-3">
                    <label for="status" class="form-label">status:</label>
                    <select class="form-select @error('status') is-invalid @enderror" id="status" name="status">
                        <option value="menunggu" @selected(old('status', $kost->status) == 'menunggu')>menunggu</option>
                        <option value="disetujui" @selected(old('status', $kost->status) == 'disetujui')>disetujui</option>
                        <option value="ditolak" @selected(old('status', $kost->status) == 'ditolak')>ditolak</option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="komentar" class="form-label">komentar:</label>
                    <textarea class="form-control  @error('komentar') is-invalid @enderror" name="komentar" id="komentar" cols="30"
                        rows="2">{{ old('komentar', $kost->komentar) }}</textarea>
                    @error('komentar')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama Kosan:</label>
                    <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama"
                        required value="{{ old('nama', $kost->nama) }}">
                    @error('nama')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="wc" class="form-label">WC:</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="wc" id="wc1" value="dalam"
                            @checked(old('wc', $kost->wc) == 'dalam')>
                        <label class="form-check-label" for="wc">
                            Dalam
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="wc" id="wc2" value="luar   "
                            @checked(old('wc', $kost->wc) == 'luar')>
                        <label class="form-check-label" for="wc">
                            Luar
                        </label>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="jenis" class="form-label">Jenis:</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="jenis" id="jenis1" value="campuran"
                            @checked(old('jenis', $kost->jenis) == 'campuran')>
                        <label class="form-check-label" for="jenis">
                            Campuran
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="jenis" id="jenis2" value="putra"
                            @checked(old('jenis', $kost->jenis) == 'putra')>
                        <label class="form-check-label" for="jenis">
                            Putra
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="jenis" id="jenis3" value="putri"
                            @checked(old('jenis', $kost->jenis) == 'putri')>
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
                            <option value="{{ $kt->id }}" @selected(old('kategori_id', $kost->kategori_id) == $kt->id)>{{ $kt->nama }}</option>
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
                        required value="{{ old('jarak', $kost->jarak) }}">
                    @error('jarak')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="deskripsi" class="form-label">Deskripsi:</label>
                    <textarea class="form-control  @error('deskripsi') is-invalid @enderror" name="deskripsi" id="deskripsi" cols="30"
                        rows="2">{{ old('deskripsi', $kost->deskripsi) }}</textarea>
                    @error('deskripsi')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="alamat" class="form-label">Alamat:</label>
                    <textarea class="form-control  @error('alamat') is-invalid @enderror" name="alamat" id="alamat" cols="30" rows="2">{{ old('alamat', $kost->alamat) }}</textarea>
                    @error('alamat')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="col-lg-6">
                <div class="mb-3">
                    <label for="image" class="form-label">Foto Profil <small>(max: 16mb)</small></label>
                    <input type="hidden" name="oldImage" value="{{ $kost->image }}">
                    <center>
                        @if ($kost->image)
                            <img src="{{ asset('/storage/' . $kost->image) }}" alt="Foto Profil {{ $kost->name }}"
                                class="img-preview img-fluid w-75 my-3 d-block">
                        @else
                            <img class="img-preview img-fluid w-75 my-3">
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
        </div>

        <div class="d-flex justify-content-between mb-3">
            <a href="/dashboard/kost" class="text-dark text-decoration-none">
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
