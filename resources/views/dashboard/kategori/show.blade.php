@extends('layouts.dashboard')
@section('container')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h2>{{ $title }}</h2>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a href="/dashboard/kategori/{{ $kategori->slug }}/edit" class="btn btn-warning"><i class="bi bi-pencil"></i>
                    Edit</a>
                <form action="/dashboard/kategori/{{ $kategori->slug }}" method="post" class="d-inline">
                    @method('delete')
                    @csrf
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Hapus Data?')"><i
                            class="bi bi-trash"></i> Hapus</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card">
            @if ($kategori->image)
                <img src="{{ asset('/storage/' . $kategori->image) }}" alt="Foto kategori {{ $kategori->nama }}"
                    class="img-preview img-fluid w-100 d-block card-img-top">
            @else
                <img src="https://source.unsplash.com/400x250/?dorm" class="img-preview img-fluid w-100 card-img-top">
            @endif
            <div class="card-body p-0">
                <h5 class="card-title my-3 text-center">{{ $kategori->nama }}</h5>
                <div class="card-text m-0">
                    <table class="table table-bordered fs-6 mb-1">
                        <tr>
                            <th>Slug</th>
                            <td>{{ $kategori->slug }}</td>
                        </tr>
                    </table>
                    <ul class="list-group list-group-flush fs-6">
                        <li class="list-group-item"><b>Alamat :</b> <br> {{ $kategori->alamat }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-between my-5">
        <a href="/dashboard/kategori" class="text-dark text-decoration-none">
            < Kembali</a>
    </div>
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
