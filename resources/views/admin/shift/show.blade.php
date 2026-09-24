@extends('layouts.admin')

@section('title', 'Detail Shift Kerja')

@section('content')
    <div class="max-w-2xl mx-auto space-y-6">
        <!-- Header & Back Button -->
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.shifts.index') }}"
                    class="p-2 rounded-lg bg-slate-800 hover:bg-slate-700 text-slate-400 hover:text-white transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </a>
                <div>
                    <h1 class="text-2xl font-bold text-white tracking-tight">Detail Shift Kerja</h1>
                    <p class="text-sm text-slate-400">Rincian jadwal kerja harian karyawan.</p>
                </div>
            </div>

            <a href="{{ route('admin.shifts.edit', $shift->id) }}"
                class="px-4 py-2 rounded-lg bg-amber-500/10 text-amber-400 border border-amber-500/20 hover:bg-amber-500/20 text-sm font-medium transition-colors">
                Edit Shift
            </a>
        </div>

        <!-- Main Detail Card -->
        <div class="bg-slate-800 border border-slate-700/60 rounded-xl p-6 shadow-xl space-y-6">

            <div class="pb-6 border-b border-slate-700/60">
                <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider block mb-1">Nama Karyawan</span>
                <p class="text-xl font-bold text-blue-400">
                    {{ $shift->user->name ?? 'Karyawan Dihapus' }}
                </p>
                <p class="text-sm text-slate-400 mt-0.5">{{ $shift->user->email ?? '-' }}</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 pb-6 border-b border-slate-700/60">
                <div>
                    <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider block mb-1">Tanggal
                        Kerja</span>
                    <p class="text-lg font-bold text-white">
                        {{ \Carbon\Carbon::parse($shift->tanggal)->translatedFormat('l, d F Y') }}
                    </p>
                </div>
                <div>
                    <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider block mb-1">Durasi / Jam
                        Kerja</span>
                    <span
                        class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg text-sm font-bold bg-blue-500/10 text-blue-400 border border-blue-500/20">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        {{ \Carbon\Carbon::parse($shift->jam_mulai)->format('H:i') }} -
                        {{ \Carbon\Carbon::parse($shift->jam_selesai)->format('H:i') }} WIB
                    </span>
                </div>
            </div>

            <div class="pt-2 text-xs text-slate-500 flex justify-between items-center">
                <span>Dibuat pada: {{ $shift->created_at ? $shift->created_at->format('d M Y H:i') : '-' }}</span>
                <span>ID Shift: #{{ $shift->id }}</span>
            </div>

        </div>
    </div>
@endsection
