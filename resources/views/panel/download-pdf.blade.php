<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Logbook</title>
    <style>
        @page {
            margin: 24px 28px;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            color: #1f2937;
            font-size: 12px;
            line-height: 1.4;
        }

        .cover {
            border: 1px solid #d1d5db;
            border-radius: 8px;
            background: #f8fafc;
            padding: 14px 16px;
            margin-bottom: 18px;
        }

        .title {
            font-size: 20px;
            font-weight: bold;
            color: #0f172a;
            margin: 0 0 6px 0;
        }

        .subtitle {
            margin: 2px 0;
            color: #334155;
        }

        .section {
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            margin-bottom: 14px;
            overflow: hidden;
        }

        .section-header {
            background: #0b3c5d;
            color: #fff;
            padding: 8px 12px;
            font-weight: bold;
        }

        .section-body {
            padding: 10px 12px 12px;
        }

        .meta {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        .meta td {
            padding: 4px 0;
            vertical-align: top;
        }

        .meta .label {
            width: 110px;
            color: #475569;
            font-weight: bold;
        }

        .task-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
        }

        .task-table th,
        .task-table td {
            border: 1px solid #d1d5db;
            padding: 7px 8px;
            vertical-align: top;
        }

        .task-table th {
            background: #e2e8f0;
            color: #0f172a;
            text-align: left;
        }

        .task-col-time {
            width: 80px;
            text-align: center;
        }

        .note {
            border: 1px solid #d1d5db;
            background: #f8fafc;
            border-radius: 6px;
            padding: 8px 10px;
            white-space: pre-wrap;
        }

        .page-break {
            page-break-after: always;
        }
    </style>
</head>

<body>
    <div class="cover">
        <p class="title">Rekap Logbook Harian</p>
        <p class="subtitle"><strong>Nama:</strong> {{ $userName }}</p>
        <p class="subtitle"><strong>Periode:</strong> {{ $tanggalAwal }} s.d. {{ $tanggalAkhir }}</p>
        <p class="subtitle"><strong>Total Logbook:</strong> {{ $records->count() }} hari</p>
    </div>

    @foreach ($records as $index => $item)
        <div class="section">
            <div class="section-header">Logbook Tanggal {{ $item->date }}</div>
            <div class="section-body">
                <table class="meta">
                    <tr>
                        <td class="label">Nama</td>
                        <td>: {{ $item->user->name ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td class="label">Tanggal</td>
                        <td>: {{ $item->date }}</td>
                    </tr>
                    <tr>
                        <td class="label">Jadwal Dinas</td>
                        <td>: {{ $item->schedule->name ?? 'N/A' }}</td>
                    </tr>
                </table>

                <table class="task-table">
                    <thead>
                        <tr>
                            <th class="task-col-time">Waktu</th>
                            <th>Kegiatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($item->tasks as $task)
                            <tr>
                                <td class="task-col-time">
                                    {{ $task->time ? \Carbon\Carbon::createFromFormat('H:i:s', $task->time)->format('H:i') : '-' }}
                                </td>
                                <td>{{ $task->task }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td class="task-col-time">-</td>
                                <td>Tidak ada kegiatan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div style="margin-top: 10px;">
                    <strong>Catatan</strong>
                    <div class="note">{{ $item->note->note ?? '-' }}</div>
                </div>
            </div>
        </div>

        @if ($index < $records->count() - 1)
            <div class="page-break"></div>
        @endif
    @endforeach
</body>

</html>
