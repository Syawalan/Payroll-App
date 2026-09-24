@extends('layouts.admin')

@section('title', 'Kelola Shift Kerja')

@section('content')
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-white tracking-tight">Kelola Shift Kerja</h1>
                <p class="text-sm text-slate-400 mt-1">Daftar alokasi jam kerja harian karyawan.</p>
            </div>
            <a href="{{ route('admin.shifts.create') }}"
                class="inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg shadow-lg shadow-blue-600/30 transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah / Generate Shift
            </a>
        </div>

        <!-- Alert Success -->
        @if (session('success'))
            <div class="p-4 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-sm">
                {{ session('success') }}
            </div>
        @endif

        <!-- Filter Card -->
        <div class="bg-slate-800 border border-slate-700/60 rounded-xl p-4 shadow-xl">
            <form method="GET" action="{{ route('admin.shifts.index') }}" class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <select name="user_id" onchange="this.form.submit()"
                        class="w-full px-3 py-2 rounded-lg bg-slate-900 border border-slate-700 text-white text-sm">
                        <option value="">-- Semuua Karyawan --</option>
                        @foreach ($karyawans as $k)
                            <option value="{{ $k->id }}" {{ request('user_id') == $k->id ? 'selected' : '' }}>
                                {{ $k->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <input type="month" name="bulan" value="{{ request('bulan', date('Y-m')) }}"
                        onchange="this.form.submit()"
                        class="w-full px-3 py-2 rounded-lg bg-slate-900 border border-slate-700 text-white text-sm">
                </div>
                <div>
                    <a href="{{ route('admin.shifts.index') }}"
                        class="block text-center py-2 px-4 bg-slate-700 hover:bg-slate-600 text-slate-300 rounded-lg text-sm">Reset
                        Filter</a>
                </div>
            </form>
        </div>

        <!-- Tabel Shift -->
        <div class="bg-slate-800 border border-slate-700/60 rounded-xl shadow-xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-300">
                    <thead
                        class="bg-slate-900/60 text-slate-400 uppercase text-xs tracking-wider border-b border-slate-700/60">
                        <tr>
                            <th scope="col" class="px-6 py-4">No</th>
                            <th scope="col" class="px-6 py-4">Nama Karyawan</th>
                            <th scope="col" class="px-6 py-4">Hari & Tanggal</th>
                            <th scope="col" class="px-6 py-4">Jam Kerja</th>
                            <th scope="col" class="px-6 py-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-700/60">
                        @forelse($shifts as $index => $item)
                            <tr class="hover:bg-slate-700/30 transition-colors">
                                <td class="px-6 py-4 text-slate-400 font-medium">
                                    {{ $shifts->firstItem() + $index }}
                                </td>
                                <td class="px-6 py-4 font-bold text-white">
                                    {{ $item->user->name ?? '-' }}
                                </td>
                                <td class="px-6 py-4 text-slate-300">
                                    {{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('l, d M Y') }}
                                </td>
                                <td class="px-6 py-4">
                                    <span
                                        class="px-2.5 py-1 rounded-md text-xs font-semibold bg-blue-500/10 text-blue-400 border border-blue-500/20">
                                        {{ \Carbon\Carbon::parse($item->jam_mulai)->format('H:i') }} -
                                        {{ \Carbon\Carbon::parse($item->jam_selesai)->format('H:i') }} WIB
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <form action="{{ route('admin.shifts.destroy', $item->id) }}" method="POST"
                                        onsubmit="return confirm('Hapus jadwal shift ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="text-rose-400 hover:text-rose-300 text-xs font-semibold">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-slate-500">
                                    Belum ada data shift kerja.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($shifts->hasPages())
                <div class="px-6 py-4 border-t border-slate-700/60 bg-slate-900/30">
                    {{ $shifts->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
