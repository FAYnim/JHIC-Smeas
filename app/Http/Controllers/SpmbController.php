<?php

namespace App\Http\Controllers;

use App\Models\CalonSiswa;
use App\Models\Faq;
use App\Models\Pengumuman;
use App\Models\Setting;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;
use Illuminate\Validation\Rule;

class SpmbController extends Controller
{
    public function index()
    {
        return view('spmb.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'nisn' => 'required|digits:10',
        ], [
            'nisn.required' => 'NISN wajib diisi.',
            'nisn.digits' => 'NISN harus berjumlah persis 10 digit angka.',
        ]);

        $nisn = (string) $request->post('nisn');

        $calonSiswa = CalonSiswa::where('nisn', $nisn)->first();

        if (! $calonSiswa) {
            return Redirect::route('spmb.login-page')
                ->withInput()
                ->with('spmb_error', 'NISN tidak terdaftar. Silakan hubungi panitia.');
        }

        session(['spmb_nisn' => $calonSiswa->nisn]);

        return Redirect::route('spmb.dashboard')
            ->with('spmb_notice', 'Selamat datang! Silakan lengkapi data administrasi Anda.');
    }

    public function logout(): RedirectResponse
    {
        session()->forget('spmb_nisn');

        return redirect()->route('spmb.index');
    }

    /** ===== Dashboard section pages ===== */
    public function dashboard()
    {
        return view('spmb.dashboard.dashboard');
    }

    public function biodata()
    {
        $calonSiswa = CalonSiswa::where('nisn', session('spmb_nisn'))->first();

        return view('spmb.dashboard.biodata', compact('calonSiswa'));
    }

    public function orangTua()
    {
        $calonSiswa = CalonSiswa::where('nisn', session('spmb_nisn'))->first();

        return view('spmb.dashboard.orang-tua', compact('calonSiswa'));
    }

    public function dokumen()
    {
        return view('spmb.dashboard.dokumen');
    }

    public function formulir()
    {
        $calonSiswa = CalonSiswa::where('nisn', session('spmb_nisn'))->first();

        return view('spmb.dashboard.formulir', compact('calonSiswa'));
    }

    public function verifikasi()
    {
        $calonSiswa = CalonSiswa::where('nisn', session('spmb_nisn'))->first();

        return view('spmb.dashboard.verifikasi', compact('calonSiswa'));
    }

    public function pengumuman()
    {
        $pengumumans = Pengumuman::published()->latest('published_at')->get();

        return view('spmb.dashboard.pengumuman', compact('pengumumans'));
    }

    public function bantuan()
    {
        $faqs = Faq::active()->orderBy('urutan')->get();
        $contactEmail = Setting::get('spmb_contact_email', 'spmb@smkn1.surabaya.sch.id');
        $contactPhone = Setting::get('spmb_contact_phone', '0812-3456-7890');
        $serviceHours = Setting::get('spmb_service_hours', 'Senin–Jumat, 07.30–15.00 WIB');

        return view('spmb.dashboard.bantuan', compact('faqs', 'contactEmail', 'contactPhone', 'serviceHours'));
    }

    /** ===== Form saves ===== */
    public function saveBiodata(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'jenis_kelamin' => 'required|in:Pria,Wanita',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required|date|before_or_equal:'.now()->subYears(15)->format('Y-m-d'),
            'alamat' => 'required',
            'wa' => 'required',
            'email' => 'required|email',
            'sekolah' => 'required',
            'deklarasi' => 'required',
        ], [
            'tanggal_lahir.before_or_equal' => 'Umur minimal 15 tahun.',
            'deklarasi.required' => 'Anda harus menyetujui pernyataan.',
        ], [
            'nama' => 'Nama',
            'jenis_kelamin' => 'Jenis Kelamin',
            'tempat_lahir' => 'Tempat Lahir',
            'tanggal_lahir' => 'Tanggal Lahir',
            'alamat' => 'Alamat',
            'wa' => 'No. WA',
            'email' => 'Email',
            'sekolah' => 'Nama Sekolah',
            'deklarasi' => 'Pernyataan',
        ]);

        $nisn = session('spmb_nisn');
        $calonSiswa = CalonSiswa::where('nisn', $nisn)->first();

        if ($calonSiswa) {
            $calonSiswa->update([
                'nama_lengkap' => $request->post('nama'),
                'jenis_kelamin' => $request->post('jenis_kelamin'),
                'tempat_lahir' => $request->post('tempat_lahir'),
                'tanggal_lahir' => $request->post('tanggal_lahir'),
                'alamat' => $request->post('alamat'),
                'nomor_telepon' => $request->post('wa'),
                'email' => $request->post('email'),
                'asal_sekolah' => $request->post('sekolah'),
            ]);
        }

        return Redirect::route('spmb.biodata')
            ->withInput()
            ->with('spmb_notice', 'Biodata tersimpan.');
    }

    public function saveOrangTua(Request $request)
    {
        $request->validate([
            'status_ayah' => 'required',
            'status_ibu' => 'required',
            'nama_ayah' => ['required', 'string', 'max:100', 'regex:/^[\p{L}\s\.\'\-]+$/u'],
            'nama_ibu' => ['required', 'string', 'max:100', 'regex:/^[\p{L}\s\.\'\-]+$/u'],
            'nik_ayah' => 'required|digits:16',
            'nik_ibu' => 'required|digits:16',
            'pendidikan_ayah' => 'required',
            'pendidikan_ibu' => 'required',
            'pekerjaan_ayah' => 'required',
            'pekerjaan_ibu' => 'required',
            'pekerjaan_ayah_lainnya' => 'required_if:pekerjaan_ayah,Lainnya',
            'pekerjaan_ibu_lainnya' => 'required_if:pekerjaan_ibu,Lainnya',
            'penghasilan_ayah' => ['required', Rule::in(['Tidak Bekerja', '< 2jt', '2jt - 5jt', '5jt - 10jt', '> 10jt'])],
            'penghasilan_ibu' => ['required', Rule::in(['Tidak Bekerja', '< 2jt', '2jt - 5jt', '5jt - 10jt', '> 10jt'])],
            'wa_ayah' => ['required', 'digits_between:10,16'],
            'wa_ibu' => ['required', 'digits_between:10,16'],
        ], [
            'nik_ayah.digits' => 'NIK Ayah harus 16 digit angka.',
            'nik_ibu.digits' => 'NIK Ibu harus 16 digit angka.',
            'nama_ayah.regex' => 'Nama Ayah hanya boleh berisi huruf.',
            'nama_ibu.regex' => 'Nama Ibu hanya boleh berisi huruf.',
            'wa_ayah.digits_between' => 'Nomor WhatsApp Ayah harus 10-16 digit angka.',
            'wa_ibu.digits_between' => 'Nomor WhatsApp Ibu harus 10-16 digit angka.',
            'pekerjaan_ayah_lainnya.required_if' => 'Silakan isi pekerjaan ayah.',
            'pekerjaan_ibu_lainnya.required_if' => 'Silakan isi pekerjaan ibu.',
        ], [
            'status_ayah' => 'Status Ayah',
            'status_ibu' => 'Status Ibu',
            'nama_ayah' => 'Nama Ayah',
            'nama_ibu' => 'Nama Ibu',
            'nik_ayah' => 'NIK Ayah',
            'nik_ibu' => 'NIK Ibu',
            'pendidikan_ayah' => 'Pendidikan Terakhir Ayah',
            'pendidikan_ibu' => 'Pendidikan Terakhir Ibu',
            'pekerjaan_ayah' => 'Pekerjaan Utama Ayah',
            'pekerjaan_ibu' => 'Pekerjaan Utama Ibu',
            'penghasilan_ayah' => 'Penghasilan Bulanan Ayah',
            'penghasilan_ibu' => 'Penghasilan Bulanan Ibu',
            'wa_ayah' => 'Nomor WhatsApp Ayah',
            'wa_ibu' => 'Nomor WhatsApp Ibu',
        ]);

        $nisn = session('spmb_nisn');
        $calonSiswa = CalonSiswa::where('nisn', $nisn)->first();

        if ($calonSiswa) {
            $calonSiswa->update([
                'status_ayah' => $request->post('status_ayah'),
                'nama_ayah' => $request->post('nama_ayah'),
                'nik_ayah' => $request->post('nik_ayah'),
                'pendidikan_ayah' => $request->post('pendidikan_ayah'),
                'pekerjaan_ayah' => $request->post('pekerjaan_ayah'),
                'pekerjaan_ayah_lainnya' => $request->post('pekerjaan_ayah_lainnya'),
                'penghasilan_ayah' => $request->post('penghasilan_ayah'),
                'wa_ayah' => $request->post('wa_ayah'),
                'status_ibu' => $request->post('status_ibu'),
                'nama_ibu' => $request->post('nama_ibu'),
                'nik_ibu' => $request->post('nik_ibu'),
                'pendidikan_ibu' => $request->post('pendidikan_ibu'),
                'pekerjaan_ibu' => $request->post('pekerjaan_ibu'),
                'pekerjaan_ibu_lainnya' => $request->post('pekerjaan_ibu_lainnya'),
                'penghasilan_ibu' => $request->post('penghasilan_ibu'),
                'wa_ibu' => $request->post('wa_ibu'),
            ]);
        }

        return Redirect::route('spmb.orang-tua')
            ->withInput()
            ->with('spmb_notice', 'Data orang tua tersimpan.');
    }

    public function saveDokumen(Request $request)
    {
        $request->validate([
            'docs.akta' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'docs.kartu-keluarga' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'docs.ijazah-smp' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ], [
            'docs.akta.required' => 'Akta kelahiran wajib diunggah.',
            'docs.kartu-keluarga.required' => 'Kartu keluarga wajib diunggah.',
            'docs.ijazah-smp.required' => 'Ijazah SMP wajib diunggah.',
        ]);

        $nisn = session('spmb_nisn');

        foreach ($request->file('docs') as $key => $file) {
            $path = $file->store("spmb/{$nisn}", 'public');
        }

        return Redirect::route('spmb.dokumen')
            ->with('spmb_notice', 'Dokumen tersimpan.');
    }

    public function saveFormulir(Request $request)
    {
        $request->validate([
            'jalur' => 'required|in:Prestasi Akademik,Prestasi Non-Akademik,Domisili,Afirmasi,Inklusi',
            'jurusan' => 'required|in:Rekayasa Perangkat Lunak,Teknik Komputer Jaringan,Bisnis Digital,Manajemen Perkantoran,Manajemen Logistik,Desain Komunikasi Visual,Perhotelan,Akuntansi,Produksi dan Siaran Program Televisi',
            'deklarasi' => 'required',
        ], [
            'deklarasi.required' => 'Anda harus menyetujui pernyataan.',
        ], [
            'jalur' => 'Jalur Seleksi',
            'jurusan' => 'Jurusan',
            'deklarasi' => 'Pernyataan',
        ]);

        $nisn = session('spmb_nisn');
        $calonSiswa = CalonSiswa::where('nisn', $nisn)->first();

        if ($calonSiswa) {
            $calonSiswa->update([
                'jalur_pendaftaran' => $request->post('jalur'),
                'jurusan_pilihan' => $request->post('jurusan'),
            ]);
        }

        return Redirect::route('spmb.formulir')
            ->withInput()
            ->with('spmb_notice', 'Formulir tersimpan. Silakan unduh formulir Anda.');
    }

    public function unduhFormulir()
    {
        $calonSiswa = CalonSiswa::where('nisn', session('spmb_nisn'))->firstOrFail();

        $options = new Options;
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml(View::make('spmb.dashboard.formulir-pdf', compact('calonSiswa'))->render());
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        return $dompdf->stream("formulir-{$calonSiswa->nisn}.pdf", ['Attachment' => true]);
    }
}
