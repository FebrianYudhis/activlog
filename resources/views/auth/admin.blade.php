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
                        <h4 class="mb-1">Masuk Sebagai Admin</h4>

                        <form class="mb-6" method="POST" action="{{ route('admin') }}">
                            @csrf
                            <div class="mb-6">
                                <label class="form-label" for="passkey">Passkey</label>
                                <input type="password" class="form-control @error('passkey') is-invalid @enderror"
                                    id="passkey" name="passkey" placeholder="Masukkan Kode Akses Anda" required />
                                @error('passkey')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="mb-6">
                                <button class="btn btn-primary d-grid w-100" type="submit">Masuk</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection