@extends('layouts.dashboard')
@section('container')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h2>{{ $title }} | {{ $pembayaran kost->penyewaan->kamar->tipe }} |
            {{ $pembayaran kost->penyewaan->kamar->kost->nama }}</h2>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                {{-- <a href="/dashboard/pembayaran kost/{{ $pembayaran kost->id }}/edit" class="btn btn-warning"><i
                        class="bi bi-pencil"></i>
                    Edit</a>
                <form action="/dashboard/pembayaran kost/{{ $pembayaran kost->id }}" method="post" class="d-inline">
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
            @if ($pembayaran kost->image)
                <img src="{{ asset($pembayaran kost->image) }}" alt="Foto Kamar {{ $pembayaran kost->tipe }}"
                    class="img-preview img-fluid w-100 card-img-top d-block">
            @else
                <img class="img-preview img-fluid w-100 card-img-top">
            @endif
        </div>
        <div class="col-lg-4">
            <table class="table table-bordered table-light">
                <tr>
                    <th colspan="2" class="text-center fs-6">{{ $pembayaran kost->no_transfer }}</th>
                </tr>
                <tr>
                    <th class="w-25">Jenis</th>
                    <td>{{ $pembayaran kost->jenis }}</td>
                </tr>
                <tr>
                    <th>Durasi</th>
                    <td>{{ $pembayaran kost->durasi_sewa }} Bulan</td>
                </tr>
                <tr>
                    <th>Total</th>
                    <td>Rp. {{ number_format($pembayaran kost->total_bayar) }}</td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>
                        <span
                            class="badge @if ($pembayaran kost->status === 'disetujui') bg-success @elseif ($pembayaran kost->status === 'ditolak') bg-danger @else bg-secondary @endif">
                            {{ $pembayaran kost->status }}
                        </span>
                    </td>
                </tr>
                <tr>
                    <td colspan="2"><b>Komentar :</b> <br>{{ $pembayaran kost->komentar ?? '-' }}</td>
                </tr>
            </table>
            {{-- @if (auth()->user()->status == 'pemilik' && $penyewaan->status == 'menunggu') --}}
            <a href="/dashboard/pembayaran kost/{{ $pembayaran kost->slug }}/edit" class="btn btn-success"><i
                    class="bi bi-card-checklist"></i> Verifikasi</a>
            {{-- @endif --}}
            <a href="/dashboard/penyewaan/{{ $penyewaan->slug }}" class="btn btn-dark"><i
                    class="bi bi-bookmark-check"></i> Penyewaan</a>
        </div>
    </div>
@endsection
