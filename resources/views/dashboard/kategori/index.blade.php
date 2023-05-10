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
                <a class="btn btn-dark" href="/dashboard/kategori/create"><i class="bi bi-plus-circle"></i> Tambah Data</a>
            </div>
        </div>
        <div class="table-responsive text-center">
            <table class="table table-bordered table-light align-middle">
                <thead class="table-dark">
                    <tr>
                        <th scope="col" style="color: white">#</th>
                        <th scope="col" style="color: white">Foto</th>
                        <th scope="col" style="color: white">Nama</th>
                        <th scope="col" style="color: white">alamat</th>
                        <th scope="col" style="color: white">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($kategori as $ktg)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <center>
                                    @if ($ktg->image)
                                        <img src="{{ asset('/storage/' . $ktg->image) }}"
                                            alt="Foto Profil {{ $ktg->nama }}" class="img-preview img-fluid mb-3 d-block"
                                            width="125">
                                    @else
                                        -
                                    @endif
                                </center>
                            </td>

                            <td>{{ $ktg->nama }}</td>
                            <td>{{ $ktg->alamat }}</td>
                            <td>
                                <a href="/dashboard/kategori/{{ $ktg->slug }}" class="btn btn-success"><i
                                        class="bx bx-info-circle"></i></a>
                                <a href="/dashboard/kategori/{{ $ktg->slug }}/edit" class="btn btn-warning"><i
                                        class="bx bx-pencil"></i></a>
                                <form action="/dashboard/kategori/{{ $ktg->slug }}" method="post" class="d-inline">
                                    @method('delete')
                                    @csrf
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Hapus Data?')"><i
                                            class="bx bx-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-end">
            {{ $kategori->links() }}
        </div>
    </div>
@endsection
