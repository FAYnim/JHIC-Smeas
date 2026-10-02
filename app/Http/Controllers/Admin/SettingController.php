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

    public function update(Request $request): RedirectResponse
    {
        $settings = $request->input('settings', []);

        foreach ($settings as $key => $value) {
            $existing = Setting::where('key', $key)->first();
            $group = $existing?->group ?? (str_contains($key, '.') ? explode('.', $key)[0] : 'general');
            Setting::set($key, $value, $group);
        }

        return redirect()->route('admin.settings.edit')
            ->with('success', 'Pengaturan berhasil disimpan.');
    }
}
