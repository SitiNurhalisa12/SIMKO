@extends('layouts.main')
@section('container')
    <div class="container my-5" style="width: 500px">
        @if (session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session()->has('loginError'))
            <div class="row">
                <div class="alert alert-danger alert-dismissible fade show my-4" role="alert">
                    {{ session('loginError') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        @endif

        <h2>{{ $title }}</h2>
        <div class="shadow">
            <form action="/login" method="post" class="p-5 border">
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email"
                        required autofocus value="{{ old('email') }}">
                    @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <span class="border-secondary p-1 px-2 ">
                        <i class="bi bi-eye" id="btn_pw"></i>
                    </span>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password"
                        name="password" required>
                    <small>Tidak punya akun? <a href="/registrasi" class="text-dark"><b>Registrasi</b></a></small>
                    @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-success">Masuk</button>
            </form>
        </div>
    </div>
    <div class="mt-5">
        <br>
        <br>
    </div>
    <script>
        const password = document.getElementById('password');
        const btn_pw = document.getElementById('btn_pw');

        btn_pw.addEventListener('click', function() {
            if (password.type == 'password') {
                password.type = 'text';
                btn_pw.className = 'bi bi-eye-slash';
            } else {
                password.type = 'password';
                btn_pw.className = 'bi bi-eye';
            }
        });
    </script>
@endsection
