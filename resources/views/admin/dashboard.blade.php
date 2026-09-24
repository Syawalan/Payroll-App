@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
    <div class="space-y-6">
        <!-- Header Halaman -->
        <div>
            <h1 class="text-2xl font-bold text-white tracking-wide">Dashboard Operasional</h1>
            <p class="text-sm text-slate-400">Ringkasan aktivitas pengiriman material, jadwal shift, dan penggajian borongan.
            </p>
        </div>

        <!-- 1. KPI Cards (Statistik Utama) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Card Total Karyawan -->
            <div class="p-5 rounded-xl bg-slate-800 border border-slate-700/60 shadow-lg flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Total Karyawan</p>
                    <h3 class="text-2xl font-bold text-white mt-1">{{ number_format($totalKaryawan) }}</h3>
                    <span class="text-xs text-blue-400 font-medium">Aktif bekerja</span>
                </div>
                <div class="p-3 bg-blue-600/10 border border-blue-500/20 text-blue-500 rounded-xl">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
            </div>

            <!-- Card Total Volume -->
            <div class="p-5 rounded-xl bg-slate-800 border border-slate-700/60 shadow-lg flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Volume Bulan Ini</p>
                    <h3 class="text-2xl font-bold text-white mt-1">{{ number_format($totalVolumeBulanIni) }}</h3>
                    <span class="text-xs text-emerald-400 font-medium">Satuan terkirim</span>
                </div>
                <div class="p-3 bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 rounded-xl">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                </div>
            </div>

            <!-- Card Gaji Pending -->
            <div class="p-5 rounded-xl bg-slate-800 border border-slate-700/60 shadow-lg flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Gaji Belum Dibayar</p>
                    <h3 class="text-2xl font-bold text-amber-400 mt-1">Rp
                        {{ number_format($totalGajiPending, 0, ',', '.') }}</h3>
                    <span class="text-xs text-amber-400/80 font-medium">{{ $jumlahPendingCount }} transaksi pending</span>
                </div>
                <div class="p-3 bg-amber-500/10 border border-amber-500/20 text-amber-400 rounded-xl">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>

            <!-- Card Total Dibayar -->
            <div class="p-5 rounded-xl bg-slate-800 border border-slate-700/60 shadow-lg flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Terbayar Bulan Ini</p>
                    <h3 class="text-2xl font-bold text-white mt-1">Rp
                        {{ number_format($totalGajiTelahDibayar, 0, ',', '.') }}</h3>
                    <span class="text-xs text-slate-400 font-medium">Sudah dicairkan</span>
                </div>
                <div class="p-3 bg-blue-500/10 border border-blue-500/20 text-blue-400 rounded-xl">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- 2. Grid Dua Kolom (Borongan Terbaru & Pending Penggajian) -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Tabel Pengiriman Borongan Terbaru -->
            <div class="bg-slate-800 border border-slate-700/60 rounded-xl p-5 shadow-lg space-y-4">
                <div class="flex items-center justify-between">
                    <h2 class="text-lg font-bold text-white">Borongan Terbaru</h2>
                    <a href="{{ route('admin.borongan.index') }}"
                        class="text-xs text-blue-400 hover:text-blue-300 font-medium">Lihat Semua &rarr;</a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-slate-300">
                        <thead class="bg-slate-900/60 text-slate-400 uppercase text-xs">
                            <tr>
                                <th class="py-3 px-3">Karyawan</th>
                                <th class="py-3 px-3">Barang</th>
                                <th class="py-3 px-3 text-center">Vol</th>
                                <th class="py-3 px-3">Tanggal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-700/50">
                            @forelse($boronganTerbaru as $b)
                                <tr class="hover:bg-slate-700/30">
                                    <td class="py-3 px-3 font-medium text-white">{{ $b->user->name ?? '-' }}</td>
                                    <td class="py-3 px-3">{{ $b->nama_barang }}</td>
                                    <td class="py-3 px-3 text-center"><span
                                            class="px-2 py-1 bg-slate-700 text-blue-400 rounded text-xs font-bold">{{ $b->volume }}
                                            {{ $b->satuan }}</span></td>
                                    <td class="py-3 px-3 text-xs text-slate-400">
                                        {{ \Carbon\Carbon::parse($b->tanggal_pengiriman)->format('d/m/Y') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-4 text-center text-slate-500">Belum ada data borongan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Tabel Tagihan Gaji Belum Dibayar -->
            <div class="bg-slate-800 border border-slate-700/60 rounded-xl p-5 shadow-lg space-y-4">
                <div class="flex items-center justify-between">
                    <h2 class="text-lg font-bold text-white">Gaji Perlu Diproses</h2>
                    <a href="{{ route('admin.penggajian.index') }}"
                        class="text-xs text-blue-400 hover:text-blue-300 font-medium">Lihat Semua &rarr;</a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-slate-300">
                        <thead class="bg-slate-900/60 text-slate-400 uppercase text-xs">
                            <tr>
                                <th class="py-3 px-3">Karyawan</th>
                                <th class="py-3 px-3">Periode</th>
                                <th class="py-3 px-3">Total Gaji</th>
                                <th class="py-3 px-3 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-700/50">
                            @forelse($penggajianPending as $p)
                                <tr class="hover:bg-slate-700/30">
                                    <td class="py-3 px-3 font-medium text-white">{{ $p->user->name ?? '-' }}</td>
                                    <td class="py-3 px-3 text-xs text-slate-400">{{ $p->periode }}</td>
                                    <td class="py-3 px-3 font-semibold text-amber-400">Rp
                                        {{ number_format($p->total_gaji, 0, ',', '.') }}</td>
                                    <td class="py-3 px-3 text-right">
                                        <a href="{{ route('admin.penggajian.edit', $p->id) }}"
                                            class="px-2.5 py-1 bg-blue-600 hover:bg-blue-700 text-white rounded text-xs font-semibold">Bayar</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-4 text-center text-slate-500">Tidak ada gaji pending.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
