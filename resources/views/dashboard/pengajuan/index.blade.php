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
        @if (auth()->user()->status !== 'admin')
            <div class="row my-3 d-flex justify-content-between">
                <div class="col-lg-2">
                    <a class="btn btn-dark" href="/dashboard/pengajuan/create"><i class="bi bi-plus-circle"></i> Tambah
                        Data</a>
                </div>
            </div>
        @endif
        <div class="table-responsive text-center">
            <table class="table table-bordered table-light">
                <thead class="table-dark">
                    <tr>
                        <th scope="col" style="color:white">#</th>
                        <th scope="col" style="color:white">Nama Kosan</th>
                        <th scope="col" style="color:white">Pemilik</th>
                        <th scope="col" style="color:white">Komentar</th>
                        <th scope="col" style="color:white">Status</th>
                        <th scope="col" style="color:white">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pengajuan as $pj)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $pj->nama }}</td>
                            <td>{{ $pj->user->name }}</td>
                            <td>{{ $pj->komentar ?? '-' }}</td>
                            <td>
                                <span
                                    class="badge @if ($pj->status === 'disetujui') bg-success @elseif ($pj->status === 'ditolak') bg-danger @else bg-secondary @endif">
                                    {{ $pj->status }}
                                </span>
                            </td>
                            <td>
                                <a href="/dashboard/pengajuan/{{ $pj->slug }}" class="btn btn-success"><i
                                        class="bx bx-info-circle"></i></a>
                                <a href="/dashboard/pengajuan/{{ $pj->slug }}/edit" class="btn btn-warning"><i
                                        class="bx bx-pencil"></i></a>
                                @if (auth()->user()->status == 'pemilik')
                                    <form action="/dashboard/pengajuan/{{ $pj->slug }}" method="post" class="d-inline">
                                        @method('delete')
                                        @csrf
                                        <button type="submit" class="btn btn-danger"
                                            onclick="return confirm('Hapus Data?')"><i class="bx bx-trash"></i></button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                        {{-- @if (auth()->user()->id === 'admin')
            @elseif (auth()->user()->id === $pj->user_id && auth()->user()->id !== 'admin')
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $pj->nama }}</td>
                <td>{{ $pj->user->name }}</td>
                <td>{{ $pj->alamat }}</td>
                <td>
                  <span class="badge @if ($pj->status === 'disetujui') bg-success @elseif ($pj->status === 'ditolak') bg-danger @else bg-secondary @endif">{{ $pj->status }}</span>
                </td>
                <td>
                  <a href="/dashboard/pengajuan/{{ $pj->id }}" class="btn btn-success"><i class="bi bi-eye"></i></a>
                  <a href="/dashboard/pengajuan/{{ $pj->id }}/edit" class="btn btn-warning"><i class="bi bi-pencil"></i></a>
                  <form action="/dashboard/pengajuan/{{ $pj->id }}" method="post" class="d-inline">
                    @method('delete')
                    @csrf
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Hapus Data?')"><i class="bi bi-trash"></i></button>
                  </form>
                </td>
              </tr>
            @else
            @endif --}}
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-end">
            {{ $pengajuan->links() }}
        </div>
    </div>
@endsection
