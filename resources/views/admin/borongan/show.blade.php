@extends('layouts.admin')

@section('title', 'Detail Borongan Material')

@section('content')
    <div class="max-w-3xl mx-auto space-y-6">
        <!-- Header & Back Button -->
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.borongan.index') }}"
                    class="p-2 rounded-lg bg-slate-800 hover:bg-slate-700 text-slate-400 hover:text-white transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </a>
                <div>
                    <h1 class="text-2xl font-bold text-white tracking-tight">Detail Borongan</h1>
                    <p class="text-sm text-slate-400">Informasi rinci pengiriman material borongan.</p>
                </div>
            </div>

            <div class="flex items-center gap-2">
                <a href="{{ route('admin.borongan.edit', $borongan->id) }}"
                    class="px-4 py-2 rounded-lg bg-amber-500/10 text-amber-400 border border-amber-500/20 hover:bg-amber-500/20 text-sm font-medium transition-colors">
                    Edit Data
                </a>
            </div>
        </div>

        <!-- Main Detail Card -->
        <div class="bg-slate-800 border border-slate-700/60 rounded-xl p-6 shadow-xl space-y-6">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pb-6 border-b border-slate-700/60">
                <div>
                    <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider block mb-1">Tanggal
                        Pengiriman</span>
                    <p class="text-xl font-bold text-white">
                        {{ \Carbon\Carbon::parse($borongan->tanggal_pengiriman)->translatedFormat('d F Y') }}
                    </p>
                </div>
                <div>
                    <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider block mb-1">Penanggung Jawab
                        (Karyawan)</span>
                    <p class="text-xl font-bold text-blue-400">
                        {{ $borongan->user->name ?? 'Karyawan Dihapus' }}
                    </p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pb-6 border-b border-slate-700/60">
                <div>
                    <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider block mb-1">Nama Barang /
                        Material</span>
                    <p class="text-lg font-semibold text-white">
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
                <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider block mb-1">Alamat Tujuan
                    Pengiriman</span>
                <div
                    class="p-4 rounded-lg bg-slate-900/60 border border-slate-700/50 text-slate-200 text-sm leading-relaxed">
                    {{ $borongan->alamat_tujuan }}
                </div>
            </div>

            <div class="pt-2 text-xs text-slate-500 flex justify-between items-center">
                <span>Dicatat pada: {{ $borongan->created_at ? $borongan->created_at->format('d M Y H:i') : '-' }}</span>
                <span>ID Borongan: #{{ $borongan->id }}</span>
            </div>

        </div>
    </div>
@endsection
