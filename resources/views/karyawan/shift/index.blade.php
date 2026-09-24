@extends('layouts.karyawan')

@section('title', 'Jadwal Shift Kerja Saya')

@section('content')
    <div class="space-y-6">
        <!-- Header & Filter -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-white tracking-tight">Jadwal Shift Kerja Saya</h1>
                <p class="text-sm text-slate-400 mt-1">Daftar alokasi jam kerja harian yang ditugaskan kepada Anda.</p>
            </div>

            <!-- Filter Bulan -->
            <form method="GET" action="{{ route('karyawan.shifts.index') }}" class="flex items-center gap-2">
                <label for="bulan" class="text-xs font-semibold text-slate-400 uppercase">Bulan:</label>
                <input type="month" name="bulan" id="bulan" value="{{ $bulanSelected }}"
                    onchange="this.form.submit()"
                    class="px-3 py-1.5 rounded-lg bg-slate-800 border border-slate-700 text-white text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </form>
        </div>

        <!-- Highlight Shift Hari Ini -->
        <div
            class="bg-gradient-to-r from-blue-900/50 via-slate-800 to-slate-800 border border-blue-500/30 rounded-xl p-5 shadow-xl flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <div
                    class="w-12 h-12 rounded-xl bg-blue-600/20 text-blue-400 flex items-center justify-center border border-blue-500/30 shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <span class="text-xs font-bold uppercase tracking-wider text-blue-400 block">Jadwal Shift Hari
                        Ini</span>
                    <p class="text-sm font-semibold text-white mt-0.5">
                        {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
                    </p>
                </div>
            </div>

            <div>
                @if ($shiftHariIni)
                    <div class="flex items-center gap-3 bg-slate-900/80 px-4 py-2 rounded-lg border border-slate-700">
                        <span class="inline-block w-2.5 h-2.5 rounded-full bg-emerald-400 animate-pulse"></span>
                        <span class="text-base font-extrabold text-white">
                            {{ \Carbon\Carbon::parse($shiftHariIni->jam_mulai)->format('H:i') }} -
                            {{ \Carbon\Carbon::parse($shiftHariIni->jam_selesai)->format('H:i') }} WIB
                        </span>
                    </div>
                @else
                    <span
                        class="px-3 py-1.5 rounded-lg text-xs font-semibold bg-slate-700/50 text-slate-400 border border-slate-600/50">
                        Tidak ada jadwal shift kerja hari ini (Libur)
                    </span>
                @endif
            </div>
        </div>

        <!-- Tabel Daftar Shift -->
        <div class="bg-slate-800 border border-slate-700/60 rounded-xl shadow-xl overflow-hidden">
            <div class="p-5 border-b border-slate-700/60 flex items-center justify-between">
                <h2 class="text-base font-bold text-white">
                    Periode: {{ \Carbon\Carbon::parse($bulanSelected)->translatedFormat('F Y') }}
                </h2>
                <span class="text-xs text-slate-400">Total: {{ $shifts->total() }} Hari Kerja</span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-300">
                    <thead
                        class="bg-slate-900/60 text-slate-400 uppercase text-xs tracking-wider border-b border-slate-700/60">
                        <tr>
                            <th scope="col" class="px-6 py-4">No</th>
                            <th scope="col" class="px-6 py-4">Hari & Tanggal</th>
                            <th scope="col" class="px-6 py-4">Jam Kerja</th>
                            <th scope="col" class="px-6 py-4">Durasi</th>
                            <th scope="col" class="px-6 py-4">Status</th>
                            <th scope="col" class="px-6 py-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-700/60">
                        @forelse($shifts as $index => $item)
                            @php
                                $start = \Carbon\Carbon::parse($item->jam_mulai);
                                $end = \Carbon\Carbon::parse($item->jam_selesai);
                                $durasi = $start->diffInHours($end);
                                $isToday = \Carbon\Carbon::parse($item->tanggal)->isToday();
                                $isFuture = \Carbon\Carbon::parse($item->tanggal)->isFuture();
                            @endphp
                            <tr class="hover:bg-slate-700/30 transition-colors {{ $isToday ? 'bg-blue-900/10' : '' }}">
                                <td class="px-6 py-4 whitespace-nowrap font-medium text-slate-400">
                                    {{ $shifts->firstItem() + $index }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap font-bold text-white">
                                    {{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('l, d M Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="inline-flex items-center gap-1.5 px-3 py-1 rounded-md text-xs font-semibold bg-blue-500/10 text-blue-400 border border-blue-500/20">
                                        {{ $start->format('H:i') }} - {{ $end->format('H:i') }} WIB
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-slate-400 text-xs">
                                    {{ $durasi }} Jam
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if ($isToday)
                                        <span
                                            class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span> Hari
                                            Ini
                                        </span>
                                    @elseif($isFuture)
                                        <span
                                            class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-blue-500/10 text-blue-400 border border-blue-500/20">
                                            Akan Datang
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-slate-700 text-slate-400 border border-slate-600">
                                            Selesai
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <a href="{{ route('karyawan.shifts.show', $item->id) }}"
                                        class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg bg-slate-700/50 hover:bg-slate-700 text-slate-300 hover:text-white text-xs font-semibold transition-colors border border-slate-600/50">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-8 text-center text-slate-500">
                                    Tidak ada jadwal shift kerja untuk bulan
                                    {{ \Carbon\Carbon::parse($bulanSelected)->translatedFormat('F Y') }}.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if ($shifts->hasPages())
                <div class="px-6 py-4 border-t border-slate-700/60 bg-slate-900/30">
                    {{ $shifts->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
