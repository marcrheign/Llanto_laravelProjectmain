<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Games Export - {{ now()->format('Y-m-d') }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        h1 {
            color: #1e40af;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #3b82f6;
            color: white;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background-color: #f9fafb;
        }
        .header {
            margin-bottom: 20px;
        }
        .footer {
            margin-top: 20px;
            font-size: 10px;
            color: #6b7280;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Games Collection Export</h1>
        <p>Generated on: {{ now()->format('F d, Y H:i:s') }}</p>
        <p>Total Games: {{ $games->count() }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Title</th>
                <th>Genre</th>
                <th>Platform</th>
                <th>Status</th>
                <th>Release Year</th>
                <th>Notes</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($games as $game)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $game->title }}</td>
                    <td>{{ $game->genre ?? 'N/A' }}</td>
                    <td>{{ $game->platform->name ?? 'N/A' }}</td>
                    <td>{{ $game->status }}</td>
                    <td>{{ $game->release_year ?? '—' }}</td>
                    <td>{{ \Illuminate\Support\Str::limit($game->notes ?? '—', 50) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align: center; padding: 20px;">No games found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>This document was generated automatically by Game Vault Management System.</p>
    </div>
</body>
</html>



