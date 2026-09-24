@extends('layouts.admin')

@section('title', 'Detail Slip Gaji')

@section('content')
    <div class="max-w-3xl mx-auto space-y-6">
        <!-- Header & Back Button -->
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.penggajian.index') }}"
                    class="p-2 rounded-lg bg-slate-800 hover:bg-slate-700 text-slate-400 hover:text-white transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </a>
                <div>
                    <h1 class="text-2xl font-bold text-white tracking-tight">Slip Gaji Karyawan</h1>
                    <p class="text-sm text-slate-400">Rincian perhitungan dan status pembayaran penggajian.</p>
                </div>
            </div>

            <a href="{{ route('admin.penggajian.edit', $penggajian->id) }}"
                class="px-4 py-2 rounded-lg bg-amber-500/10 text-amber-400 border border-amber-500/20 hover:bg-amber-500/20 text-sm font-medium transition-colors">
                Edit Gaji
            </a>
        </div>

        <!-- Slip Card -->
        <div class="bg-slate-800 border border-slate-700/60 rounded-xl p-6 shadow-xl space-y-6">

            <!-- Header Info -->
            <div
                class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 pb-6 border-b border-slate-700/60">
                <div>
                    <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider block">Penerima Gaji</span>
                    <h2 class="text-2xl font-bold text-blue-400 mt-1">{{ $penggajian->user->name ?? 'Karyawan Dihapus' }}
                    </h2>
                    <p class="text-sm text-slate-400">{{ $penggajian->user->email ?? '-' }}</p>
                </div>
                <div class="text-left sm:text-right">
                    <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider block">Periode</span>
                    <span
                        class="inline-block mt-1 px-3 py-1 bg-slate-900 rounded-lg text-white font-bold text-sm border border-slate-700">
                        {{ $penggajian->periode }}
                    </span>
                </div>
            </div>

            <!-- Breakdown Table -->
            <div class="bg-slate-900/60 rounded-xl p-5 border border-slate-700/50 space-y-4">
                <h3 class="text-sm font-bold text-white uppercase tracking-wider border-b border-slate-700/60 pb-3">Rincian
                    Perhitungan Borongan</h3>

                <div class="flex justify-between items-center text-sm py-1">
                    <span class="text-slate-400">Total Akumulasi Volume</span>
                    <span class="text-white font-semibold">{{ number_format($penggajian->total_volume, 0, ',', '.') }}
                        Unit</span>
                </div>

                <div class="flex justify-between items-center text-sm py-1">
                    <span class="text-slate-400">Tarif per Unit</span>
                    <span class="text-white font-semibold">Rp {{ number_format($penggajian->tarif, 0, ',', '.') }}</span>
                </div>

                <div class="pt-3 border-t border-slate-700/60 flex justify-between items-center">
                    <span class="text-base font-bold text-white">Total Gaji Diterima</span>
                    <span class="text-2xl font-extrabold text-emerald-400">Rp
                        {{ number_format($penggajian->total_gaji, 0, ',', '.') }}</span>
                </div>
            </div>

            <!-- Status & Proof -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 pt-2">
                <div>
                    <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider block mb-2">Status
                        Pembayaran</span>
                    @if ($penggajian->status === 'dibayar')
                        <span
                            class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg text-sm font-bold bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                            <span class="w-2 h-2 rounded-full bg-emerald-400"></span> Lunas / Dibayar
                        </span>
                    @else
                        <span
                            class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg text-sm font-bold bg-amber-500/10 text-amber-400 border border-amber-500/20">
                            <span class="w-2 h-2 rounded-full bg-amber-400"></span> Belum Dibayar
                        </span>
                    @endif
                </div>

                <div>
                    <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider block mb-2">Bukti Pembayaran
                        / Transfer</span>
                    @if ($penggajian->bukti)
                        <a href="{{ asset('storage/' . $penggajian->bukti) }}" target="_blank"
                            class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-blue-600/20 text-blue-400 border border-blue-500/30 hover:bg-blue-600/30 text-sm font-medium transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Lihat / Download Bukti
                        </a>
                    @else
                        <span class="text-slate-500 text-sm italic">Belum ada bukti yang diunggah.</span>
                    @endif
                </div>
            </div>

        </div>
    </div>
@endsection
