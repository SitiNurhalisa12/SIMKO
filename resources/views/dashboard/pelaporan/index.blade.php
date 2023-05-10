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
    <div class="m-5">
        <div class="table-responsive text-center">
            <table class="table table-striped table-sm">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Laporan</th>
                        <th scope="col">Pelapor</th>
                        <th scope="col">Kamar</th>
                        <th scope="col">Keterangan</th>
                        <th scope="col">Status</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pelaporan as $pl)
                        @if ($pl->penyewaan->kamar->kost->user->id === auth()->user()->id || $pl->user->id === auth()->user()->id)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $pl->nama }}</td>
                                <td>{{ $pl->user->name }}</td>
                                <td>{{ $pl->penyewaan->kamar->tipe }}</td>
                                <td> {{ $pl->keterangan ?? '-' }}</td>
                                <td> <span
                                        class="badge @if ($pl->status === 'disetujui') bg-success @elseif ($pl->status === 'ditolak') bg-danger @else bg-secondary @endif">{{ $pl->status }}</span>
                                </td>
                                <td>
                                    <a href="/dashboard/pelaporan/{{ $pl->slug }}" class="btn btn-success"><i
                                            class="bi bi-eye"></i></a>
                                    <a href="/dashboard/pelaporan/{{ $pl->slug }}/edit" class="btn btn-warning"><i
                                            class="bi bi-pencil"></i></a>
                                    @if (auth()->user()->status == 'penyewa')
                                        <form action="/dashboard/pelaporan/{{ $pl->slug }}" method="post"
                                            class="d-inline">
                                            @method('delete')
                                            @csrf
                                            <button type="submit" class="btn btn-danger"
                                                onclick="return confirm('Hapus Data?')"><i class="bi bi-trash"></i></button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
        {{-- <div class="d-flex justify-content-end">
            {{ $pelaporan->links() }}
        </div> --}}
    </div>
@endsection
