@extends('layouts.dashboard')
@section('container')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h2>{{ $title }}</h2>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a href="/dashboard/user/{{ $user->id }}/edit" class="btn btn-warning "><i class="bi bi-pencil"></i>
                    Edit</a>
                <form action="/dashboard/user/{{ $user->id }}" method="post" class="d-inline">
                    @method('delete')
                    @csrf
                    <button type="submit" class="btn btn-danger mx-1" onclick="return confirm('Hapus Data?')"><i
                            class="bi bi-trash"></i> Hapus</button>
                </form>
            </div>
        </div>
    </div>
    <div class="row">
        <center>
            <div class="col-lg-4">
                <div class="card">
                    <center class="mt-3">
                        @if ($user->image)
                            <img src="{{ asset('/storage/' . $user->image) }}" alt="Foto Profil {{ $user->name }}"
                                class=" img-fluid w-50 d-block card-img-top rounded-circle">
                        @else
                            <div class="text-center">
                                <img src="https://source.unsplash.com/500x500/?male"
                                    class="card-img-top rounded-circle w-50" alt="...">
                            </div>
                        @endif
                    </center>
                    <div class="card-body p-0">
                        <div class="card-title">
                            <h5 class="mt-3 mb-0 p-0 text-center">{{ $user->name }}</h5>
                            <p class="p-0 mb-3 text-center">({{ $user->username }})</p>
                            <p class="p-0 m-0 text-center"><a class="text-black"
                                    href="mailto:{{ $user->email }}">{{ $user->email }}</a></p>
                            <p class="text-center p-0 m-0">Status : {{ $user->status }}</p>
                        </div>
                        <div class="card-text m-0">
                            <table class="table table-bordered mb-1">
                                <tr>
                                    <td colspan="2">
                                        <a class="btn btn-success w-100" href="https://wa.me/{{ $user->nohp }}"
                                            target="_blank">
                                            <i class="bi bi-whatsapp"></i> +{{ $user->nohp }}
                                        </a>
                                    </td>
                                </tr>
                            </table>
                            <ul class="list-group list-group-flush fs-6">
                                <li class="list-group-item"><b>Rekening ({{ $user->jenis_rek }}) :</b> <br>
                                    {{ $user->norek }} (a.n {{ $user->atas_nama }})</li>
                                <li class="list-group-item"><b>Alamat :</b> <br> {{ $user->alamat }}</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <table class="table table-borderless text-black">

                </table>
            </div>
        </center>
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
