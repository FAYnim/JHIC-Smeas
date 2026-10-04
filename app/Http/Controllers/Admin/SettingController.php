<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SettingController extends Controller
{
    public function edit(): View
    {
        $settings = Setting::all()->pluck('value', 'key')->toArray();

        return view('admin.settings.edit', compact('settings'));
    }

    private const ALLOWED_KEYS = [
        'site_name',
        'site_tagline',
        'school_address',
        'profil.visi',
        'profil.misi',
        'profil.prakata_nama',
        'profil.prakata_foto',
        'profil.prakata_quote',
        'school_phone',
        'school_email',
        'school_whatsapp',
        'spmb_service_hours',
        'social_instagram',
        'social_youtube',
        'social_facebook',
        'spmb_contact_email',
        'spmb_contact_phone',
    ];

    public function update(Request $request): RedirectResponse
    {
        $settings = $request->input('settings', []);

        foreach (is_array($settings) ? $settings : [] as $key => $value) {
            if (! in_array($key, self::ALLOWED_KEYS, true)) {
                continue;
            }
            $existing = Setting::where('key', $key)->first();
            $group = $existing?->group ?? (str_contains($key, '.') ? explode('.', $key)[0] : 'general');
            Setting::set($key, $value, $group);
        }

        return redirect()->route('admin.settings.edit')
            ->with('success', 'Pengaturan berhasil disimpan.');
    }
}
