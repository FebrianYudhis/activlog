@extends('layouts.main')

@push('css')
    <link href="https://cdn.datatables.net/v/dt/dt-2.2.2/datatables.min.css" rel="stylesheet"
        integrity="sha384-2vMryTPZxTZDZ3GnMBDVQV8OtmoutdrfJxnDTg0bVam9mZhi7Zr3J1+lkVFRr71f" crossorigin="anonymous">
@endpush

@push('js')
    <script src="https://cdn.datatables.net/v/dt/dt-2.2.2/datatables.min.js"
        integrity="sha384-2Ul6oqy3mEjM7dBJzKOck1Qb/mzlO+k/0BQv3D3C7u+Ri9+7OBINGa24AeOv5rgu"
        crossorigin="anonymous"></script>

    <script>
        $(document).ready(function () {
            $('#tabelListTugas').DataTable({});
        });
    </script>
@endpush

@section('konten')
    @if (!$isAllowed)
        <div class="alert alert-danger mb-6" role="alert">
            Anda Sudah Tidak Dapat Mengedit Logbook Ini !
        </div>
    @else
        <div class="alert alert-info mb-6" role="alert">
            Anda Dapat Mengedit Logbook Ini Sampai {{ $batasAkhir }}
        </div>
    @endif
    <div class="card mb-6">
        <div class="card-header">Catatan</div>
        <div class="card-body">
            <form method="POST" action="{{ route('logbook.catatan', $dataLogbook->id) }}">
                @csrf
                @method('PATCH')
                <div class="mb-2">
                    <textarea class="form-control @error('catatan') is-invalid @enderror" name="catatan" id="catatan"
                        rows="3" @if (!$isAllowed) disabled @endif>{{ $dataLogbook->note }}</textarea>
                    @error('catatan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-warning w-100" @if (!$isAllowed) disabled @endif>Simpan</button>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header">Tugas</div>
        <div class="card-body">
            @if ($isAllowed)
                <a href="{{ route('logbook.tugas.tambah', $dataLogbook->id) }}" class="btn btn-primary w-100 mb-4">Tambah
                    Data</a>
            @else
                <button class="btn btn-primary w-100 mb-4" disabled>Tambah Data</button>
            @endif
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="tabelListTugas">
                    <thead class="table-dark">
                        <tr>
                            <th>Waktu</th>
                            <th>Tugas</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($dataLogbook->tasks as $task)
                            <tr>
                                <td>{{ $task->time ? \Carbon\Carbon::createFromFormat('H:i:s', $task->time)->format('H:i') : '-' }}</td>
                                <td>{{ $task->task }}</td>
                                <td>
                                    @if ($isAllowed)
                                        <a href="{{ route('logbook.tugas.hapus', $task->id) }}" class="btn btn-danger w-100"
                                            data-confirm-delete="true">Hapus</a>
                                    @else
                                        <button class="btn btn-danger w-100" disabled>Hapus</button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
