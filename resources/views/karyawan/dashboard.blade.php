@extends('layouts.karyawan')

@section('title', 'Dashboard Karyawan')

@section('content')
    <div class="space-y-6">

        <!-- Header Selamat Datang -->
        <div
            class="bg-gradient-to-r from-blue-900/40 via-slate-800 to-slate-800 border border-slate-700/60 rounded-xl p-6 shadow-xl flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-white tracking-tight">
                    Selamat Datang, {{ auth()->user()->name }}! 👋
                </h1>
                <p class="text-sm text-slate-300 mt-1">
                    Pantau tugas borongan, jadwal shift kerja, dan riwayat gaji Anda di portal ini.
                </p>
            </div>
            <div class="text-xs text-slate-400 bg-slate-900/60 px-4 py-2.5 rounded-lg border border-slate-700/50 w-fit">
                <span>Hari ini: </span>
                <strong class="text-blue-400">{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</strong>
            </div>
        </div>

        <!-- KPI Summary Cards (4 Ringkasan Utam) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">

            <!-- Card 1: Volume Borongan Bulan Ini -->
            <div class="bg-slate-800 border border-slate-700/60 rounded-xl p-5 shadow-lg flex items-center justify-between">
                <div>
                    <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider block">Volume Bulan Ini</span>
                    <span class="text-2xl font-extrabold text-white mt-1 block">
                        {{ number_format($totalVolumeBulanIni, 0, ',', '.') }}
                    </span>
                    <span class="text-xs text-slate-500 mt-0.5 block">Total akumulasi unit</span>
                </div>
                <div
                    class="w-12 h-12 rounded-xl bg-blue-600/20 text-blue-400 flex items-center justify-center border border-blue-500/30 shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                </div>
            </div>

            <!-- Card 2: Shift Hari Ini -->
            <div class="bg-slate-800 border border-slate-700/60 rounded-xl p-5 shadow-lg flex items-center justify-between">
                <div>
                    <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider block">Shift Hari Ini</span>
                    @if ($shiftHariIni)
                        <span class="text-lg font-bold text-blue-400 mt-1 block">
                            {{ \Carbon\Carbon::parse($shiftHariIni->jam_mulai)->format('H:i') }} -
                            {{ \Carbon\Carbon::parse($shiftHariIni->jam_selesai)->format('H:i') }} WIB
                        </span>
                        <span class="text-xs text-emerald-400 font-medium">Jadwal Masuk</span>
                    @else
                        <span class="text-lg font-bold text-slate-400 mt-1 block">Libur / Tidak Ada</span>
                        <span class="text-xs text-slate-500">Tidak ada jadwal shift</span>
                    @endif
                </div>
                <div
                    class="w-12 h-12 rounded-xl bg-amber-500/20 text-amber-400 flex items-center justify-center border border-amber-500/30 shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>

            <!-- Card 3: Gaji Pending -->
            <div class="bg-slate-800 border border-slate-700/60 rounded-xl p-5 shadow-lg flex items-center justify-between">
                <div>
                    <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider block">Gaji Belum Cair</span>
                    <span class="text-xl font-extrabold text-amber-400 mt-1 block">
                        Rp {{ number_format($gajiPending, 0, ',', '.') }}
                    </span>
                    <span class="text-xs text-slate-500 mt-0.5 block">Status: Menunggu bayar</span>
                </div>
                <div
                    class="w-12 h-12 rounded-xl bg-amber-500/20 text-amber-400 flex items-center justify-center border border-amber-500/30 shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>

            <!-- Card 4: Gaji Terakhir Dibayar -->
            <div class="bg-slate-800 border border-slate-700/60 rounded-xl p-5 shadow-lg flex items-center justify-between">
                <div>
                    <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider block">Gaji Terakhir
                        Dibayar</span>
                    <span class="text-xl font-extrabold text-emerald-400 mt-1 block">
                        Rp {{ number_format($gajiTerakhirDibayar->total_gaji ?? 0, 0, ',', '.') }}
                    </span>
                    <span class="text-xs text-slate-500 mt-0.5 block">
                        {{ $gajiTerakhirDibayar->periode ?? 'Belum ada' }}
                    </span>
                </div>
                <div
                    class="w-12 h-12 rounded-xl bg-emerald-500/20 text-emerald-400 flex items-center justify-center border border-emerald-500/30 shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>

        </div>

        <!-- Main Content Area (2 Kolom Layout) -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <!-- Kolom Kiri: Penugasan Borongan & Shift Mendatang (2/3 width) -->
            <div class="lg:col-span-2 space-y-6">

                <!-- Tabel Tugas Borongan Akan Dikerjakan -->
                <div class="bg-slate-800 border border-slate-700/60 rounded-xl shadow-xl overflow-hidden">
                    <div class="p-5 border-b border-slate-700/60 flex items-center justify-between">
                        <div>
                            <h2 class="text-base font-bold text-white">Borongan Akan Dikerjakan / Mendatang</h2>
                            <p class="text-xs text-slate-400">Daftar penugasan pengiriman barang borongan Anda.</p>
                        </div>
                        <a href="{{ route('karyawan.borongan.index') }}"
                            class="text-xs font-semibold text-blue-400 hover:text-blue-300">
                            Lihat Semua &rarr;
                        </a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm text-slate-300">
                            <thead
                                class="bg-slate-900/60 text-slate-400 uppercase text-xs tracking-wider border-b border-slate-700/60">
                                <tr>
                                    <th scope="col" class="px-5 py-3.5">Tanggal</th>
                                    <th scope="col" class="px-5 py-3.5">Nama Barang</th>
                                    <th scope="col" class="px-5 py-3.5">Volume</th>
                                    <th scope="col" class="px-5 py-3.5">Alamat Tujuan</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-700/60">
                                @forelse($boronganAkanDikerjakan as $b)
                                    <tr class="hover:bg-slate-700/30 transition-colors">
                                        <td class="px-5 py-3.5 whitespace-nowrap font-medium text-white">
                                            {{ \Carbon\Carbon::parse($b->tanggal_pengiriman)->format('d M Y') }}
                                        </td>
                                        <td class="px-5 py-3.5 whitespace-nowrap font-semibold text-blue-400">
                                            {{ $b->nama_barang }}
                                        </td>
                                        <td class="px-5 py-3.5 whitespace-nowrap">
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded text-xs font-medium bg-blue-500/10 text-blue-400 border border-blue-500/20">
                                                {{ $b->volume }} {{ $b->satuan }}
                                            </span>
                                        </td>
                                        <td class="px-5 py-3.5 text-xs text-slate-400 max-w-xs truncate"
                                            title="{{ $b->alamat_tujuan }}">
                                            {{ $b->alamat_tujuan }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-5 py-6 text-center text-slate-500 text-sm">
                                            Tidak ada penugasan borongan mendatang saat ini.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- List Shift Kerja Mendatang -->
                <div class="bg-slate-800 border border-slate-700/60 rounded-xl p-5 shadow-xl space-y-4">
                    <div class="flex items-center justify-between border-b border-slate-700/60 pb-3">
                        <div>
                            <h2 class="text-base font-bold text-white">Jadwal Shift Kerja Mendatang</h2>
                            <p class="text-xs text-slate-400">Jadwal masuk kerja Anda untuk 5 hari ke depan.</p>
                        </div>
                        <a href="{{ route('karyawan.shifts.index') }}"
                            class="text-xs font-semibold text-blue-400 hover:text-blue-300">
                            Lihat Semua &rarr;
                        </a>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        @forelse($shiftMendatang as $s)
                            <div
                                class="p-3.5 rounded-lg bg-slate-900/60 border border-slate-700/50 flex items-center justify-between">
                                <div>
                                    <span class="text-xs font-semibold text-slate-400 block">
                                        {{ \Carbon\Carbon::parse($s->tanggal)->translatedFormat('l, d M Y') }}
                                    </span>
                                    <span class="text-sm font-bold text-white mt-0.5 block">
                                        {{ \Carbon\Carbon::parse($s->jam_mulai)->format('H:i') }} -
                                        {{ \Carbon\Carbon::parse($s->jam_selesai)->format('H:i') }} WIB
                                    </span>
                                </div>
                                <span
                                    class="px-2 py-1 rounded text-xs font-medium bg-blue-500/10 text-blue-400 border border-blue-500/20">
                                    Shift
                                </span>
                            </div>
                        @empty
                            <div class="sm:col-span-2 text-center py-4 text-slate-500 text-sm">
                                Belum ada jadwal shift untuk beberapa hari ke depan.
                            </div>
                        @endforelse
                    </div>
                </div>

            </div>

            <!-- Kolom Kanan: Riwayat Gaji Terbaru (1/3 width) -->
            <div class="space-y-6">

                <div class="bg-slate-800 border border-slate-700/60 rounded-xl p-5 shadow-xl space-y-4">
                    <div class="flex items-center justify-between border-b border-slate-700/60 pb-3">
                        <div>
                            <h2 class="text-base font-bold text-white">Slip Gaji Terbaru</h2>
                            <p class="text-xs text-slate-400">3 pencairan gaji terakhir Anda.</p>
                        </div>
                        <a href="{{ route('karyawan.penggajian.index') }}"
                            class="text-xs font-semibold text-blue-400 hover:text-blue-300">
                            Lihat Semua &rarr;
                        </a>
                    </div>

                    <div class="space-y-3">
                        @forelse($riwayatGaji as $gaji)
                            <div class="p-4 rounded-xl bg-slate-900/60 border border-slate-700/50 space-y-2">
                                <div class="flex items-center justify-between">
                                    <span
                                        class="text-xs font-bold text-white bg-slate-800 px-2.5 py-1 rounded border border-slate-700">
                                        {{ $gaji->periode }}
                                    </span>
                                    @if ($gaji->status === 'dibayar')
                                        <span class="text-xs font-semibold text-emerald-400 flex items-center gap-1">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span> Lunas
                                        </span>
                                    @else
                                        <span class="text-xs font-semibold text-amber-400 flex items-center gap-1">
                                            <span class="w-1.5 h-1.5 rounded-full bg-amber-400"></span> Pending
                                        </span>
                                    @endif
                                </div>

                                <div class="flex justify-between items-baseline pt-1">
                                    <span class="text-xs text-slate-400">Total Diterima:</span>
                                    <span class="text-lg font-extrabold text-emerald-400">
                                        Rp {{ number_format($gaji->total_gaji, 0, ',', '.') }}
                                    </span>
                                </div>

                                <div class="pt-2 border-t border-slate-800/80 flex items-center justify-between">
                                    <span class="text-xs text-slate-500">
                                        {{ $gaji->total_volume }} unit &times; Rp
                                        {{ number_format($gaji->tarif, 0, ',', '.') }}
                                    </span>
                                    <a href="{{ route('karyawan.penggajian.show', $gaji->id) }}"
                                        class="text-xs text-blue-400 hover:underline font-medium">
                                        Detail Slip &rarr;
                                    </a>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-6 text-slate-500 text-sm">
                                Belum ada riwayat slip gaji.
                            </div>
                        @endforelse
                    </div>
                </div>

            </div>

        </div>

    </div>
@endsection
