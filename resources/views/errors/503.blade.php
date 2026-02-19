<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maintenance | RP Activlog</title>
    <style>
        :root {
            --bg: #f6f8fb;
            --card: #ffffff;
            --primary: #0d6efd;
            --text: #1f2937;
            --muted: #6b7280;
            --border: #e5e7eb;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(180deg, #f9fbff 0%, var(--bg) 100%);
            color: var(--text);
            display: grid;
            place-items: center;
            padding: 24px;
        }

        .card {
            width: min(680px, 100%);
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 28px;
            box-shadow: 0 10px 30px rgba(31, 41, 55, 0.08);
        }

        .badge {
            display: inline-block;
            background: rgba(13, 110, 253, 0.12);
            color: var(--primary);
            font-weight: 600;
            font-size: 12px;
            letter-spacing: 0.04em;
            text-transform: uppercase;
            border-radius: 999px;
            padding: 6px 10px;
            margin-bottom: 12px;
        }

        h1 {
            margin: 0 0 10px;
            font-size: clamp(24px, 4vw, 34px);
            line-height: 1.2;
        }

        p {
            margin: 0;
            color: var(--muted);
            line-height: 1.7;
        }

        .meta {
            margin-top: 18px;
            font-size: 14px;
            color: var(--muted);
        }
    </style>
</head>

<body>
    <main class="card">
        <span class="badge">Maintenance Mode</span>
        <h1>Layanan sedang dalam pemeliharaan</h1>
        <p>
            Mohon maaf, aplikasi <strong>RP Activlog</strong> sedang tidak tersedia sementara karena proses maintenance.
            Silakan coba kembali beberapa saat lagi.
        </p>
    </main>
</body>

</html>
