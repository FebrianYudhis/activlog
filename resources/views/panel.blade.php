@extends('layouts.panel')

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
            $('#tabelPermintaanHapusLogbook').DataTable({
                order: [
                    [1, 'desc']
                ],
                columnDefs: [
                    {
                        targets: [0, 2, 3],
                        orderable: false,
                        searchable: false
                    }
                ]
            });
        });
    </script>
@endpush

@section('konten')
    <div class="card">
        <div class="card-header">List Permintaan Hapus Data Logbook</div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="tabelPermintaanHapusLogbook">
                    <thead class="table-dark">
                        <tr>
                            <th>Nama</th>
                            <th>Tanggal</th>
                            <th>Jadwal Dinas</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($permintaanHapusLogbook as $item)
                            <tr>
                                <td>{{ $item->user->name }}</td>
                                <td>{{ $item->date }}</td>
                                <td>{{ $item->schedule->name }}</td>
                                <td>
                                    <a href="{{ route('panel.logbook', $item->id) }}" class="btn btn-info w-100">Detail</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection