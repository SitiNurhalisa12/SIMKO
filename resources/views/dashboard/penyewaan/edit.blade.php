@extends('layouts.dashboard')
@section('container')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h2>{{ $title }} | {{ $kamar->tipe }} | {{ $kamar->kost->nama }}</h2>
    </div>
    <div class="row">
        <div class="col-lg-4 mb-5">
            <div class="card">
                @if ($kamar->image)
                    <img src="{{ asset('/storage/' . $kamar->image) }}" alt="Foto Kamar {{ $kamar->tipe }}"
                        class="img-preview img-fluid w-100 d-block card-img-top">
                @else
                    <img class="img-preview img-fluid w-100 card-img-top">
                @endif
                <div class="card-body p-0">
                    <h5 class="card-title my-3 text-center">{{ $kamar->tipe }}</h5>
                    <div class="card-text m-0">
                        <table class="table table-bordered mb-1">
                            <tr>
                                <th class="w-50">Kosan</th>
                                <td>
                                    <a class="text-black" href="/kostan/{{ $kamar->kost->slug }}">
                                        {{ $kamar->kost->nama }}
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <th>Jumlah Kamar</th>
                                <td>{{ $kamar->jumlah_kamar }} (Sisa {{ $kamar->sisa_kamar }})</td>
                            </tr>
                            <tr>
                                <th>Harga Sewa</th>
                                <td>Rp. {{ number_format($kamar->harga) }}</td>
                            </tr>
                            <tr>
                                <th>Pemilik</th>
                                <td><a class="text-black" href="/kost?user={{ $kamar->kost->user->username }}">
                                        {{ $kamar->kost->user->name }}
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <span class="row">
                                        <a class="btn btn-success" href="https://wa.me/{{ $kamar->kost->user->nohp }}"
                                            target="_blank">
                                            <i class="bi bi-whatsapp"></i> +{{ $kamar->kost->user->nohp }}
                                        </a>
                                    </span>
                                </td>
                            </tr>
                        </table>
                        <ul class="list-group list-group-flush fs-6">
                            <li class="list-group-item"><b>Rekening :</b> <br> {{ $kamar->kost->user->jenis_rek }}.
                                {{ $kamar->kost->user->norek }} (a.n.{{ $kamar->kost->user->atas_nama }})</li>
                        </ul>
                        <ul class="list-group list-group-flush fs-6">
                            <li class="list-group-item"><b>Alamat :</b> <br> {{ $kamar->kost->alamat }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <form action="/dashboard/penyewaan/{{ $penyewaan->id }}" method="POST" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <input type="hidden" class="form-control @error('user_id') is-invalid @enderror" id="user_id" name="user_id"
                    required value="{{ auth()->user()->id }}">
                <input type="hidden" class="form-control @error('kamar_id') is-invalid @enderror" id="kamar_id"
                    name="kamar_id" required value="{{ $kamar->id }}">
                <h6>Durasi Lama Sewa (bulan)</h6>
                <div class="mb-3">
                    <label for="awal_sewa" class="form-label">Dari :</label>
                    <input type="month" class="form-control @error('awal_sewa') is-invalid @enderror" id="awal_sewa"
                        name="awal_sewa" min="{{ $penyewaan->akhir_sewa }}" value="{{ $penyewaan->akhir_sewa }}"
                        onchange="awal()" required readonly>
                    @error('awal_sewa')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="akhir_sewa" class="form-label">Sampai :</label>
                    <input type="month" class="form-control @error('akhir_sewa') is-invalid @enderror" id="akhir_sewa"
                        name="akhir_sewa" min="{{ $penyewaan->akhir_sewa }}" value="" onchange="total()" required>
                    @error('akhir_sewa')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <h6>Durasi Sewa : <span class="fw-bold" id="text_durasi_sewa"></span></h6>
                </div>
                <div class="d-flex justify-content-between mb-3">
                    <a href="/dashboard/penyewaan" class="text-dark text-decoration-none">
                        < Kembali </a>
                            <button type="submit" class="btn btn-dark">Simpan</button>
                </div>
            </form>
        </div>
    </div>
    <script>
        const awal_sewa = document.getElementById('awal_sewa');
        const akhir_sewa = document.getElementById('akhir_sewa');
        awal_sewa.style

        function awal() {
            akhir_sewa.min = awal_sewa.value;
        }

        function total() {
            if (awal_sewa.value.slice(0, 4) == akhir_sewa.value.slice(0, 4)) {
                let awal = parseInt(awal_sewa.value.slice(-2));
                let akhir = parseInt(akhir_sewa.value.slice(-2));
                let total = akhir - awal;
                document.getElementById('text_durasi_sewa').innerHTML = `${++total} Bulan`;
            } else {
                let tahun_awal = parseInt(awal_sewa.value.slice(0, 4));
                let tahun_akhir = parseInt(akhir_sewa.value.slice(0, 4));
                let bulan_awal = parseInt(awal_sewa.value.slice(-2));
                let bulan_akhir = parseInt(akhir_sewa.value.slice(-2));
                let tahun = tahun_akhir - tahun_awal;
                let bulan = bulan_akhir - bulan_awal;
                let total = (tahun * 12) + bulan;
                document.getElementById('text_durasi_sewa').innerHTML = `${++total} Bulan`;
            }
        }

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
