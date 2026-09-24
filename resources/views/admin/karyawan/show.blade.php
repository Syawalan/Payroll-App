@extends('layouts.admin')

@section('title', 'Detail Karyawan')

@section('content')
    <div class="max-w-4xl mx-auto space-y-6">
        <!-- Header & Back Button -->
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.karyawan.index') }}"
                class="p-2 rounded-lg bg-slate-800 hover:bg-slate-700 text-slate-400 hover:text-white transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-white tracking-tight">Detail Profil Karyawan</h1>
                <p class="text-sm text-slate-400">Informasi akun dan riwayat singkat karyawan.</p>
            </div>
        </div>

        <!-- Profile Overview Card -->
        <div
            class="bg-slate-800 border border-slate-700/60 rounded-xl p-6 shadow-xl flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
            <div class="flex items-center gap-4">
                <div
                    class="w-16 h-16 rounded-full bg-blue-600 text-white font-bold text-2xl flex items-center justify-center border-2 border-blue-400/40">
                    {{ strtoupper(substr($karyawan->name, 0, 1)) }}
                </div>
                <div>
                    <h2 class="text-xl font-bold text-white">{{ $karyawan->name }}</h2>
                    <p class="text-slate-400 text-sm mt-0.5">{{ $karyawan->email }}</p>
                    <div
                        class="mt-2 inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-blue-500/10 text-blue-400 border border-blue-500/20">
                        Role: Karyawan Borongan
                    </div>
                </div>
            </div>
            <div class="flex items-center gap-3 w-full md:w-auto">
                <a href="{{ route('admin.karyawan.edit', $karyawan->id) }}"
                    class="flex-1 md:flex-none text-center px-4 py-2.5 rounded-lg bg-amber-500/10 text-amber-400 border border-amber-500/20 hover:bg-amber-500/20 font-medium text-sm transition-colors">
                    Edit Profil
                </a>
            </div>
        </div>

        <!-- Info Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="bg-slate-800 border border-slate-700/60 rounded-xl p-5 shadow-lg">
                <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider block mb-1">Tanggal
                    Terdaftar</span>
                <p class="text-lg font-bold text-white">
                    {{ $karyawan->created_at ? $karyawan->created_at->translatedFormat('d F Y (H:i)') : '-' }}</p>
            </div>
            <div class="bg-slate-800 border border-slate-700/60 rounded-xl p-5 shadow-lg">
                <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider block mb-1">Status Akun</span>
                <span class="inline-flex items-center gap-1.5 text-emerald-400 font-semibold text-base mt-0.5">
                    <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span> Aktif
                </span>
            </div>
        </div>
    </div>
@endsection
