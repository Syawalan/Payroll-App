@extends('layouts.karyawan')

@section('title', 'Daftar Borongan Saya')

@section('content')
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-white tracking-tight">Daftar Borongan Saya</h1>
                <p class="text-sm text-slate-400 mt-1">Riwayat dan daftar penugasan pengiriman material borongan yang
                    ditugaskan kepada Anda.</p>
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
                            <th scope="col" class="px-6 py-4">Tanggal Pengiriman</th>
                            <th scope="col" class="px-6 py-4">Nama Barang</th>
                            <th scope="col" class="px-6 py-4">Volume</th>
                            <th scope="col" class="px-6 py-4">Alamat Tujuan</th>
                            <th scope="col" class="px-6 py-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-700/60">
                        @forelse($borongans as $index => $item)
                            <tr class="hover:bg-slate-700/30 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap font-medium text-slate-400">
                                    {{ $borongans->firstItem() + $index }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-white font-medium">
                                    {{ \Carbon\Carbon::parse($item->tanggal_pengiriman)->translatedFormat('d M Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap font-semibold text-blue-400">
                                    {{ $item->nama_barang }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-bold bg-blue-500/10 text-blue-400 border border-blue-500/20">
                                        {{ $item->volume }} {{ $item->satuan }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 max-w-xs truncate text-slate-400" title="{{ $item->alamat_tujuan }}">
                                    {{ $item->alamat_tujuan }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <a href="{{ route('karyawan.borongan.show', $item->id) }}" title="Lihat Detail Rincian"
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-slate-700/50 hover:bg-slate-700 text-slate-300 hover:text-white text-xs font-semibold transition-colors border border-slate-600/50">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-8 text-center text-slate-500">
                                    Belum ada data tugas borongan yang ditugaskan kepada Anda.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if ($borongans->hasPages())
                <div class="px-6 py-4 border-t border-slate-700/60 bg-slate-900/30">
                    {{ $borongans->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
