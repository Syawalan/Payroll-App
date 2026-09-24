@extends('layouts.admin')

@section('title', 'Generate Laporan Penggajian')

@section('content')
    <div class="max-w-2xl mx-auto space-y-6">
        <!-- Header & Back Button -->
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.laporan.index') }}"
                class="p-2 rounded-lg bg-slate-800 hover:bg-slate-700 text-slate-400 hover:text-white transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-white tracking-tight">Generate Laporan</h1>
                <p class="text-sm text-slate-400">Pilih periode untuk mengeksport rekapan gaji ke format CSV / Excel.</p>
            </div>
        </div>

        <!-- Info Banner -->
        <div
            class="p-4 rounded-xl bg-blue-600/10 border border-blue-500/20 text-slate-300 text-xs leading-relaxed flex items-start gap-3">
            <svg class="w-5 h-5 text-blue-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <div>
                <span class="font-bold text-white block mb-0.5">Petunjuk Export:</span>
                Sistem akan mengumpulkan seluruh data transaksi penggajian pada periode terpilih dan menyimpannya menjadi
                file <strong>.csv</strong>. File ini dapat dibuka langsung menggunakan Microsoft Excel atau aplikasi
                spreadsheet lainnya.
            </div>
        </div>

        <!-- Form Card -->
        <div class="bg-slate-800 border border-slate-700/60 rounded-xl p-6 shadow-xl">
            <form action="{{ route('admin.laporan.store') }}" method="POST" class="space-y-5">
                @csrf

                <!-- Pilih Periode -->
                <div>
                    <label for="periode" class="block text-sm font-medium text-slate-300 mb-2">Pilih Periode
                        Penggajian</label>

                    @if (isset($periodes) && count($periodes) > 0)
                        <select name="periode" id="periode" required
                            class="w-full px-4 py-2.5 rounded-lg bg-slate-900/80 border @error('periode') border-rose-500 @else border-slate-700 @enderror text-white focus:outline-none focus:ring-2 focus:ring-blue-500 mb-2">
                            <option value="">-- Pilih Periode Tersedia --</option>
                            @foreach ($periodes as $p)
                                <option value="{{ $p }}" {{ old('periode') == $p ? 'selected' : '' }}>
                                    {{ $p }}
                                </option>
                            @endforeach
                        </select>
                        <p class="text-xs text-slate-400">Atau ketik nama periode secara manual jika tidak ada di pilihan:
                        </p>
                    @endif

                    <input type="text" name="periode_text" id="periode_text" value="{{ old('periode') }}"
                        class="w-full px-4 py-2.5 mt-2 rounded-lg bg-slate-900/80 border @error('periode') border-rose-500 @else border-slate-700 @enderror text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Contoh: Januari 2026"
                        oninput="if(this.value) { document.getElementById('periode').value = ''; }">

                    @error('periode')
                        <p class="mt-1.5 text-xs text-rose-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Actions -->
                <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-700/60">
                    <a href="{{ route('admin.laporan.index') }}"
                        class="px-4 py-2.5 rounded-lg bg-slate-700 text-slate-300 hover:text-white font-medium text-sm transition-colors">
                        Batal
                    </a>
                    <button type="submit"
                        class="inline-flex items-center gap-2 px-5 py-2.5 rounded-lg bg-blue-600 hover:bg-blue-700 text-white font-medium text-sm shadow-lg shadow-blue-600/30 transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                        Export ke CSV
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
