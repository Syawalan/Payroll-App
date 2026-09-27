@extends('layouts.karyawan')

@section('title', 'Dashboard Karyawan')

@section('content')
    <div class="space-y-6">

        <!-- 1. HEADER / GREETING -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-white tracking-tight">Selamat Datang, {{ auth()->user()->name }}! 👋</h1>
                <p class="text-sm text-slate-400 mt-1">Berikut adalah ringkasan aktivitas kerja, jadwal shift, dan estimasi
                    pendapatan Anda.</p>
            </div>
            <div class="shrink-0">
                <span
                    class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl bg-slate-800 border border-slate-700/60 text-xs font-semibold text-slate-300 shadow-md">
                    <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
                </span>
            </div>
        </div>

        <!-- 2. KARTU STATISTIK UTAMA (RINGKASAN SAYA) -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

            <!-- Volume Borongan Bulan Ini -->
            <div class="bg-slate-800 border border-slate-700/60 rounded-xl p-5 shadow-lg flex items-center justify-between">
                <div class="space-y-1">
                    <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider block">Volume Borongan (Bulan
                        Ini)</span>
                    <span class="text-2xl font-extrabold text-blue-400 block">
                        {{ number_format($totalVolumeBulanIni, 0, ',', '.') }} <span
                            class="text-sm font-medium text-slate-400">Unit</span>
                    </span>
                    <span class="text-[11px] text-slate-500 block">Akumulasi pengiriman bulan berjalan</span>
                </div>
                <div
                    class="w-12 h-12 rounded-xl bg-blue-500/10 text-blue-400 flex items-center justify-center border border-blue-500/20 shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                </div>
            </div>

            <!-- Gaji Pending -->
            <div class="bg-slate-800 border border-slate-700/60 rounded-xl p-5 shadow-lg flex items-center justify-between">
                <div class="space-y-1">
                    <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider block">Gaji Belum
                        Dicairkan</span>
                    <span class="text-2xl font-extrabold text-amber-400 block">
                        Rp {{ number_format($gajiPending, 0, ',', '.') }}
                    </span>
                    <span class="text-[11px] text-slate-500 block">Menunggu proses verifikasi/transfer</span>
                </div>
                <div
                    class="w-12 h-12 rounded-xl bg-amber-500/10 text-amber-400 flex items-center justify-center border border-amber-500/20 shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>

            <!-- Gaji Terakhir Dibayar -->
            <div class="bg-slate-800 border border-slate-700/60 rounded-xl p-5 shadow-lg flex items-center justify-between">
                <div class="space-y-1">
                    <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider block">Gaji Terakhir
                        Diterima</span>
                    @if ($gajiTerakhirDibayar)
                        <span class="text-2xl font-extrabold text-emerald-400 block">
                            Rp {{ number_format($gajiTerakhirDibayar->total_gaji, 0, ',', '.') }}
                        </span>
                        <span class="text-[11px] text-slate-400 block">Periode: {{ $gajiTerakhirDibayar->periode }}</span>
                    @else
                        <span class="text-xl font-bold text-slate-500 block">Belum Ada</span>
                        <span class="text-[11px] text-slate-500 block">Belum ada riwayat pembayaran</span>
                    @endif
                </div>
                <div
                    class="w-12 h-12 rounded-xl bg-emerald-500/10 text-emerald-400 flex items-center justify-center border border-emerald-500/20 shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>

        </div>

        <!-- 3. SECTION MID: JADWAL SHIFT & TUGAS BORONGAN MENDATANG -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            <!-- JADWAL SHIFT -->
            <div
                class="bg-slate-800 border border-slate-700/60 rounded-xl p-5 shadow-xl flex flex-col justify-between space-y-4">
                <div>
                    <div class="flex items-center justify-between pb-3 border-b border-slate-700/60">
                        <h2 class="text-base font-bold text-white flex items-center gap-2">
                            <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Jadwal Shift Kerja
                        </h2>
                        <a href="{{ route('karyawan.shifts.index') }}"
                            class="text-xs font-semibold text-blue-400 hover:text-blue-300">Lihat Semua &rarr;</a>
                    </div>

                    <!-- Shift Hari Ini Banner -->
                    <div
                        class="mt-4 p-4 rounded-xl bg-gradient-to-r from-blue-900/40 via-slate-900/60 to-slate-900/40 border border-blue-500/30 space-y-2">
                        <div class="flex items-center justify-between">
                            <span
                                class="text-[11px] font-bold text-blue-400 uppercase tracking-wider flex items-center gap-1.5">
                                <span class="w-2 h-2 rounded-full bg-blue-400 animate-pulse"></span> Shift Hari Ini
                            </span>
                            <span
                                class="text-xs text-slate-400">{{ \Carbon\Carbon::today()->translatedFormat('d M Y') }}</span>
                        </div>

                        @if ($shiftHariIni)
                            <div class="flex items-center justify-between pt-1">
                                <div>
                                    <p class="text-xl font-bold text-white">
                                        {{ \Carbon\Carbon::parse($shiftHariIni->jam_mulai)->format('H:i') }} -
                                        {{ \Carbon\Carbon::parse($shiftHariIni->jam_selesai)->format('H:i') }} WIB
                                    </p>
                                    <p class="text-xs text-slate-400 mt-0.5">
                                        Durasi:
                                        {{ \Carbon\Carbon::parse($shiftHariIni->jam_mulai)->diffInHours(\Carbon\Carbon::parse($shiftHariIni->jam_selesai)) }}
                                        Jam Kerja
                                    </p>
                                </div>
                                <a href="{{ route('karyawan.shifts.show', $shiftHariIni->id) }}"
                                    class="px-3 py-1.5 rounded-lg bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold transition-all">Detail</a>
                            </div>
                        @else
                            <p class="text-sm font-semibold text-slate-400 py-1">Tidak Ada Shift Hari Ini (Libur / Off)</p>
                        @endif
                    </div>

                    <!-- List Shift Mendatang -->
                    <div class="mt-4 space-y-2">
                        <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider block mb-2">Shift
                            Mendatang:</span>
                        <div class="space-y-2 max-h-48 overflow-y-auto pr-1">
                            @forelse($shiftMendatang as $shift)
                                @if (!\Carbon\Carbon::parse($shift->tanggal)->isToday())
                                    <div
                                        class="flex items-center justify-between p-2.5 rounded-lg bg-slate-900/60 border border-slate-700/40 text-xs">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="w-8 h-8 rounded bg-slate-800 border border-slate-700 flex flex-col items-center justify-center text-[10px] font-bold text-slate-300">
                                                <span>{{ \Carbon\Carbon::parse($shift->tanggal)->format('d') }}</span>
                                                <span
                                                    class="text-[8px] text-blue-400 uppercase">{{ \Carbon\Carbon::parse($shift->tanggal)->format('M') }}</span>
                                            </div>
                                            <div>
                                                <p class="font-bold text-white">
                                                    {{ \Carbon\Carbon::parse($shift->tanggal)->translatedFormat('l') }}</p>
                                                <p class="text-slate-400 text-[11px]">
                                                    {{ \Carbon\Carbon::parse($shift->jam_mulai)->format('H:i') }} -
                                                    {{ \Carbon\Carbon::parse($shift->jam_selesai)->format('H:i') }} WIB</p>
                                            </div>
                                        </div>
                                        <a href="{{ route('karyawan.shifts.show', $shift->id) }}"
                                            class="text-slate-400 hover:text-white">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 5l7 7-7 7" />
                                            </svg>
                                        </a>
                                    </div>
                                @endif
                            @empty
                                <p class="text-xs text-slate-500 italic text-center py-3">Tidak ada jadwal shift mendatang.
                                </p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <!-- TUGAS BORONGAN MENDATANG -->
            <div
                class="bg-slate-800 border border-slate-700/60 rounded-xl p-5 shadow-xl flex flex-col justify-between space-y-4">
                <div>
                    <div class="flex items-center justify-between pb-3 border-b border-slate-700/60">
                        <h2 class="text-base font-bold text-white flex items-center gap-2">
                            <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 4H6a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-2m-4-1v8m0 0l3-3m-3 3L9 8m-5 5h2.586a1 1 0 01.707.293l2.414 2.414a1 1 0 00.707.293h3.172a1 1 0 00.707-.293l2.414-2.414a1 1 0 01.707-.293H20" />
                            </svg>
                            Tugas Borongan Akan Dikerjakan
                        </h2>
                        <a href="{{ route('karyawan.borongan.index') }}"
                            class="text-xs font-semibold text-emerald-400 hover:text-emerald-300">Lihat Semua &rarr;</a>
                    </div>

                    <div class="mt-4 space-y-2.5">
                        @forelse($boronganAkanDikerjakan as $item)
                            <div
                                class="p-3 rounded-lg bg-slate-900/60 border border-slate-700/50 hover:border-slate-600 transition-colors space-y-2">
                                <div class="flex items-start justify-between gap-2">
                                    <div>
                                        <h3 class="text-sm font-bold text-white">{{ $item->nama_barang }}</h3>
                                        <p class="text-xs text-slate-400 mt-0.5 truncate max-w-xs">📍
                                            {{ $item->alamat_tujuan }}</p>
                                    </div>
                                    <span
                                        class="px-2.5 py-1 rounded-md text-xs font-bold bg-blue-500/10 text-blue-400 border border-blue-500/20 shrink-0">
                                        {{ $item->volume }} {{ $item->satuan }}
                                    </span>
                                </div>

                                <div
                                    class="flex items-center justify-between text-[11px] text-slate-400 pt-2 border-t border-slate-800">
                                    <span>📅 Tgl Pengiriman: <strong
                                            class="text-slate-300">{{ \Carbon\Carbon::parse($item->tanggal_pengiriman)->translatedFormat('d M Y') }}</strong></span>
                                    <a href="{{ route('karyawan.borongan.show', $item->id) }}"
                                        class="text-emerald-400 hover:text-emerald-300 font-semibold">Detail Task
                                        &rarr;</a>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-8 text-slate-500 space-y-1">
                                <svg class="w-8 h-8 mx-auto text-slate-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                                <p class="text-xs">Belum ada tugas borongan mendatang yang ditugaskan.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

        </div>

        <!-- 4. SECTION BOTTOM: RIWAYAT SLIP GAJI TERBARU -->
        <div class="bg-slate-800 border border-slate-700/60 rounded-xl shadow-xl overflow-hidden">
            <div class="p-5 border-b border-slate-700/60 flex items-center justify-between">
                <div>
                    <h2 class="text-base font-bold text-white">Riwayat Slip Gaji Terbaru</h2>
                    <p class="text-xs text-slate-400 mt-0.5">3 dokumen pengeluaran gaji terakhir Anda.</p>
                </div>
                <a href="{{ route('karyawan.penggajian.index') }}"
                    class="text-xs font-semibold text-blue-400 hover:text-blue-300">Lihat Semua Slip &rarr;</a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-300">
                    <thead
                        class="bg-slate-900/60 text-slate-400 uppercase text-xs tracking-wider border-b border-slate-700/60">
                        <tr>
                            <th scope="col" class="px-6 py-3.5">Periode</th>
                            <th scope="col" class="px-6 py-3.5">Total Volume</th>
                            <th scope="col" class="px-6 py-3.5">Tarif/Unit</th>
                            <th scope="col" class="px-6 py-3.5">Total Gaji</th>
                            <th scope="col" class="px-6 py-3.5">Status</th>
                            <th scope="col" class="px-6 py-3.5 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-700/60">
                        @forelse($riwayatGaji as $gaji)
                            <tr class="hover:bg-slate-700/30 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap font-bold text-white">
                                    {{ $gaji->periode }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-slate-300">
                                    {{ number_format($gaji->total_volume, 0, ',', '.') }} Unit
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-slate-300">
                                    Rp {{ number_format($gaji->tarif, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap font-bold text-emerald-400">
                                    Rp {{ number_format($gaji->total_gaji, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if ($gaji->status === 'dibayar')
                                        <span
                                            class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span> Dibayar
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-500/10 text-amber-400 border border-amber-500/20">
                                            <span class="w-1.5 h-1.5 rounded-full bg-amber-400"></span> Belum Dibayar
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <a href="{{ route('karyawan.penggajian.show', $gaji->id) }}"
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-slate-700/50 hover:bg-slate-700 text-slate-300 hover:text-white text-xs font-semibold transition-colors border border-slate-600/50">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        Slip Gaji
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-8 text-center text-slate-500">
                                    Belum ada riwayat slip gaji.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection
