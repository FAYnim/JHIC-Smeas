<?php

namespace App\Http\Controllers\Admin\Spmb;

use App\Http\Controllers\Controller;
use App\Models\CalonSiswa;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CalonSiswaController extends Controller
{
    public function index(Request $request): View
    {
        $query = CalonSiswa::query()->latest();

        if ($request->filled('status')) {
            $query->where('status_verifikasi', $request->query('status'));
        }

        if ($request->filled('jurusan')) {
            $query->where('jurusan_pilihan', $request->query('jurusan'));
        }

        if ($request->filled('jalur')) {
            $query->where('jalur_pendaftaran', $request->query('jalur'));
        }

        if ($request->filled('search')) {
            $search = like_escape($request->query('search'));
            $query->where(function ($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                    ->orWhere('nisn', 'like', "%{$search}%")
                    ->orWhere('asal_sekolah', 'like', "%{$search}%");
            });
        }

        $calonSiswas = $query->paginate(15)->withQueryString();

        $jurusanOptions = [
            'Rekayasa Perangkat Lunak',
            'Teknik Komputer Jaringan',
            'Bisnis Digital',
            'Manajemen Perkantoran',
            'Manajemen Logistik',
            'Desain Komunikasi Visual',
            'Perhotelan',
            'Akuntansi',
            'Produksi dan Siaran Program Televisi',
        ];

        $jalurOptions = [
            'Prestasi Akademik',
            'Prestasi Non-Akademik',
            'Domisili',
            'Afirmasi',
            'Inklusi',
        ];

        return view('admin.spmb.calon-siswa.index', compact('calonSiswas', 'jurusanOptions', 'jalurOptions'));
    }

    public function show(CalonSiswa $calonSiswa): View
    {
        $documents = $calonSiswa->dokumenStatus();

        return view('admin.spmb.calon-siswa.show', compact('calonSiswa', 'documents'));
    }

    public function updateVerifikasi(Request $request, CalonSiswa $calonSiswa): RedirectResponse
    {
        $validated = $request->validate([
            'status_verifikasi' => 'required|in:menunggu,terverifikasi,ditolak',
            'catatan_verifikasi' => 'required_if:status_verifikasi,ditolak|nullable|string|max:1000',
        ], [
            'catatan_verifikasi.required_if' => 'Catatan wajib diisi saat menolak berkas agar calon siswa tahu apa yang perlu diperbaiki.',
        ]);

        $calonSiswa->update($validated);

        return redirect()->route('admin.calon-siswa.show', $calonSiswa)
            ->with('success', 'Status verifikasi berkas berhasil diperbarui.');
    }
}
