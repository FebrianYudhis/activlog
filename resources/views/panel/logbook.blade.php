@extends('layouts.panel')

@section('konten')
    @if ($dataDetail->is_checked == null)
        <div class="alert alert-secondary">
            <form id="sudahDiperiksa" action="{{ route('panel.logbook.sudahDiperiksa', $dataDetail->id) }}" method="POST">
                @csrf
                @method('PATCH')
                <button type="submit" class="btn btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-bookmark-check" viewBox="0 0 16 16">
                        <path fill-rule="evenodd"
                            d="M10.854 5.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 7.793l2.646-2.647a.5.5 0 0 1 .708 0" />
                        <path
                            d="M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v13.5a.5.5 0 0 1-.777.416L8 13.101l-5.223 2.815A.5.5 0 0 1 2 15.5zm2-1a1 1 0 0 0-1 1v12.566l4.723-2.482a.5.5 0 0 1 .554 0L13 14.566V2a1 1 0 0 0-1-1z" />
                    </svg> Sudah Diperiksa
                </button>
            </form>
        </div>
    @endif
    <div class="card">
        <div class="card-header">Logbook <span class="badge text-bg-light">{{ $dataDetail->user->name }}</span></div>
        <div class="card-body">
            <div class="alert alert-primary" role="alert">
                Dinas <span class="fst-italic fw-bold">{{ $dataDetail->schedule->name }}</span> Tanggal <span
                    class="fst-italic fw-bold">{{ $dataDetail->date }}</span>
            </div>
            <ul class="list-group">
                @foreach ($dataDetail->tasks as $item)
                    <li class="list-group-item">{{ $item->task }}</li>
                @endforeach
            </ul>
        </div>
        <div class="card-footer text-body-secondary">
            <span class="badge text-bg-info wrap-badge">{{ $dataDetail->note->note }}</span>
        </div>
    </div>
    <div class="card mt-4">
        <div class="card-body">
            @if($dataDetail->is_invalid != null)
                <div class="alert alert-success" role="alert">Alasan Minta Hapus : <span
                        class="fst-italic fw-bold">{{ $dataDetail->invalid_reason }}</span></div>
            @endif

            @php
                $btnClass = $dataDetail->is_invalid !== null ? 'btn-success' : 'btn-danger';
            @endphp

            <a href="{{ route('panel.logbook.hapus', $dataDetail->id) }}" class="btn {{ $btnClass }} w-100"
                data-confirm-delete="true">
                Hapus Logbook
            </a>
        </div>
    </div>
@endsection

@push('css')
    <style>
        .wrap-badge {
            white-space: normal;
            word-wrap: break-word;
            word-break: break-word;
            text-align: left
        }
    </style>
@endpush

@push('js')
    <script>
        $(document).ready(function () {
            $('#sudahDiperiksa').on('submit', function (e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Apakah Anda Yakin?',
                    text: "Anda Tidak Dapat Mengubah Status Ini Setelah Ditandai!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Tandai!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.submit();
                    }
                })
            });
        });
    </script>
@endpush