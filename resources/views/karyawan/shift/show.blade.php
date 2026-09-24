@extends('layouts.karyawan')

@section('title', 'Detail Shift Kerja')

@section('content')
    <div class="max-w-2xl mx-auto space-y-6">
        <!-- Header & Back Button -->
        <div class="flex items-center gap-4">
            <a href="{{ route('karyawan.shifts.index') }}"
                class="p-2 rounded-lg bg-slate-800 hover:bg-slate-700 text-slate-400 hover:text-white transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-white tracking-tight">Rincian Shift Kerja</h1>
                <p class="text-sm text-slate-400">Informasi detail alokasi jam kerja Anda.</p>
            </div>
        </div>

        <!-- Card Detail -->
        <div class="bg-slate-800 border border-slate-700/60 rounded-xl p-6 shadow-xl space-y-6">
            @php
                $start = \Carbon\Carbon::parse($shift->jam_mulai);
                $end = \Carbon\Carbon::parse($shift->jam_selesai);
                $durasi = $start->diffInHours($end);
                $isToday = \Carbon\Carbon::parse($shift->tanggal)->isToday();
                $isFuture = \Carbon\Carbon::parse($shift->tanggal)->isFuture();
            @endphp

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 pb-6 border-b border-slate-700/60">
                <div>
                    <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider block mb-1">Hari &
                        Tanggal</span>
                    <p class="text-xl font-bold text-white">
                        {{ \Carbon\Carbon::parse($shift->tanggal)->translatedFormat('l, d F Y') }}
                    </p>
                </div>
                <div>
                    <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider block mb-1">Status
                        Shift</span>
                    @if ($isToday)
                        <span
                            class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span> Shift Hari Ini
                        </span>
                    @elseif($isFuture)
                        <span
                            class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-blue-500/10 text-blue-400 border border-blue-500/20">
                            Shift Akan Datang
                        </span>
                    @else
                        <span
                            class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-slate-700 text-slate-400 border border-slate-600">
                            Shift Telah Selesai
                        </span>
                    @endif
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 pb-6 border-b border-slate-700/60">
                <div>
                    <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider block mb-1">Jam Kerja</span>
                    <span
                        class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg text-sm font-bold bg-blue-500/10 text-blue-400 border border-blue-500/20">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        {{ $start->format('H:i') }} - {{ $end->format('H:i') }} WIB
                    </span>
                </div>
                <div>
                    <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider block mb-1">Total
                        Durasi</span>
                    <p class="text-lg font-bold text-white">
                        {{ $durasi }} Jam Kerja
                    </p>
                </div>
            </div>

            <div class="pt-2 text-xs text-slate-500 flex justify-between items-center">
                <span>ID Shift: #{{ $shift->id }}</span>
                <span>Dijadwalkan oleh Admin</span>
            </div>

        </div>
    </div>
@endsection
