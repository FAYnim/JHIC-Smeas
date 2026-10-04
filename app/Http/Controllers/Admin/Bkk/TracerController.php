<?php

namespace App\Http\Controllers\Admin\Bkk;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Bkk\StoreAlumniRequest;
use App\Http\Requests\Admin\Bkk\UpdateAlumniRequest;
use App\Http\Requests\Admin\Bkk\UpdateTracerSettingsRequest;
use App\Models\Alumni;
use App\Models\KuesionerTracer;
use App\Models\TracerSetting;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class TracerController extends Controller
{
    public function index(Request $request): View
    {
        $tab = $request->query('tab', 'alumni');

        // Data Alumni
        $alumniQuery = Alumni::query()->latest();
        if ($request->filled('q_alumni')) {
            $q = like_escape($request->string('q_alumni')->toString());
            $alumniQuery->where(function ($builder) use ($q) {
                $builder->where('nama', 'like', "%{$q}%")
                    ->orWhere('nisn', 'like', "%{$q}%")
                    ->orWhere('jurusan', 'like', "%{$q}%");
            });
        }
        if ($request->filled('tahun_lulus')) {
            $alumniQuery->where('tahun_lulus', (int) $request->input('tahun_lulus'));
        }
        $alumnis = $alumniQuery->paginate(15, ['*'], 'alumni_page')->withQueryString();

        // Data Kuesioner
        $kuesionerQuery = KuesionerTracer::query()->latest();
        if ($request->filled('q_kuesioner')) {
            $qk = like_escape($request->string('q_kuesioner')->toString());
            $kuesionerQuery->where(function ($builder) use ($qk) {
                $builder->where('nama', 'like', "%{$qk}%")
                    ->orWhere('nisn', 'like', "%{$qk}%")
                    ->orWhere('nama_perusahaan', 'like', "%{$qk}%");
            });
        }
        if ($request->filled('status_pekerjaan')) {
            $kuesionerQuery->where('status_pekerjaan', $request->input('status_pekerjaan'));
        }
        $kuesioners = $kuesionerQuery->paginate(15, ['*'], 'kuesioner_page')->withQueryString();

        // Settings Tracer
        $setting = TracerSetting::first() ?? new TracerSetting;

        // Dropdown data
        $tahunLulusOptions = Alumni::select('tahun_lulus')->distinct()->orderByDesc('tahun_lulus')->pluck('tahun_lulus');

        return view('admin.bkk.tracer.index', compact(
            'tab',
            'alumnis',
            'kuesioners',
            'setting',
            'tahunLulusOptions'
        ));
    }

    public function createAlumni(): View
    {
        return view('admin.bkk.tracer.alumni.create');
    }

    public function storeAlumni(StoreAlumniRequest $request): RedirectResponse
    {
        Alumni::create($request->validated());

        return redirect()->route('admin.tracer.index', ['tab' => 'alumni'])
            ->with('success', 'Data alumni berhasil ditambahkan.');
    }

    public function editAlumni(Alumni $alumni): View
    {
        return view('admin.bkk.tracer.alumni.edit', compact('alumni'));
    }

    public function updateAlumni(UpdateAlumniRequest $request, Alumni $alumni): RedirectResponse
    {
        $alumni->update($request->validated());

        return redirect()->route('admin.tracer.index', ['tab' => 'alumni'])
            ->with('success', 'Data alumni berhasil diperbarui.');
    }

    public function destroyAlumni(Alumni $alumni): RedirectResponse
    {
        $alumni->delete();

        return redirect()->route('admin.tracer.index', ['tab' => 'alumni'])
            ->with('success', 'Data alumni berhasil dihapus.');
    }

    public function toggleConfirmKuesioner(KuesionerTracer $kuesioner): RedirectResponse
    {
        $kuesioner->update([
            'is_konfirmasi' => ! $kuesioner->is_konfirmasi,
        ]);

        return back()->with('success', 'Status konfirmasi kuesioner berhasil diubah.');
    }

    public function updateSettings(UpdateTracerSettingsRequest $request): RedirectResponse
    {
        $setting = TracerSetting::first();
        if ($setting) {
            $setting->update($request->validated());
        } else {
            TracerSetting::create($request->validated());
        }

        return redirect()->route('admin.tracer.index', ['tab' => 'settings'])
            ->with('success', 'Pengaturan statistik tracer study berhasil diperbarui.');
    }
}
