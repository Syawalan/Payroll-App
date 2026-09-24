<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Borongan;
use App\Models\Penggajian;
use App\Models\Shift;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bulanIni = Carbon::now()->month;
        $tahunIni = Carbon::now()->year;

        // 1. STATISTIK KARTU UTAMA (KPI Cards)
        
        // Total Karyawan Aktif
        $totalKaryawan = User::where('role', 'karyawan')->count();

        // Total Volume Material Terkirim Bulan Ini
        $totalVolumeBulanIni = Borongan::whereMonth('tanggal_pengiriman', $bulanIni)
            ->whereYear('tanggal_pengiriman', $tahunIni)
            ->sum('volume');

        // Total Nominal Gaji yang Belum Dibayar (Pending)
        $totalGajiPending = Penggajian::where('status', 'belum')->sum('total_gaji');
        $jumlahPendingCount = Penggajian::where('status', 'belum')->count();

        // Total Gaji yang Sudah Dibayar Bulan Ini
        $totalGajiTelahDibayar = Penggajian::where('status', 'dibayar')
            ->whereMonth('created_at', $bulanIni)
            ->whereYear('created_at', $tahunIni)
            ->sum('total_gaji');


        // 2. TABEL RINGKASAN / RECENT ACTIVITIES

        // 5 Pengiriman Borongan Terbaru
        $boronganTerbaru = Borongan::with('user')
            ->latest('tanggal_pengiriman')
            ->take(5)
            ->get();

        // Daftar Gaji Karyawan yang Belum Dibayar (Perlu Tindakan)
        $penggajianPending = Penggajian::with('user')
            ->where('status', 'belum')
            ->latest()
            ->take(5)
            ->get();

        // Shift Kerja Hari Ini
        $shiftHariIni = Shift::with('user')
            ->whereDate('tanggal', Carbon::today())
            ->orderBy('jam_mulai', 'asc')
            ->get();


        // 3. CHART / GRAFIK DATA (Performa Karyawan & Tren Borongan)

        // Top 5 Karyawan dengan Volume Borongan Tertinggi Bulan Ini
        $topKaryawan = Borongan::selectRaw('user_id, SUM(volume) as total_vol')
            ->whereMonth('tanggal_pengiriman', $bulanIni)
            ->whereYear('tanggal_pengiriman', $tahunIni)
            ->groupBy('user_id')
            ->orderByDesc('total_vol')
            ->with('user')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalKaryawan',
            'totalVolumeBulanIni',
            'totalGajiPending',
            'jumlahPendingCount',
            'totalGajiTelahDibayar',
            'boronganTerbaru',
            'penggajianPending',
            'shiftHariIni',
            'topKaryawan'
        ));
    }
}
