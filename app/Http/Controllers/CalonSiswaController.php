<?php

namespace App\Http\Controllers;

use App\Models\CalonSiswa;
use Illuminate\Http\Request;

class CalonSiswaController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'nisn' => 'required|digits:10|unique:calon_siswas,nisn',
            'asal_sekolah' => 'required|string|max:255',
            'nomor_telepon' => 'nullable|string|max:15',
            'alamat' => 'nullable|string',
        ]);

        // Simpan data ke database (pastikan Anda sudah mengimport model CalonSiswa di atas)
        $calonSiswa = CalonSiswa::create($validated);

        // Berikan respons
        return response()->json([
            'success' => true,
            'message' => 'Data siswa berhasil disimpan.',
            'data' => $calonSiswa,
        ], 201);
    }
}
