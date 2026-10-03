@extends('admin.layout')

@section('title', 'Manajemen Pengguna')
@section('page-title', 'Pengguna Sistem')

@section('content')
    <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
        <form method="GET" action="{{ route('admin.users.index') }}" class="flex flex-wrap items-center gap-2">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau email..."
                class="rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm focus:border-blue-500 focus:outline-none">

            <select name="role" class="rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm focus:border-blue-500 focus:outline-none">
                <option value="">Semua Peran</option>
                @foreach ($roles as $key => $label)
                    <option value="{{ $key }}" {{ request('role') === $key ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>

            <button type="submit" class="rounded-lg bg-slate-800 px-4 py-2 text-sm font-bold text-white hover:bg-slate-900">
                Filter
            </button>
            @if (request()->hasAny(['search', 'role']))
                <a href="{{ route('admin.users.index') }}" class="text-xs font-bold text-slate-500 hover:text-slate-700">Reset</a>
            @endif
        </form>

        <a href="{{ route('admin.users.create') }}"
            class="inline-flex items-center gap-1.5 rounded-lg bg-blue-600 px-4 py-2 text-sm font-bold text-white hover:bg-blue-700">
            <x-lucide-plus class="w-4 h-4" />
            Tambah Pengguna
        </a>
    </div>

    @if (session('success'))
        <div class="mb-6 rounded-lg bg-emerald-50 border border-emerald-200 p-4 text-sm font-semibold text-emerald-800">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto rounded-xl border border-slate-200 bg-white">
        <table class="w-full text-left text-sm">
            <thead class="border-b border-slate-200 bg-slate-50 text-xs font-bold uppercase text-slate-500">
                <tr>
                    <th class="px-4 py-3">Nama & Email</th>
                    <th class="px-4 py-3">Peran Akses</th>
                    <th class="px-4 py-3">Terdaftar Sejak</th>
                    <th class="px-4 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($users as $user)
                    @php
                        $roleBadges = [
                            \App\Models\User::ROLE_ADMIN => 'bg-red-50 text-red-700 border-red-200',
                            \App\Models\User::ROLE_BKK => 'bg-blue-50 text-blue-700 border-blue-200',
                            \App\Models\User::ROLE_HUMAS => 'bg-purple-50 text-purple-700 border-purple-200',
                            \App\Models\User::ROLE_SPMB => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                            \App\Models\User::ROLE_BLUD => 'bg-amber-50 text-amber-700 border-amber-200',
                        ];
                        $badgeClass = $roleBadges[$user->role] ?? 'bg-slate-100 text-slate-600 border-slate-200';
                        $isCurrent = $user->id === auth()->id();
                    @endphp
                    <tr class="hover:bg-slate-50">
                        <td class="px-4 py-3 max-w-[16rem]">
                            <div class="flex items-center gap-2">
                                <p class="font-bold text-slate-900 truncate" title="{{ $user->name }}">{{ $user->name }}</p>
                                @if ($isCurrent)
                                    <span class="rounded bg-slate-200 px-1.5 py-0.5 text-[10px] font-bold text-slate-700 shrink-0">Anda</span>
                                @endif
                            </div>
                            <p class="text-xs text-slate-500 truncate" title="{{ $user->email }}">{{ $user->email }}</p>
                        </td>
                        <td class="px-4 py-3">
                            <span class="inline-flex rounded-full border px-2.5 py-0.5 text-xs font-bold {{ $badgeClass }}">
                                {{ $user->roleLabel() }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-xs text-slate-500">
                            {{ $user->created_at?->format('d M Y') ?? '—' }}
                        </td>
                        <td class="px-4 py-3 text-right">
                            <div class="inline-flex items-center gap-2">
                                <a href="{{ route('admin.users.edit', $user) }}"
                                    class="rounded-lg p-1.5 text-slate-400 hover:bg-slate-100 hover:text-blue-600">
                                    <x-lucide-pencil class="w-4 h-4" />
                                </a>

                                @if (! $isCurrent)
                                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                                        onsubmit="return confirm('Hapus pengguna ini dari sistem?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="rounded-lg p-1.5 text-slate-400 hover:bg-slate-100 hover:text-red-600">
                                            <x-lucide-trash-2 class="w-4 h-4" />
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-4 py-8 text-center text-slate-400">
                            Belum ada pengguna ditemukan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $users->links() }}
    </div>
@endsection
