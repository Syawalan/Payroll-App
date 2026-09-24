@extends('layouts.karyawan')

@section('title', 'Riwayat Penggajian Saya')

@section('content')
    <div class="space-y-6">
        <!-- Header & Filter Tahun -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-white tracking-tight">Riwayat Gaji Saya</h1>
                <p class="text-sm text-slate-400 mt-1">Daftar slip gaji dan bukti pencairan borongan Anda.</p>
            </div>

            <!-- Filter Tahun -->
            <form method="GET" action="{{ route('karyawan.penggajian.index') }}" class="flex items-center gap-2">
                <label for="tahun" class="text-xs text-slate-400 font-semibold uppercase">Tahun:</label>
                <select name="tahun" id="tahun" onchange="this.form.submit()"
                    class="px-3 py-1.5 rounded-lg bg-slate-800 border border-slate-700 text-white text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @for ($y = date('Y'); $y >= date('Y') - 4; $y--)
                        <option value="{{ $y }}" {{ $tahun == $y ? 'selected' : '' }}>{{ $y }}
                        </option>
                    @endfor
                </select>
            </form>
        </div>

        <!-- Ringkasan Statistik Gaji -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <!-- Total Gaji Diterima -->
            <div class="bg-slate-800 border border-slate-700/60 rounded-xl p-5 shadow-lg flex items-center justify-between">
                <div>
                    <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider block">Total Gaji Diterima
                        ({{ $tahun }})</span>
                    <span class="text-2xl font-extrabold text-emerald-400 mt-1 block">
                        Rp {{ number_format($totalGajiDiterima, 0, ',', '.') }}
                    </span>
                    <span class="text-xs text-slate-500 mt-0.5 block">Status: Telah dicairkan</span>
                </div>
                <div
                    class="w-12 h-12 rounded-xl bg-emerald-500/20 text-emerald-400 flex items-center justify-center border border-emerald-500/30 shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>

            <!-- Total Gaji Pending -->
            <div class="bg-slate-800 border border-slate-700/60 rounded-xl p-5 shadow-lg flex items-center justify-between">
                <div>
                    <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider block">Gaji Belum Dicairkan
                        (Pending)</span>
                    <span class="text-2xl font-extrabold text-amber-400 mt-1 block">
                        Rp {{ number_format($totalGajiPending, 0, ',', '.') }}
                    </span>
                    <span class="text-xs text-slate-500 mt-0.5 block">Menunggu proses transfer</span>
                </div>
                <div
                    class="w-12 h-12 rounded-xl bg-amber-500/20 text-amber-400 flex items-center justify-center border border-amber-500/30 shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Table Card -->
        <div class="bg-slate-800 border border-slate-700/60 rounded-xl shadow-xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-300">
                    <thead
                        class="bg-slate-900/60 text-slate-400 uppercase text-xs tracking-wider border-b border-slate-700/60">
                        <tr>
                            <th scope="col" class="px-6 py-4">No</th>
                            <th scope="col" class="px-6 py-4">Periode</th>
                            <th scope="col" class="px-6 py-4">Volume Borongan</th>
                            <th scope="col" class="px-6 py-4">Tarif / Unit</th>
                            <th scope="col" class="px-6 py-4">Total Gaji</th>
                            <th scope="col" class="px-6 py-4">Status</th>
                            <th scope="col" class="px-6 py-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-700/60">
                        @forelse($penggajians as $index => $item)
                            <tr class="hover:bg-slate-700/30 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap font-medium text-slate-400">
                                    {{ $penggajians->firstItem() + $index }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap font-semibold text-white">
                                    {{ $item->periode }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-slate-300">
                                    {{ number_format($item->total_volume, 0, ',', '.') }} Unit
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-slate-300">
                                    Rp {{ number_format($item->tarif, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap font-bold text-emerald-400">
                                    Rp {{ number_format($item->total_gaji, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if ($item->status === 'dibayar')
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
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('karyawan.penggajian.show', $item->id) }}"
                                            title="Lihat Detail Slip Gaji"
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-slate-700/50 hover:bg-slate-700 text-slate-300 hover:text-white text-xs font-semibold transition-colors border border-slate-600/50">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            Slip Gaji
                                        </a>

                                        @if ($item->status === 'dibayar' && $item->bukti)
                                            <a href="{{ route('karyawan.penggajian.download-bukti', $item->id) }}"
                                                title="Unduh Bukti Transfer"
                                                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-emerald-500/10 hover:bg-emerald-500/20 text-emerald-400 border border-emerald-500/20 text-xs font-semibold transition-colors">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                                </svg>
                                                Bukti Bayar
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-8 text-center text-slate-500">
                                    Belum ada riwayat penggajian untuk tahun {{ $tahun }}.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if ($penggajians->hasPages())
                <div class="px-6 py-4 border-t border-slate-700/60 bg-slate-900/30">
                    {{ $penggajians->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
