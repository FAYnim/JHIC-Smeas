<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class SpmbController extends Controller
{
    /**
     * SPMB login page (NISN entry).
     */
    public function index()
    {
        return view('spmb.login');
    }

    /**
     * Validate the NISN input.
     * ponytail: only validates shape (10 digits) — connect to the NISN
     * registry / applicant DB when that endpoint exists.
     */
    public function login(Request $request)
    {
        $nisn = (string) $request->post('nisn', '');

        if (strlen($nisn) !== 10 || !ctype_digit($nisn)) {
            return Redirect::route('spmb.index')
                ->withInput()
                ->withErrors(['nisn' => 'NISN harus 10 digit angka.']);
        }

        return Redirect::route('spmb.dashboard')
            ->with('spmb_notice', 'Selamat datang! Lengkapi data administrasi Anda.');
    }

    /** ===== Dashboard section pages ===== */

    public function dashboard()
    {
        return view('spmb.dashboard.dashboard');
    }

    public function biodata()
    {
        return view('spmb.dashboard.biodata');
    }

    public function orangTua()
    {
        return view('spmb.dashboard.orang-tua');
    }

    public function dokumen()
    {
        return view('spmb.dashboard.dokumen');
    }

    public function formulir()
    {
        return view('spmb.dashboard.formulir');
    }

    /** ===== Form saves (flash + back, DB hookup pending) ===== */

    public function saveBiodata(Request $request)
    {
        $request->validate([
            'nisn'          => 'required|digits:10',
            'nama'          => 'required',
            'jenis_kelamin' => 'required|in:Pria,Wanita',
            'status'        => 'required',
            'alamat'        => 'required',
            'wa'            => 'required',
            'email'         => 'required|email',
            'sekolah'       => 'required',
        ], [], [
            'nisn' => 'NISN', 'nama' => 'Nama', 'jenis_kelamin' => 'Jenis Kelamin',
            'alamat' => 'Alamat', 'wa' => 'No. WA', 'sekolah' => 'Nama Sekolah',
        ]);

        // ponytail: no persistence yet — store the biodata row when the
        // applicant table exists.
        return Redirect::route('spmb.biodata')
            ->withInput()
            ->with('spmb_notice', 'Biodata tersimpan.');
    }

    public function saveOrangTua(Request $request)
    {
        $ayah = ['nama_ayah', 'pendidikan_ayah', 'pekerjaan_ayah', 'penghasilan_ayah', 'wa_ayah'];
        $ibu  = ['nama_ibu', 'pendidikan_ibu', 'pekerjaan_ibu', 'penghasilan_ibu', 'wa_ibu'];

        $request->validate(
            array_merge(
                ['status_ayah' => 'required', 'status_ibu' => 'required'],
                array_fill_keys($ayah, 'required'),
                array_fill_keys($ibu, 'required'),
            ),
            [],
            [
                'status_ayah' => 'Status Ayah', 'status_ibu' => 'Status Ibu',
                'nama_ayah' => 'Nama Ayah', 'nama_ibu' => 'Nama Ibu',
                'pendidikan_ayah' => 'Pendidikan Terakhir Ayah', 'pendidikan_ibu' => 'Pendidikan Terakhir Ibu',
                'pekerjaan_ayah' => 'Pekerjaan Utama Ayah', 'pekerjaan_ibu' => 'Pekerjaan Utama Ibu',
                'penghasilan_ayah' => 'Penghasilan Bulanan Ayah', 'penghasilan_ibu' => 'Penghasilan Bulanan Ibu',
                'wa_ayah' => 'Nomor WhatsApp Ayah', 'wa_ibu' => 'Nomor WhatsApp Ibu',
            ],
        );

        return Redirect::route('spmb.orang-tua')
            ->withInput()
            ->with('spmb_notice', 'Data orang tua tersimpan.');
    }

    public function saveDokumen(Request $request)
    {
        // ponytail: store uploads (path, size) when storage + DB are ready.
        return Redirect::route('spmb.dokumen')
            ->withInput()
            ->with('spmb_notice', 'Berkas terkirim.');
    }

    public function saveFormulir(Request $request)
    {
        $request->validate([
            'jalur' => 'required',
            'jurusan' => 'required',
            'deklarasi' => 'required',
        ], [], [
            'jalur' => 'Jalur Seleksi', 'jurusan' => 'Jurusan',
            'deklarasi' => 'Pernyataan',
        ]);

        return Redirect::route('spmb.formulir')
            ->withInput()
            ->with('spmb_notice', 'Formulir terkirim.');
    }
}
