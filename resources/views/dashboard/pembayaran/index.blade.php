@extends('layouts.dashboard')

@section('container')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h2>{{ $title }}</h2>
    </div>
    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show mt-4" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="">
        <div class="table-responsive text-center">
            <table class="table table-bordered table-light">
                <thead class="table-dark">
                    <tr>
                        <th scope="col" style="color: white">#</th>
                        <th scope="col" style="color: white">Penyewa</th>
                        <th scope="col" style="color: white">Kosan</th>
                        <th scope="col" style="color: white">Kamar</th>
                        <th scope="col" style="color: white">Durasi Sewa</th>
                        <th scope="col" style="color: white">Total</th>
                        <th scope="col" style="color: white">Status</th>
                        <th scope="col" style="color: white">Komentar</th>
                        <th scope="col" style="color: white">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pembayaran as $pb)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $pb->user->name }}</td>
                            <td>{{ $pb->penyewaan->kamar->kost->nama }}</td>
                            <td>{{ $pb->penyewaan->kamar->tipe }}</td>
                            <td>{{ $pb->durasi_sewa }} Bulan</td>
                            <td>Rp. {{ number_format($pb->total_bayar) }}</td>
                            <td>
                                <span
                                    class="badge @if ($pb->status === 'disetujui') bg-success @elseif ($pb->status === 'ditolak') bg-danger @else bg-secondary @endif">{{ $pb->status }}</span>
                            </td>
                            <td>
                                {{ $pb->komentar ?? '-' }}</td>
                            <td>
                                <a href="/dashboard/pembayaran kost/{{ $pb->slug }}" class="btn btn-success"><i
                                        class="bx bx-info-circle"></i></a>
                                {{-- <a href="/dashboard/pembayaran kost/{{ $pb->slug }}/edit" class="btn btn-warning"><i
                                        class="bx bx-pencil"></i></a> --}}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{-- <div class="d-flex justify-content-end">
            {{ $pembayaran kost->links() }}
        </div> --}}
    </div>
@endsection
