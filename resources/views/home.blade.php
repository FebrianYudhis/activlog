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
            $('#tabelListTanggal').DataTable({
                paging: true,
                processing: true,
                serverSide: true,
                ajax: "{{ route('app') }}",
                columns: [{
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
                    [0, 'desc']
                ]
            });

            $('#tabelListTanggal').on("click", ".mintaHapus", function (event) {
                var logbookId = $(this).data('id');

                Swal.fire({
                    title: 'Alasan Minta Hapus',
                    input: 'textarea',
                    inputPlaceholder: 'Masukkan Alasan Anda...',
                    showCancelButton: true,
                    cancelButtonText: 'Batal',
                    confirmButtonText: 'Minta Hapus',
                    inputValidator: (value) => {
                        if (!value) {
                            return 'Alasan Tidak Boleh kosong!';
                        }
                    }
                }).then((result) => {
                    if (result.isConfirmed) {

                        const alasan = result.value;

                        const form = $('<form>', {
                            action: "{{ route('logbook.status', ['__ID__', 1]) }}".replace('__ID__', logbookId),
                            method: 'POST',
                            html: `@csrf @method('patch')<input type="hidden" name="alasan" value="${alasan}">`
                        });

                        $('body').append(form);
                        form.submit();
                    }
                });
            });
        });
    </script>
@endpush

@section('konten')
    <div class="card">
        <div class="card-header">List Tanggal Logbook</div>
        <div class="card-body">
            <a href="{{ route('logbook.tambah') }}" class="btn btn-primary w-100 mb-4">Tambah Data</a>
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="tabelListTanggal">
                    <thead class="table-dark">
                        <tr>
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