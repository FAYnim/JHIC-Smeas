<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Formulir Pendaftaran</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; line-height: 1.6; }
        h1 { font-size: 18px; text-align: center; margin-bottom: 5px; }
        h2 { font-size: 14px; margin-top: 20px; border-bottom: 1px solid #333; padding-bottom: 5px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        td { padding: 5px 10px; border: 1px solid #ccc; }
        td:first-child { font-weight: bold; width: 35%; background: #f5f5f5; }
        .header { text-align: center; margin-bottom: 30px; }
        .footer { margin-top: 40px; text-align: right; }
    </style>
</head>
<body>
    <div class="header">
        <h1>FORMULIR PENDAFTARAN PESERTA DIDIK BARU</h1>
        <p>SMKN 1 Surabaya</p>
    </div>

    <h2>A. Data Pribadi</h2>
    <table>
        <tr><td>NISN</td><td>{{ $calonSiswa->nisn }}</td></tr>
        <tr><td>Nama Lengkap</td><td>{{ $calonSiswa->nama_lengkap }}</td></tr>
        <tr><td>Jenis Kelamin</td><td>{{ $calonSiswa->jenis_kelamin }}</td></tr>
        <tr><td>Tempat Lahir</td><td>{{ $calonSiswa->tempat_lahir }}</td></tr>
        <tr><td>Tanggal Lahir</td><td>{{ $calonSiswa->tanggal_lahir }}</td></tr>
        <tr><td>Alamat</td><td>{{ $calonSiswa->alamat }}</td></tr>
        <tr><td>No. WhatsApp</td><td>{{ $calonSiswa->nomor_telepon }}</td></tr>
        <tr><td>Email</td><td>{{ $calonSiswa->email }}</td></tr>
        <tr><td>Asal Sekolah</td><td>{{ $calonSiswa->asal_sekolah }}</td></tr>
    </table>

    <h2>B. Data Orang Tua</h2>
    <table>
        <tr><td>Nama Ayah</td><td>{{ $calonSiswa->nama_ayah }}</td></tr>
        <tr><td>Pekerjaan Ayah</td><td>{{ $calonSiswa->pekerjaan_ayah }}</td></tr>
        <tr><td>Nama Ibu</td><td>{{ $calonSiswa->nama_ibu }}</td></tr>
        <tr><td>Pekerjaan Ibu</td><td>{{ $calonSiswa->pekerjaan_ibu }}</td></tr>
    </table>

    <h2>C. Pilihan Jalur & Jurusan</h2>
    <table>
        <tr><td>Jalur Seleksi</td><td>{{ $calonSiswa->jalur_pendaftaran }}</td></tr>
        <tr><td>Jurusan Pilihan</td><td>{{ $calonSiswa->jurusan_pilihan }}</td></tr>
    </table>

    <div class="footer">
        <p>Surabaya, {{ date('d F Y') }}</p>
        <p>Pendaftar,</p>
        <br><br><br>
        <p><strong>{{ $calonSiswa->nama_lengkap }}</strong></p>
    </div>
</body>
</html>
