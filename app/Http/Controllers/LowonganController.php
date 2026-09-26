<?php

namespace App\Http\Controllers;

use App\Models\Lowongan;

class LowonganController extends Controller
{
    /**
     * Halaman utama Pusat Karir — kirim semua lowongan ke view.
     */
    public function index()
    {
        $lowongans = Lowongan::latest()->get();

        return view('pusat-karir.pusat-karir', compact('lowongans'));
    }

    /**
     * Halaman detail lowongan berdasarkan slug.
     */
    public function show(string $slug)
    {
        $lowongan = Lowongan::where('slug', $slug)->firstOrFail();

        return view('pusat-karir.detail-lowongan', compact('lowongan'));
    }
}
