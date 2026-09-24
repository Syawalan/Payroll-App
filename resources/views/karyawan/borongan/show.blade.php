@extends('layouts.karyawan')

@section('title', 'Detail Tugas Borongan')

@section('content')
    <div class="max-w-3xl mx-auto space-y-6">
        <!-- Header & Back Button -->
        <div class="flex items-center gap-4">
            <a href="{{ route('karyawan.borongan.index') }}"
                class="p-2 rounded-lg bg-slate-800 hover:bg-slate-700 text-slate-400 hover:text-white transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-white tracking-tight">Rincian Tugas Borongan</h1>
                <p class="text-sm text-slate-400">Informasi detail mengenai lokasi dan volume barang pengiriman Anda.</p>
            </div>
        </div>

        <!-- Card Detail -->
        <div class="bg-slate-800 border border-slate-700/60 rounded-xl p-6 shadow-xl space-y-6">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pb-6 border-b border-slate-700/60">
                <div>
                    <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider block mb-1">Tanggal
                        Pengiriman</span>
                    <p class="text-xl font-bold text-white">
                        {{ \Carbon\Carbon::parse($borongan->tanggal_pengiriman)->translatedFormat('l, d F Y') }}
                    </p>
                </div>
                <div>
                    <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider block mb-1">Status
                        Penugasan</span>
                    <span
                        class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span> Ditugaskan ke Anda
                    </span>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pb-6 border-b border-slate-700/60">
                <div>
                    <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider block mb-1">Nama Barang /
                        Material</span>
                    <p class="text-lg font-bold text-blue-400">
                        {{ $borongan->nama_barang }}
                    </p>
                </div>
                <div>
                    <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider block mb-1">Volume
                        Pekerjaan</span>
                    <span
                        class="inline-flex items-center px-3 py-1 rounded-md text-sm font-bold bg-blue-500/10 text-blue-400 border border-blue-500/20">
                        {{ $borongan->volume }} {{ $borongan->satuan }}
                    </span>
                </div>
            </div>

            <div>
                <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider block mb-2">Alamat Tujuan
                    Pengiriman / Proyek</span>
                <div
                    class="p-4 rounded-lg bg-slate-900/60 border border-slate-700/50 text-slate-200 text-sm leading-relaxed flex items-start gap-3">
                    <svg class="w-5 h-5 text-blue-400 shrink-0 mt-0.5" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <div>
                        {{ $borongan->alamat_tujuan }}
                    </div>
                </div>
            </div>

            <div class="pt-2 text-xs text-slate-500 flex justify-between items-center border-t border-slate-700/40">
                <span>ID Borongan: #{{ $borongan->id }}</span>
                <span>Dicatat Admin pada:
                    {{ $borongan->created_at ? $borongan->created_at->format('d M Y H:i') : '-' }}</span>
            </div>

        </div>
    </div>
@endsection
