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
            $('.dataTableLogbook').DataTable({
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

            $('#tabelDataLogbook').DataTable({
                paging: true,
                processing: true,
                serverSide: true,
                ajax: "{{ route('panel') }}",
                columns: [
                    {
                        data: 'user.name',
                        name: 'user.name',
                        orderable: false,
                    },
                    {
                        data: 'date',
                        name: 'date',
                    },
                    {
                        data: 'schedule.name',
                        name: 'schedule.name',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'aksi',
                        name: 'aksi',
                        orderable: false,
                        searchable: false
                    },
                ],
                order: [
                    [1, 'desc']
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
                <table class="table table-bordered table-striped dataTableLogbook">
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
    <div class="card mt-4">
        <div class="card-header">List Logbook Belum Diperiksa</div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped dataTableLogbook">
                    <thead class="table-dark">
                        <tr>
                            <th>Nama</th>
                            <th>Tanggal</th>
                            <th>Jadwal Dinas</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($belumDiperiksaLogbook as $item)
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
    <div class="card mt-4">
        <div class="card-header">List Semua Data Logbook Valid</div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="tabelDataLogbook">
                    <thead class="table-dark">
                        <tr>
                            <th>Nama</th>
                            <th>Tanggal</th>
                            <th>Jadwal Dinas</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
@endsection