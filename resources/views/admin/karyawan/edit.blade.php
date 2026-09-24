@extends('layouts.admin')

@section('title', 'Edit Data Karyawan')

@section('content')
    <div class="max-w-2xl mx-auto space-y-6">
        <!-- Header & Back Button -->
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.karyawan.index') }}"
                class="p-2 rounded-lg bg-slate-800 hover:bg-slate-700 text-slate-400 hover:text-white transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-white tracking-tight">Edit Akun Karyawan</h1>
                <p class="text-sm text-slate-400">Perbarui informasi profil atau reset password karyawan.</p>
            </div>
        </div>

        <!-- Form Card -->
        <div class="bg-slate-800 border border-slate-700/60 rounded-xl p-6 shadow-xl">
            <form action="{{ route('admin.karyawan.update', $karyawan->id) }}" method="POST" class="space-y-5">
                @csrf
                @method('PUT')

                <!-- Nama Lengkap -->
                <div>
                    <label for="name" class="block text-sm font-medium text-slate-300 mb-2">Nama Lengkap</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $karyawan->name) }}" required
                        class="w-full px-4 py-2.5 rounded-lg bg-slate-900/80 border @error('name') border-rose-500 @else border-slate-700 @enderror text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('name')
                        <p class="mt-1.5 text-xs text-rose-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-slate-300 mb-2">Alamat Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $karyawan->email) }}"
                        required
                        class="w-full px-4 py-2.5 rounded-lg bg-slate-900/80 border @error('email') border-rose-500 @else border-slate-700 @enderror text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('email')
                        <p class="mt-1.5 text-xs text-rose-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Notice Reset Password -->
                <div
                    class="p-4 rounded-lg bg-amber-500/10 border border-amber-500/20 text-amber-300 text-xs leading-relaxed">
                    <span class="font-bold">Info:</span> Biarkan kolom password di bawah kosong jika Anda tidak ingin
                    mereset password karyawan ini.
                </div>

                <!-- Password Baru (Opsional) -->
                <div>
                    <label for="password" class="block text-sm font-medium text-slate-300 mb-2">Password Baru
                        (Opsional)</label>
                    <input type="password" name="password" id="password"
                        class="w-full px-4 py-2.5 rounded-lg bg-slate-900/80 border @error('password') border-rose-500 @else border-slate-700 @enderror text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Biarkan kosong jika tidak diubah">
                    @error('password')
                        <p class="mt-1.5 text-xs text-rose-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Konfirmasi Password Baru -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-slate-300 mb-2">Konfirmasi
                        Password Baru</label>
                    <input type="password" name="password_confirmation" id="password_confirmation"
                        class="w-full px-4 py-2.5 rounded-lg bg-slate-900/80 border border-slate-700 text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Ulangi password baru">
                </div>

                <!-- Actions -->
                <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-700/60">
                    <a href="{{ route('admin.karyawan.index') }}"
                        class="px-4 py-2.5 rounded-lg bg-slate-700 text-slate-300 hover:text-white font-medium text-sm transition-colors">
                        Batal
                    </a>
                    <button type="submit"
                        class="px-5 py-2.5 rounded-lg bg-blue-600 hover:bg-blue-700 text-white font-medium text-sm shadow-lg shadow-blue-600/30 transition-all">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
