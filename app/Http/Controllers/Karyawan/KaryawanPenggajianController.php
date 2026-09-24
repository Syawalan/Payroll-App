<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use App\Models\Penggajian;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KaryawanPenggajianController extends Controller
{
    public function index(Request $request)
    {
        $userId = auth()->id();
        $tahun = $request->input('tahun', Carbon::now()->year);

        // 1. Ambil daftar penggajian karyawan berdasarkan tahun
        $penggajians = Penggajian::where('user_id', $userId)
            ->where('periode', 'like', "%{$tahun}%") // Asumsi kolom periode menyimpan string seperti "Januari 2026" atau "2026-01"
            ->latest()
            ->paginate(10)
            ->withQueryString();

        // 2. Ringkasan Statistik Gaji Tahun Ini
        $totalGajiDiterima = Penggajian::where('user_id', $userId)
            ->where('status', 'dibayar')
            ->where('periode', 'like', "%{$tahun}%")
            ->sum('total_gaji');

        $totalGajiPending = Penggajian::where('user_id', $userId)
            ->where('status', 'belum')
            ->sum('total_gaji');

        return view('karyawan.penggajian.index', compact(
            'penggajians',
            'totalGajiDiterima',
            'totalGajiPending',
            'tahun'
        ));
    }

    /**
     * Menampilkan detail slip gaji tertentu.
     */
    public function show(Penggajian $penggajian)
    {
        // Keamanan: Pastikan data penggajian ini milik karyawan yang sedang login
        if ($penggajian->user_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses ke slip gaji ini.');
        }

        return view('karyawan.penggajian.show', compact('penggajian'));
    }

    /**
     * Mendownload file bukti pembayaran gaji.
     */
    public function downloadBukti(Penggajian $penggajian)
    {
        // Keamanan: Pastikan data milik sendiri
        if ($penggajian->user_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses ke file ini.');
        }

        // Cek apakah file bukti ada di storage
        if ($penggajian->bukti && Storage::disk('public')->exists($penggajian->bukti)) {
            return Storage::disk('public')->download($penggajian->bukti);
        }

        return redirect()->back()->with('error', 'File bukti pembayaran tidak ditemukan.');
    }
}
