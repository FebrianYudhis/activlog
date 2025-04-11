@extends('layouts.main')

@section('konten')
    <div class="card">
        <div class="card-header">Tambah Tugas</div>
        <div class="card-body">
            <form method="POST" action="{{ route('logbook.tugas.tambah', $dataLogbook->id) }}">
                @csrf
                <div class="mb-6">
                    <label class="form-label" for="tugas">Tugas</label>
                    <input type="text" class="form-control @error('tugas') is-invalid @enderror" id="tugas" name="tugas"
                        required>
                    @error('tugas')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary w-100">Tambah</button>
            </form>
        </div>
    </div>
@endsection