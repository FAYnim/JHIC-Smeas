<?php

namespace App\Http\Controllers\Admin\Bkk;

use App\Http\Controllers\Controller;
use App\Models\MagangApplication;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LamaranController extends Controller
{
    public function index(Request $request): View
    {
        $query = MagangApplication::with('lowongan')->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        if ($request->filled('q')) {
            $q = like_escape($request->string('q')->toString());
            $query->where(function ($builder) use ($q) {
                $builder->where('nisn', 'like', "%{$q}%")
                    ->orWhere('registration_code', 'like', "%{$q}%");
            });
        }

        $lamarans = $query->paginate(10)->withQueryString();

        $stats = [
            'total' => MagangApplication::count(),
            'pending' => MagangApplication::where('status', 'pending')->count(),
            'accepted' => MagangApplication::where('status', 'accepted')->count(),
            'rejected' => MagangApplication::where('status', 'rejected')->count(),
        ];

        return view('admin.bkk.lamaran.index', compact('lamarans', 'stats'));
    }

    public function updateStatus(Request $request, MagangApplication $application): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'in:pending,accepted,rejected'],
        ]);

        $application->update(['status' => $validated['status']]);

        return redirect()->route('admin.lamaran.index')
            ->with('success', 'Status lamaran berhasil diperbarui.');
    }
}
