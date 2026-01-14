<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Platforms Export - {{ now()->format('Y-m-d') }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        h1 {
            color: #6366f1;
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
            background-color: #6366f1;
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
        <h1>Platforms Collection Export</h1>
        <p>Generated on: {{ now()->format('F d, Y H:i:s') }}</p>
        <p>Total Platforms: {{ $platforms->count() }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Platform Name</th>
                <th>Manufacturer</th>
                <th>Release Year</th>
                <th>Games Count</th>
                <th>Description</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($platforms as $platform)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $platform->name }}</td>
                    <td>{{ $platform->manufacturer ?? 'N/A' }}</td>
                    <td>{{ $platform->release_year ?? '—' }}</td>
                    <td>{{ $platform->games_count }}</td>
                    <td>{{ \Illuminate\Support\Str::limit($platform->description ?? '—', 50) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center; padding: 20px;">No platforms found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>This document was generated automatically by Game Vault Management System.</p>
    </div>
</body>
</html>



