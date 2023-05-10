@extends('layouts.dashboard')
@section('container')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h2>{{ $title }} | {{ $pembayaran->penyewaan->kamar->tipe }} |
            {{ $pembayaran->penyewaan->kamar->kost->nama }}</h2>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                {{-- <a href="/dashboard/pembayaran/{{ $pembayaran->id }}/edit" class="btn btn-warning"><i
                        class="bi bi-pencil"></i>
                    Edit</a>
                <form action="/dashboard/pembayaran/{{ $pembayaran->id }}" method="post" class="d-inline">
                    @method('delete')
                    @csrf
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Hapus Data?')"><i
                            class="bi bi-trash"></i> Hapus</button>
                </form> --}}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-3">
            @if ($pembayaran->image)
                <img src="{{ asset('/storage/' . $pembayaran->image) }}" alt="Foto Kamar {{ $pembayaran->tipe }}"
                    class="img-preview img-fluid w-100 card-img-top d-block">
            @else
                <img class="img-preview img-fluid w-100 card-img-top">
            @endif
        </div>
        <div class="col-lg-4">
            <form action="/dashboard/pembayaran/{{ $pembayaran->id }}" method="POST" enctype="multipart/form-data">
                @method('put')
                @csrf
                <table class="table table-bordered">
                    <tr>
                        <th colspan="2" class="text-center fs-6">{{ $pembayaran->no_transfer }}</th>
                    </tr>
                    <tr>
                        <th>Jenis</th>
                        <td>{{ $pembayaran->jenis }}</td>
                    </tr>
                    <tr>
                        <th>Durasi</th>
                        <td>{{ $pembayaran->durasi_sewa }} Bulan</td>
                    </tr>
                    <tr>
                        <th>Harga</th>
                        <td>{{ $pembayaran->harga_sewa }}</td>
                    </tr>
                    <tr>
                        <th>Denda</th>
                        <td>{{ $pembayaran->denda }}</td>
                    </tr>
                    <tr>
                        <th>Total</th>
                        <td>{{ $pembayaran->total_bayar }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>
                            <select class="form-select @error('status') is-invalid @enderror" id="status" name="status"
                                onchange="tes()">
                                <option value="menunggu" @selected(old('status', $pembayaran->status) == 'menunggu')>menunggu</option>
                                <option value="disetujui" @selected(old('status', $pembayaran->status) == 'disetujui')>disetujui</option>
                                <option value="ditolak" @selected(old('status', $pembayaran->status) == 'ditolak')>ditolak</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2"><b>Komentar :</b>
                            <textarea class="form-control  @error('komentar') is-invalid @enderror" name="komentar" id="komentar" cols="30"
                                rows="2">{{ old('komentar', $pembayaran->komentar) }}</textarea>
                            @error('komentar')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </td>
                    </tr>
                </table>
        </div>
        <div class="col-lg-4" id="table_kamar" style="display: none">
            <table class="table table-bordered">
                <tr>
                    <th colspan="2" class="text-center">{{ $pembayaran->penyewaan->kamar->tipe }}</th>
                </tr>
                <tr>
                    <td><b>No Kamar</b></td>
                    <td>
                        <input class="form-control  @error('no_kamar') is-invalid @enderror" name="no_kamar"
                            id="no_kamar">{{ old('no_kamar', $pembayaran->penyewaan->no_kamar) }}
                        @error('no_kamar')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </td>
                </tr>
                <tr>
                    <td colspan="2"><b>Keterangan :</b>
                        <textarea class="form-control  @error('keterangan') is-invalid @enderror" name="keterangan" id="keterangan" cols="30"
                            rows="2">{{ old('keterangan', $pembayaran->keterangan) }}</textarea>
                        @error('keterangan')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </td>
                </tr>
                </tr>
            </table>
        </div>
    </div>
    <div class="d-flex justify-content-center">
        <button type="submit" class="btn btn-dark">Simpan</button>
        </form>
    </div>
    <script>
        const status = document.getElementById('status');
        const table_kamar = document.getElementById('table_kamar');

        function tes() {
            if (status.value == 'disetujui') {
                table_kamar.style.display = 'initial';
            } else {
                table_kamar.style.display = 'none';
            }
        }
    </script>
@endsection
