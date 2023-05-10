@extends('layouts.main')
@section('container')
    <div class="row m-5">
        <h2 class="my-3">{{ $title }}</h2>
        @foreach ($kategori as $k)
            <div class="col-lg-4 my-3">
                <a href="/kost?kategori={{ $k->slug }}">
                    <div class="card text-white" style="width: 25rem;">
                        @if ($k->image)
                            <img src="{{ asset('/storage/' . $k->image) }}" class="card-img-top" alt="...">
                            <div class="card-img-overlay d-flex align-items-center p-0">
                                <h6 class="card-title text-center flex-fill p-3"
                                    style="background-color: rgba(0, 0, 0, 0.7)">
                                    {{ $k->nama }}
                                </h6>
                            </div>
                        @else
                            <img src="https://source.unsplash.com/400x250/?dorm" class="card-img-top" alt="...">
                            <div class="card-img-overlay d-flex align-items-center p-0">
                                <h6 class="card-title text-center flex-fill p-3"
                                    style="background-color: rgba(0, 0, 0, 0.7)">
                                    {{ $k->nama }}
                                </h6>
                            </div>
                        @endif
                    </div>
                </a>
            </div>
        @endforeach
    </div>
@endsection
