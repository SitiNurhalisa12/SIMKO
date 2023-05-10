@extends('layouts.dashboard')
@section('container')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h2>{{ $title }} {{ $pelaporan->nama }}</h2>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a href="/dashboard/pelaporan/{{ $pelaporan->slug }}" class="btn btn-success"><i class="bi bi-eye"></i>
                    Lihat</a>
                @if (auth()->user()->status == 'penyewa')
                    <form action="/dashboard/pelaporan/{{ $pelaporan->slug }}" method="post" class="d-inline">
                        @method('delete')
                        @csrf
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Hapus Data?')"><i
                                class="bi bi-trash"></i> Hapus</button>
                    </form>
                @endif
            </div>
        </div>
    </div>
    <form action="/dashboard/pelaporan/{{ $pelaporan->id }}" method="POST" enctype="multipart/form-data">
        @method('put')
        @csrf
        <div class="row">
            <div class="col-lg-6">
                <input type="hidden" class="form-control @error('penyewaan_id') is-invalid @enderror" id="penyewaan_id"
                    name="penyewaan_id" required value="{{ $pelaporan->penyewaan_id }}">
                @if (auth()->user()->status == 'pemilik')
                    <div class="mb-3">
                        <label for="status" class="form-label">status:</label>
                        <select class="form-select @error('status') is-invalid @enderror" id="status" name="status">
                            <option value="menunggu" @selected(old('status', $pelaporan->status) == 'menunggu')>menunggu</option>
                            <option value="disetujui" @selected(old('status', $pelaporan->status) == 'disetujui')>disetujui</option>
                            <option value="ditolak" @selected(old('status', $pelaporan->status) == 'ditolak')>ditolak</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="keterangan" class="form-label">keterangan:</label>
                        <textarea class="form-control  @error('keterangan') is-invalid @enderror" name="keterangan" id="keterangan" cols="30"
                            rows="2">{{ old('keterangan', $pelaporan->keterangan) }}</textarea>
                        @error('keterangan')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama Pelaporan:</label>
                        <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama"
                            required value="{{ old('nama', $pelaporan->nama) }}" readonly>
                        @error('nama')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="jenis" class="form-label">Jenis:</label>
                        <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="1"
                            required value="{{ old('jenis', $pelaporan->jenis) }}" readonly>
                        @error('jenis')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="informasi" class="form-label">Informasi:</label>
                        <textarea class="form-control  @error('informasi', $pelaporan->informasi) is-invalid @enderror" name="informasi"
                            id="informasi" cols="30" rows="2" readonly>{{ old('informasi', $pelaporan->informasi) }}</textarea>
                        @error('informasi')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                @else
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama Pelaporan:</label>
                        <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama"
                            required value="{{ old('nama', $pelaporan->nama) }}">
                        @error('nama')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="jenis" class="form-label">Jenis:</label>
                        <select class="form-select @error('jenis') is-invalid @enderror" id="jenis" name="jenis">
                            <option value="kerusakan" @selected(old('jenis', $pelaporan->jenis) == 'kerusakan')>Kerusakan</option>
                            <option value="perizinan" @selected(old('jenis', $pelaporan->jenis) == 'perizinan')>Perizinan</option>
                        </select>
                        @error('jenis')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="informasi" class="form-label">Informasi:</label>
                        <textarea class="form-control  @error('informasi', $pelaporan->informasi) is-invalid @enderror" name="informasi"
                            id="informasi" cols="30" rows="2">{{ old('informasi', $pelaporan->informasi) }}</textarea>
                        @error('informasi')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                @endif
            </div>
            <div class="col-lg-6">
                <div class="mb-3">
                    <label for="image" class="form-label">Foto Laporan <small>(max: 16mb)</small></label>
                    <center>
                        @if ($pelaporan->image)
                            <img src="{{ asset('/storage/' . $pelaporan->image) }}"
                                alt="Foto pelaporan {{ $pelaporan->nama }}"
                                class="img-preview img-fluid w-75 my-3 d-block">
                        @else
                            <img class="img-preview img-fluid w-25 my-3">
                        @endif
                    </center>
                    @if (auth()->user()->status == 'penyewa')
                        <input class="form-control @error('image') is-invalid @enderror" type="file" id="image" name="image"
                            onchange="previewImage()">
                    @endif
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
