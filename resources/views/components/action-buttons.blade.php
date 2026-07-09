<a href="{{ route('logbook', $data->id) }}" class="btn btn-primary w-100">Lihat</a>

@php
    $sekarang = now();
    $batasAkhir = \Carbon\Carbon::parse($data->due_date);
@endphp

@if ($data->tasks->count() == 0 && $sekarang->gt($batasAkhir))
    @if (is_null($data->is_invalid))
        <button class="btn btn-warning w-100 mt-1 mintaHapus" data-id="{{ $data->id }}">Minta Hapus</button>
    @else
        <form action="{{ route('logbook.status', [$data->id, 0]) }}" class="mt-1 w-100" method="POST"> 
            @csrf
            @method('patch')
            <button type="submit" class="btn btn-success w-100">Batalkan Minta Hapus</button>
        </form>
    @endif
@elseif ($sekarang->lt($batasAkhir))
    <a href="{{ route('logbook.hapus', $data->id) }}" class="btn btn-danger w-100 mt-1" data-confirm-delete="true">Hapus</a>
@endif
