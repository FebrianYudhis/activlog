@extends('layouts.panel')

@push('js')
    <script>
        const tanggalAwal = document.getElementById('tanggalAwal');
        const tanggalAkhir = document.getElementById('tanggalAkhir');

        tanggalAwal.addEventListener('change', function () {
            const minTanggalAkhir = tanggalAwal.value;
            tanggalAkhir.setAttribute('min', minTanggalAkhir);
        });
    </script>
@endpush

@section('konten')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5>Download Data Logbook</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('panel.download-data') }}" method="POST">
                @csrf
                <div class="mb-2">
                    <label class="form-label" for="tanggalAwal">Tanggal Awal</label>
                    <input type="date" class="form-control" id="tanggalAwal" name="tanggalAwal" required>
                </div>
                <div class="mb-2">
                    <label class="form-label" for="tanggalAkhir">Tanggal Akhir</label>
                    <input type="date" class="form-control" id="tanggalAkhir" name="tanggalAkhir" required>
                </div>
                <div>
                    <label for="pengguna" class="form-label">Pengguna</label>
                    <select class="form-select" id="pengguna" name="pengguna" required>
                        @foreach ($semuaPengguna as $pengguna)
                            <option value="{{ $pengguna->id }}">{{ $pengguna->name }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-primary w-100 mt-6">Download PDF</button>
            </form>
        </div>
    </div>
@endsection
