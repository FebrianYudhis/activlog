@extends('layouts.auth')

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/page-auth.css') }}">
@endpush

@section('konten')
    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner">
                <div class="card px-sm-6 px-0">
                    <div class="card-body">
                        <h4 class="mb-1">Daftar Disini</h4>

                        <form class="mb-6" method="POST" action="{{ route('register') }}">
                            @csrf
                            <div class="mb-5">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control @error('username') is-invalid @enderror"
                                    id="username" name="username" placeholder="Masukkan Username Anda"
                                    value="{{ old('username') }}" required />
                                @error('username')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="mb-5">
                                <label for="name" class="form-label">Nama</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                    name="name" placeholder="Masukkan Nama Anda" value="{{ old('name') }}" required />
                                @error('name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="mb-5">
                                <label for="jabatan" class="form-label">Jabatan</label>
                                <input type="text" class="form-control @error('jabatan') is-invalid @enderror" id="jabatan"
                                    name="jabatan" placeholder="Masukkan Jabatan Anda" value="{{ old('jabatan') }}"
                                    required />
                                @error('jabatan')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="mb-5">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                                    name="email" placeholder="Masukkan Email Anda" value="{{ old('email') }}" required />
                                @error('email')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="mb-5">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                    id="password" name="password" placeholder="Masukkan Password Anda" required />
                                @error('password')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="mb-5">
                                <label for="password-confirm" class="form-label">Password</label>
                                <input type="password" class="form-control @error('password-confirm') is-invalid @enderror"
                                    id="password-confirm" name="password_confirmation"
                                    placeholder="Masukkan Ulang Password Anda" required />
                            </div>
                            <button class="btn btn-primary my-7 d-grid w-100">Daftar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection