<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Bukti Pengajuan Magang {{ $application->registration_code }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #0f172a; }
        h1 { font-size: 18px; margin: 0 0 4px; }
        .sub { color: #64748b; margin-bottom: 20px; }
        .code { font-size: 16px; font-weight: bold; padding: 10px 14px; background: #eff6ff; border: 1px solid #bfdbfe; }
        table { width: 100%; border-collapse: collapse; margin-top: 16px; }
        td { padding: 8px 0; border-bottom: 1px solid #e2e8f0; }
        td:first-child { width: 35%; color: #64748b; }
    </style>
</head>
<body>
    <h1>Bukti Pengajuan Magang (PKL)</h1>
    <p class="sub">SMK Negeri 1 Surabaya &mdash; Pusat Karir</p>

    <div class="code">{{ $application->registration_code }}</div>

    <table>
        <tr><td>NISN</td><td>{{ $application->nisn }}</td></tr>
        <tr><td>Posisi Magang</td><td>{{ $application->lowongan?->title ?? '-' }}</td></tr>
        <tr><td>Mitra Industri</td><td>{{ $application->lowongan?->company_name ?? '-' }}</td></tr>
        <tr><td>Status</td><td>{{ ucfirst($application->status) }}</td></tr>
        <tr><td>Tanggal Pengajuan</td><td>{{ $application->created_at->format('d M Y H:i') }}</td></tr>
    </table>
</body>
</html>
