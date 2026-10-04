<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreUserRequest;
use App\Http\Requests\Admin\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(Request $request): View
    {
        $query = User::query()->latest();

        if ($request->filled('role')) {
            $query->where('role', $request->query('role'));
        }

        if ($request->filled('search')) {
            $search = $request->query('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $users = $query->paginate(15)->withQueryString();

        $roles = [
            User::ROLE_ADMIN => 'Super Admin',
            User::ROLE_BKK => 'BKK (Pusat Karir)',
            User::ROLE_HUMAS => 'Humas (Profil Sekolah)',
            User::ROLE_SPMB => 'Panitia SPMB',
            User::ROLE_BLUD => 'Staf BLUD',
        ];

        return view('admin.users.index', compact('users', 'roles'));
    }

    public function create(): View
    {
        $roles = [
            User::ROLE_ADMIN => 'Super Admin',
            User::ROLE_BKK => 'BKK (Pusat Karir)',
            User::ROLE_HUMAS => 'Humas (Profil Sekolah)',
            User::ROLE_SPMB => 'Panitia SPMB',
            User::ROLE_BLUD => 'Staf BLUD',
        ];

        return view('admin.users.create', compact('roles'));
    }

    public function store(StoreUserRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['password'] = Hash::make($data['password']);

        User::create($data);

        return redirect()->route('admin.users.index')
            ->with('success', 'Pengguna staf baru berhasil ditambahkan.');
    }

    public function edit(User $user): View
    {
        $roles = [
            User::ROLE_ADMIN => 'Super Admin',
            User::ROLE_BKK => 'BKK (Pusat Karir)',
            User::ROLE_HUMAS => 'Humas (Profil Sekolah)',
            User::ROLE_SPMB => 'Panitia SPMB',
            User::ROLE_BLUD => 'Staf BLUD',
        ];

        return view('admin.users.edit', compact('user', 'roles'));
    }

    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {
        $data = $request->validated();

        if (! empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $user->update($data);

        return redirect()->route('admin.users.index')
            ->with('success', 'Data pengguna berhasil diperbarui.');
    }

    public function destroy(User $user): RedirectResponse
    {
        if ($user->id === auth()->id()) {
            abort(403, 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'Pengguna berhasil dihapus.');
    }
}
