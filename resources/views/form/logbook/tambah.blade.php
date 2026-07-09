@extends('layouts.main')

@section('konten')
    <div class="card">
        <div class="card-header">Tambah Tanggal Logbook</div>
        <div class="card-body">
            <form method="POST" action="{{ route('logbook.tambah') }}">
                @csrf
                <div class="mb-6">
                    <label class="form-label" for="tanggal">Tanggal</label>
                    <input type="date" class="form-control @error('tanggal') is-invalid @enderror" id="tanggal"
                        name="tanggal" value="{{ old('tanggal') }}" required>
                    @error('tanggal')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-6">
                    <label class="form-label" for="jadwalDinas">Jadwal Dinas</label>
                    <select class="form-select @error('jadwalDinas') is-invalid @enderror" id="jadwalDinas"
                        name="jadwalDinas" required>
                        @foreach ($dataJadwalDinas as $jadwal)
                            <option value="{{ $jadwal->id }}" {{ old('jadwalDinas') == $jadwal->id ? 'selected' : '' }}>{{ $jadwal->name }}</option>
                        @endforeach
                    </select>
                    @error('jadwalDinas')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary w-100">Tambah</button>
            </form>
        </div>
    </div>
@endsection