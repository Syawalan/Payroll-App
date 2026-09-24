@extends('layouts.karyawan')

@section('title', 'Profil Saya')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Header -->
    <div>
        <h1 class="text-2xl font-bold text-white tracking-tight">Profil Saya</h1>
        <p class="text-sm text-slate-400 mt-1">Kelola informasi data diri dan kata sandi akun portal karyawan Anda.</p>
    </div>

    <!-- Ringkasan Akun Header Card -->
    <div class="bg-slate-800 border border-slate-700/60 rounded-xl p-6 shadow-xl flex flex-col sm:flex-row items-center justify-between gap-6">
        <div class="flex items-center gap-4">
            <div class="w-16 h-16 rounded-full bg-blue-600 text-white font-bold text-2xl flex items-center justify-center border-2 border-blue-400/40 shadow-lg shadow-blue-600/30">
                {{ strtoupper(substr(auth()->user()->name ?? 'K', 0, 1)) }}
            </div>
            <div>
                <h2 class="text-xl font-bold text-white">{{ auth()->user()->name }}</h2>
                <p class="text-slate-400 text-sm mt-0.5">{{ auth()->user()->email }}</p>
                <div class="mt-2 inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-blue-500/10 text-blue-400 border border-blue-500/20">
                    <span class="w-1.5 h-1.5 rounded-full bg-blue-400"></span> Karyawan Borongan
                </div>
            </div>
        </div>
        <div class="text-xs text-slate-500 bg-slate-900/60 px-4 py-3 rounded-lg border border-slate-700/50 w-full sm:w-auto text-center sm:text-right">
            <span>Terdaftar Sejak:</span>
            <p class="text-slate-300 font-semibold mt-0.5">{{ auth()->user()->created_at ? auth()->user()->created_at->translatedFormat('d F Y') : '-' }}</p>
        </div>
    </div>

    <!-- Grid Form Pembaruan -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        <!-- Form 1: Informasi Profil -->
        <div class="bg-slate-800 border border-slate-700/60 rounded-xl p-6 shadow-xl flex flex-col justify-between">
            <div>
                <div class="pb-4 border-b border-slate-700/60 mb-5">
                    <h3 class="text-base font-bold text-white">Informasi Profil</h3>
                    <p class="text-xs text-slate-400 mt-1">Perbarui nama lengkap dan alamat email aktif Anda.</p>
                </div>

                <form action="{{ route('profile.update') }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PATCH')

                    <!-- Nama -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-slate-300 mb-2">Nama Lengkap</label>
                        <input type="text" name="name" id="name" value="{{ old('name', auth()->user()->name) }}" required
                               class="w-full px-4 py-2.5 rounded-lg bg-slate-900/80 border @error('name') border-rose-500 @else border-slate-700 @enderror text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('name')
                            <p class="mt-1.5 text-xs text-rose-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-slate-300 mb-2">Alamat Email</label>
                        <input type="email" name="email" id="email" value="{{ old('email', auth()->user()->email) }}" required
                               class="w-full px-4 py-2.5 rounded-lg bg-slate-900/80 border @error('email') border-rose-500 @else border-slate-700 @enderror text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('email')
                            <p class="mt-1.5 text-xs text-rose-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="pt-4 border-t border-slate-700/60 flex justify-end">
                        <button type="submit" class="px-5 py-2.5 rounded-lg bg-blue-600 hover:bg-blue-700 text-white font-medium text-sm shadow-lg shadow-blue-600/30 transition-all">
                            Simpan Profil
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Form 2: Ganti Password -->
        <div class="bg-slate-800 border border-slate-700/60 rounded-xl p-6 shadow-xl flex flex-col justify-between">
            <div>
                <div class="pb-4 border-b border-slate-700/60 mb-5">
                    <h3 class="text-base font-bold text-white">Ganti Kata Sandi</h3>
                    <p class="text-xs text-slate-400 mt-1">Gunakan kombinasi password baru minimal 8 karakter.</p>
                </div>

                <form action="{{ route('password.update') }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <!-- Password Saat Ini -->
                    <div>
                        <label for="current_password" class="block text-sm font-medium text-slate-300 mb-2">Password Saat Ini</label>
                        <input type="password" name="current_password" id="current_password" required
                               class="w-full px-4 py-2.5 rounded-lg bg-slate-900/80 border @error('current_password', 'updatePassword') border-rose-500 @else border-slate-700 @enderror text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500"
                               placeholder="Masukkan password lama">
                        @error('current_password', 'updatePassword')
                            <p class="mt-1.5 text-xs text-rose-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password Baru -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-slate-300 mb-2">Password Baru</label>
                        <input type="password" name="password" id="password" required
                               class="w-full px-4 py-2.5 rounded-lg bg-slate-900/80 border @error('password', 'updatePassword') border-rose-500 @else border-slate-700 @enderror text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500"
                               placeholder="Minimal 8 karakter">
                        @error('password', 'updatePassword')
                            <p class="mt-1.5 text-xs text-rose-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Konfirmasi Password Baru -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-slate-300 mb-2">Konfirmasi Password Baru</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" required
                               class="w-full px-4 py-2.5 rounded-lg bg-slate-900/80 border border-slate-700 text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500"
                               placeholder="Ulangi password baru">
                    </div>

                    <div class="pt-4 border-t border-slate-700/60 flex justify-end">
                        <button type="submit" class="px-5 py-2.5 rounded-lg bg-blue-600 hover:bg-blue-700 text-white font-medium text-sm shadow-lg shadow-blue-600/30 transition-all">
                            Perbarui Password
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection