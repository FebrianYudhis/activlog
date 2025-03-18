@extends('layouts.main')

@push('css')
    <link href="https://cdn.datatables.net/v/dt/dt-2.2.2/datatables.min.css" rel="stylesheet"
        integrity="sha384-2vMryTPZxTZDZ3GnMBDVQV8OtmoutdrfJxnDTg0bVam9mZhi7Zr3J1+lkVFRr71f" crossorigin="anonymous">
@endpush

@push('js')
    <script src="https://cdn.datatables.net/v/dt/dt-2.2.2/datatables.min.js"
        integrity="sha384-2Ul6oqy3mEjM7dBJzKOck1Qb/mzlO+k/0BQv3D3C7u+Ri9+7OBINGa24AeOv5rgu"
        crossorigin="anonymous"></script>
@endpush

@section('konten')
    <div class="card">
        <div class="card-header">Catatan</div>
        <div class="card-body">
            <form method="POST" action="{{ route('logbook.catatan', $dataLogbook->note->id) }}">
                @csrf
                @method('PATCH')
                <div class="mb-2">
                    <textarea class="form-control @error('catatan') is-invalid @enderror" name="catatan" id="catatan"
                        rows="3">{{ $dataLogbook->note->note }}</textarea>
                    @error('catatan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-warning w-100">Simpan</button>
            </form>
        </div>
    </div>
@endsection