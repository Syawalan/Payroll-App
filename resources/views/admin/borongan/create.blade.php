@extends('layouts.admin')

@section('title', 'Tambah Borongan Baru')

@section('content')
    <div class="max-w-3xl mx-auto space-y-6">
        <!-- Header & Back Button -->
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.borongan.index') }}"
                class="p-2 rounded-lg bg-slate-800 hover:bg-slate-700 text-slate-400 hover:text-white transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-white tracking-tight">Catat Borongan Baru</h1>
                <p class="text-sm text-slate-400">Tambahkan penugasan pengiriman barang borongan ke karyawan.</p>
            </div>
        </div>

        <!-- Form Card -->
        <div class="bg-slate-800 border border-slate-700/60 rounded-xl p-6 shadow-xl">
            <form action="{{ route('admin.borongan.store') }}" method="POST" class="space-y-5">
                @csrf

                <!-- Pilih Karyawan & Tanggal -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label for="user_id" class="block text-sm font-medium text-slate-300 mb-2">Penanggung Jawab /
                            Karyawan</label>
                        <select name="user_id" id="user_id" required
                            class="w-full px-4 py-2.5 rounded-lg bg-slate-900/80 border @error('user_id') border-rose-500 @else border-slate-700 @enderror text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">-- Pilih Karyawan --</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }} ({{ $user->email }})
                                </option>
                            @endforeach
                        </select>
                        @error('user_id')
                            <p class="mt-1.5 text-xs text-rose-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="tanggal_pengiriman" class="block text-sm font-medium text-slate-300 mb-2">Tanggal
                            Pengiriman</label>
                        <input type="date" name="tanggal_pengiriman" id="tanggal_pengiriman"
                            value="{{ old('tanggal_pengiriman', date('Y-m-d')) }}" required
                            class="w-full px-4 py-2.5 rounded-lg bg-slate-900/80 border @error('tanggal_pengiriman') border-rose-500 @else border-slate-700 @enderror text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('tanggal_pengiriman')
                            <p class="mt-1.5 text-xs text-rose-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Nama Barang & Satuan -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                    <div class="md:col-span-2">
                        <label for="nama_barang" class="block text-sm font-medium text-slate-300 mb-2">Nama Barang /
                            Material</label>
                        <input type="text" name="nama_barang" id="nama_barang" value="{{ old('nama_barang') }}" required
                            class="w-full px-4 py-2.5 rounded-lg bg-slate-900/80 border @error('nama_barang') border-rose-500 @else border-slate-700 @enderror text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Misal: Semen Tiga Roda, Pasir Pasang, Batu Split">
                        @error('nama_barang')
                            <p class="mt-1.5 text-xs text-rose-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="satuan" class="block text-sm font-medium text-slate-300 mb-2">Satuan</label>
                        <input type="text" name="satuan" id="satuan" value="{{ old('satuan') }}" required
                            class="w-full px-4 py-2.5 rounded-lg bg-slate-900/80 border @error('satuan') border-rose-500 @else border-slate-700 @enderror text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Misal: Sak, Ton, Rit, m³">
                        @error('satuan')
                            <p class="mt-1.5 text-xs text-rose-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Volume -->
                <div>
                    <label for="volume" class="block text-sm font-medium text-slate-300 mb-2">Jumlah Volume</label>
                    <input type="number" min="1" name="volume" id="volume" value="{{ old('volume') }}" required
                        class="w-full px-4 py-2.5 rounded-lg bg-slate-900/80 border @error('volume') border-rose-500 @else border-slate-700 @enderror text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Masukkan kuantitas/jumlah">
                    @error('volume')
                        <p class="mt-1.5 text-xs text-rose-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Alamat Tujuan -->
                <div>
                    <label for="alamat_tujuan" class="block text-sm font-medium text-slate-300 mb-2">Alamat Tujuan
                        Pengiriman</label>
                    <textarea name="alamat_tujuan" id="alamat_tujuan" rows="3" required
                        class="w-full px-4 py-2.5 rounded-lg bg-slate-900/80 border @error('alamat_tujuan') border-rose-500 @else border-slate-700 @enderror text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Masukkan lokasi proyek / alamat lengkap penerima">{{ old('alamat_tujuan') }}</textarea>
                    @error('alamat_tujuan')
                        <p class="mt-1.5 text-xs text-rose-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Actions -->
                <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-700/60">
                    <a href="{{ route('admin.borongan.index') }}"
                        class="px-4 py-2.5 rounded-lg bg-slate-700 text-slate-300 hover:text-white font-medium text-sm transition-colors">
                        Batal
                    </a>
                    <button type="submit"
                        class="px-5 py-2.5 rounded-lg bg-blue-600 hover:bg-blue-700 text-white font-medium text-sm shadow-lg shadow-blue-600/30 transition-all">
                        Simpan Borongan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
