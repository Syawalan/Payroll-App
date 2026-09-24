<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use App\Models\Borongan;
use Carbon\Carbon;
use Illuminate\Http\Request;

class KaryawanBoronganController extends Controller
{
    public function index(Request $request)
    {
        $userId = auth()->id();
        $today = Carbon::today();

        // 1. Ambil Parameter Filter & Pencarian
        $bulan = $request->input('bulan', Carbon::now()->month);
        $tahun = $request->input('tahun', Carbon::now()->year);
        $search = $request->input('search');

        // 2. Ringkasan Statistik Karyawan Ini
        $totalVolumeBulanIni = Borongan::where('user_id', $userId)
            ->whereMonth('tanggal_pengiriman', $bulan)
            ->whereYear('tanggal_pengiriman', $tahun)
            ->sum('volume');

        $totalPengirimanBulanIni = Borongan::where('user_id', $userId)
            ->whereMonth('tanggal_pengiriman', $bulan)
            ->whereYear('tanggal_pengiriman', $tahun)
            ->count();

        // 3. Query Utama Borongan
        $query = Borongan::where('user_id', $userId)
            ->whereMonth('tanggal_pengiriman', $bulan)
            ->whereYear('tanggal_pengiriman', $tahun);

        // Jika ada pencarian kata kunci (nama barang atau alamat)
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_barang', 'like', "%{$search}%")
                  ->orWhere('alamat_tujuan', 'like', "%{$search}%");
            });
        }

        $borongans = $query->orderBy('tanggal_pengiriman', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('karyawan.borongan.index', compact(
            'borongans',
            'totalVolumeBulanIni',
            'totalPengirimanBulanIni',
            'bulan',
            'tahun',
            'search'
        ));
    }

    /**
     * Menampilkan detail pekerjaan borongan tertentu.
     */
    public function show(Borongan $borongan)
    {
        // Keamanan: Cegah karyawan mengintip borongan milik karyawan lain
        if ($borongan->user_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses ke data borongan ini.');
        }

        return view('karyawan.borongan.show', compact('borongan'));
    }
}
