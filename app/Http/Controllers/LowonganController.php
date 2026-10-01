<?php

namespace App\Http\Controllers;

use App\Models\Lowongan;
use App\Models\MagangApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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

    /**
     * Halaman formulir verifikasi & ajuan magang.
     */
    public function apply(string $slug)
    {
        $lowongan = Lowongan::where('slug', $slug)->firstOrFail();

        return view('pusat-karir.lamar-lowongan', compact('lowongan'));
    }

    /**
     * Proses kirim lamaran magang.
     */
    public function storeApply(Request $request, string $slug)
    {
        $lowongan = Lowongan::where('slug', $slug)->firstOrFail();

        $validated = $request->validate([
            'nisn' => ['required', 'numeric', 'digits:10'],
        ]);

        $application = MagangApplication::create([
            'lowongan_id' => $lowongan->id,
            'nisn' => $validated['nisn'],
            'registration_code' => $this->generateRegistrationCode($lowongan->company_short ?? 'TELKOM'),
            'status' => 'pending',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Ajuan lamaran magang Anda berhasil dikirim.',
            'data' => [
                'nisn' => $application->nisn,
                'registration_code' => $application->registration_code,
            ],
        ], 201);
    }

    protected function generateRegistrationCode(string $companyShort): string
    {
        $prefix = strtoupper(Str::substr(preg_replace('/[^A-Za-z]/', '', $companyShort) ?: 'TELKOM', 0, 5));

        do {
            $code = 'PKL-'.$prefix.'-'.now()->format('Ymd').'-'.strtoupper(Str::random(8));
        } while (MagangApplication::where('registration_code', $code)->exists());

        return $code;
    }
}
