@extends('layouts.panel')

@section('konten')
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
            <span class="badge text-bg-info">{{ $dataDetail->note->note }}</span>
        </div>
    </div>
    <div class="card mt-4">
        <div class="card-body">
                <a href="{{ route('panel.logbook.hapus', $dataDetail->id) }}" class="btn @if ($dataDetail->is_invalid == null) btn-danger @else btn-success @endif w-100" data-confirm-delete="true">Hapus Logbook</a>
            </form>
        </div>
    </div>
@endsection