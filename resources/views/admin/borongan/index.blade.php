@extends('layouts.admin')

@section('title', 'Data Borongan Material')

@section('content')
    <div class="space-y-6">
        <!-- Header & Action -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-white tracking-tight">Data Borongan Material</h1>
                <p class="text-sm text-slate-400 mt-1">Daftar penugasan dan pengiriman material borongan oleh karyawan.</p>
            </div>
            <a href="{{ route('admin.borongan.create') }}"
                class="inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-medium text-sm rounded-lg shadow-lg shadow-blue-600/30 transition-all duration-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Borongan Baru
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
                            <th scope="col" class="px-6 py-4">Tanggal</th>
                            <th scope="col" class="px-6 py-4">Nama Karyawan</th>
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
                                    {{ \Carbon\Carbon::parse($item->tanggal_pengiriman)->format('d M Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="font-semibold text-blue-400">{{ $item->user->name ?? 'Karyawan Dihapus' }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-white font-medium">
                                    {{ $item->nama_barang }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-semibold bg-blue-500/10 text-blue-400 border border-blue-500/20">
                                        {{ $item->volume }} {{ $item->satuan }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 max-w-xs truncate text-slate-400" title="{{ $item->alamat_tujuan }}">
                                    {{ $item->alamat_tujuan }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('admin.borongan.show', $item->id) }}" title="Detail"
                                            class="p-2 rounded-lg bg-slate-700/50 hover:bg-slate-700 text-slate-300 hover:text-white transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </a>
                                        <a href="{{ route('admin.borongan.edit', $item->id) }}" title="Edit"
                                            class="p-2 rounded-lg bg-amber-500/10 hover:bg-amber-500/20 text-amber-400 transition-colors border border-amber-500/20">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>
                                        <form action="{{ route('admin.borongan.destroy', $item->id) }}" method="POST"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus data borongan ini?')"
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
                                <td colspan="7" class="px-6 py-8 text-center text-slate-500">
                                    Belum ada data borongan terdaftar.
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
