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
        <div class="row my-3 d-flex justify-content-between">
            <div class="col-lg-2">
                <a class="btn btn-dark" href="/dashboard/kost/create"><i class="bi bi-plus-circle"></i> Tambah Data</a>
            </div>
        </div>
        <div class="table-responsive text-center">
            <table class="table table-bordered table-light">
                <thead class="table-dark">
                    <tr>
                        <th scope="col" style="color: white">#</th>
                        <th scope="col" style="color: white">Nama</th>
                        <th scope="col" style="color: white">Pemilik</th>
                        <th scope="col" style="color: white">Alamat</th>
                        <th scope="col" style="color: white">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($kost as $k)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $k->nama }}</td>
                            <td>{{ $k->user->name }}</td>
                            <td>{{ $k->alamat }}</td>
                            <td>
                                <a href="/dashboard/kost/{{ $k->slug }}" class="btn btn-success"><i
                                        class="bx bx-info-circle"></i></a>
                                <a href="/dashboard/kost/{{ $k->slug }}/edit" class="btn btn-warning"><i
                                        class="bx bx-pencil"></i></a>
                                @if ($kamar->where('kost_id', $k->id)->count())
                                    <button type="submit" class="btn btn-danger"
                                        onclick="return alert('Tidak bisa dihapus karena terdapat data kamar')">
                                        <i class="bx bx-trash"></i>
                                    </button>
                                @else
                                    <form action="/dashboard/kost/{{ $k->slug }}" method="post" class="d-inline">
                                        @method('delete')
                                        @csrf
                                        <button type="submit" class="btn btn-danger"
                                            onclick="return confirm('Hapus Data?')"><i class="bi bi-trash"></i></button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-end">
            {{ $kost->links() }}
        </div>
    </div>
@endsection
