@extends('layouts.admin')

@section('title', 'Riwayat Export Laporan')

@section('content')
    <div class="space-y-6">
        <!-- Header & Action -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-white tracking-tight">Riwayat Export Laporan</h1>
                <p class="text-sm text-slate-400 mt-1">Daftar berkas laporan penggajian borongan yang telah di-generate.</p>
            </div>
            <a href="{{ route('admin.laporan.create') }}"
                class="inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-medium text-sm rounded-lg shadow-lg shadow-blue-600/30 transition-all duration-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Generate Laporan Baru
            </a>
        </div>

        <!-- Table Card -->
        <div class="bg-slate-800 border border-slate-700/60 rounded-xl shadow-xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-300">
                    <thead
                        class="bg-slate-900/60 text-slate-400 uppercase text-xs tracking-wider border-b border-slate-700/60">
                        <tr>
                            <th scope="col" class="px-6 py-4">No</th>
                            <th scope="col" class="px-6 py-4">Periode Laporan</th>
                            <th scope="col" class="px-6 py-4">Nama File Export</th>
                            <th scope="col" class="px-6 py-4">Tanggal Dibuat</th>
                            <th scope="col" class="px-6 py-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-700/60">
                        @forelse($laporans as $index => $item)
                            <tr class="hover:bg-slate-700/30 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap font-medium text-slate-400">
                                    {{ $laporans->firstItem() + $index }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap font-bold text-white">
                                    {{ $item->periode }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-slate-300 font-mono text-xs">
                                    {{ basename($item->file_export) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-slate-400">
                                    {{ $item->created_at ? $item->created_at->translatedFormat('d M Y (H:i)') : '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <!-- Download Button -->
                                        <a href="{{ route('admin.laporan.download', $item->id) }}" title="Download File"
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-emerald-500/10 hover:bg-emerald-500/20 text-emerald-400 border border-emerald-500/20 text-xs font-semibold transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                            </svg>
                                            Download CSV
                                        </a>

                                        <!-- Delete Button -->
                                        <form action="{{ route('admin.laporan.destroy', $item->id) }}" method="POST"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus riwayat laporan ini beserta file fisik dari storage?')"
                                            class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" title="Hapus"
                                                class="p-2 rounded-lg bg-rose-500/10 hover:bg-rose-500/20 text-rose-400 transition-colors border border-rose-500/20">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-slate-500">
                                    Belum ada riwayat laporan yang di-export.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if ($laporans->hasPages())
                <div class="px-6 py-4 border-t border-slate-700/60 bg-slate-900/30">
                    {{ $laporans->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
