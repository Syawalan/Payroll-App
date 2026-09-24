@extends('layouts.admin')

@section('title', 'Input Penggajian Baru')

@section('content')
    <div class="max-w-3xl mx-auto space-y-6">
        <!-- Header & Back Button -->
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.penggajian.index') }}"
                class="p-2 rounded-lg bg-slate-800 hover:bg-slate-700 text-slate-400 hover:text-white transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-white tracking-tight">Input Penggajian</h1>
                <p class="text-sm text-slate-400">Hitung dan buat data gaji borongan untuk karyawan.</p>
            </div>
        </div>

        <!-- Form Card -->
        <div class="bg-slate-800 border border-slate-700/60 rounded-xl p-6 shadow-xl" x-data="{ volume: {{ old('total_volume', 0) }}, tarif: {{ old('tarif', 0) }} }">
            <form action="{{ route('admin.penggajian.store') }}" method="POST" enctype="multipart/form-data"
                class="space-y-5">
                @csrf

                <!-- Pilih Karyawan & Periode -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label for="user_id" class="block text-sm font-medium text-slate-300 mb-2">Pilih Karyawan</label>
                        <select name="user_id" id="user_id" required
                            class="w-full px-4 py-2.5 rounded-lg bg-slate-900/80 border @error('user_id') border-rose-500 @else border-slate-700 @enderror text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">-- Pilih Karyawan --</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('user_id')
                            <p class="mt-1.5 text-xs text-rose-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="periode" class="block text-sm font-medium text-slate-300 mb-2">Periode Gaji</label>
                        <input type="text" name="periode" id="periode" value="{{ old('periode', date('F Y')) }}"
                            required
                            class="w-full px-4 py-2.5 rounded-lg bg-slate-900/80 border @error('periode') border-rose-500 @else border-slate-700 @enderror text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Contoh: Januari 2026 atau Minggu 1 Sep 2026">
                        @error('periode')
                            <p class="mt-1.5 text-xs text-rose-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Total Volume & Tarif per Volume -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label for="total_volume" class="block text-sm font-medium text-slate-300 mb-2">Total Volume
                            Diselesaikan</label>
                        <input type="number" min="0" name="total_volume" id="total_volume" x-model.number="volume"
                            required
                            class="w-full px-4 py-2.5 rounded-lg bg-slate-900/80 border @error('total_volume') border-rose-500 @else border-slate-700 @enderror text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="0">
                        @error('total_volume')
                            <p class="mt-1.5 text-xs text-rose-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="tarif" class="block text-sm font-medium text-slate-300 mb-2">Tarif Borongan per Unit
                            (Rp)</label>
                        <input type="number" min="0" step="100" name="tarif" id="tarif"
                            x-model.number="tarif" required
                            class="w-full px-4 py-2.5 rounded-lg bg-slate-900/80 border @error('tarif') border-rose-500 @else border-slate-700 @enderror text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="0">
                        @error('tarif')
                            <p class="mt-1.5 text-xs text-rose-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Preview Hitungan Otomatis -->
                <div class="p-4 rounded-lg bg-blue-600/10 border border-blue-500/20 flex items-center justify-between">
                    <div>
                        <span class="text-xs text-slate-400 font-semibold uppercase tracking-wider block">Kalkulasi Otomatis
                            Total Gaji</span>
                        <p class="text-2xl font-bold text-emerald-400 mt-0.5">
                            Rp <span x-text="(volume * tarif).toLocaleString('id-ID')">0</span>
                        </p>
                    </div>
                    <div class="text-right text-xs text-slate-400">
                        <span>Rumus: <code class="text-blue-300">Volume &times; Tarif</code></span>
                    </div>
                </div>

                <!-- Status & Upload Bukti Pembayaran -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label for="status" class="block text-sm font-medium text-slate-300 mb-2">Status
                            Pembayaran</label>
                        <select name="status" id="status" required
                            class="w-full px-4 py-2.5 rounded-lg bg-slate-900/80 border @error('status') border-rose-500 @else border-slate-700 @enderror text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="belum" {{ old('status') === 'belum' ? 'selected' : '' }}>Belum Dibayar
                                (Pending)</option>
                            <option value="dibayar" {{ old('status') === 'dibayar' ? 'selected' : '' }}>Dibayar (Lunas)
                            </option>
                        </select>
                        @error('status')
                            <p class="mt-1.5 text-xs text-rose-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="bukti" class="block text-sm font-medium text-slate-300 mb-2">Upload Bukti Transfer /
                            Slip (Opsional)</label>
                        <input type="file" name="bukti" id="bukti" accept="image/*,.pdf"
                            class="w-full px-3 py-2 rounded-lg bg-slate-900/80 border @error('bukti') border-rose-500 @else border-slate-700 @enderror text-slate-300 text-sm file:mr-4 file:py-1.5 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-blue-600 file:text-white hover:file:bg-blue-700">
                        @error('bukti')
                            <p class="mt-1.5 text-xs text-rose-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-700/60">
                    <a href="{{ route('admin.penggajian.index') }}"
                        class="px-4 py-2.5 rounded-lg bg-slate-700 text-slate-300 hover:text-white font-medium text-sm transition-colors">
                        Batal
                    </a>
                    <button type="submit"
                        class="px-5 py-2.5 rounded-lg bg-blue-600 hover:bg-blue-700 text-white font-medium text-sm shadow-lg shadow-blue-600/30 transition-all">
                        Simpan Data Penggajian
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
