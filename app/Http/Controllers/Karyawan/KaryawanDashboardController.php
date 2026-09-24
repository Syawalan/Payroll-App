<?php

namespace App\Http\Controllers;

use App\Models\Borongan;
use App\Models\Penggajian;
use App\Models\Shift;
use Carbon\Carbon;
use Illuminate\Http\Request;

class KaryawanDashboardController extends Controller
{
    public function index()
    {
        $userId = auth()->id();
        $today = Carbon::today();
        $bulanIni = Carbon::now()->month;
        $tahunIni = Carbon::now()->year;

        // 1. STATISTIK KARTU UTAMA (RINGKASAN SAYA)
        
        // Total Volume Borongan Karyawan Ini Bulan Ini
        $totalVolumeBulanIni = Borongan::where('user_id', $userId)
            ->whereMonth('tanggal_pengiriman', $bulanIni)
            ->whereYear('tanggal_pengiriman', $tahunIni)
            ->sum('volume');

        // Total Gaji Belum Dibayar (Pending)
        $gajiPending = Penggajian::where('user_id', $userId)
            ->where('status', 'belum')
            ->sum('total_gaji');

        // Gaji Terakhir yang Sudah Dibayar
        $gajiTerakhirDibayar = Penggajian::where('user_id', $userId)
            ->where('status', 'dibayar')
            ->latest()
            ->first();


        // 2. JADWAL SHIFT & BORONGAN MENDATANG

        // Shift Kerja Hari Ini
        $shiftHariIni = Shift::where('user_id', $userId)
            ->whereDate('tanggal', $today)
            ->first();

        // Daftar Shift Mendatang (5 Shift Ke Depan)
        $shiftMendatang = Shift::where('user_id', $userId)
            ->whereDate('tanggal', '>=', $today)
            ->orderBy('tanggal', 'asc')
            ->take(5)
            ->get();

        // Daftar Borongan yang Harus Dikerjakan (Mulai Hari Ini dan Seterusnya)
        $boronganAkanDikerjakan = Borongan::where('user_id', $userId)
            ->whereDate('tanggal_pengiriman', '>=', $today)
            ->orderBy('tanggal_pengiriman', 'asc')
            ->take(5)
            ->get();


        // 3. RIWAYAT SLIP GAJI TERBARU

        // 3 Slip Gaji Terakhir Karyawan Ini
        $riwayatGaji = Penggajian::where('user_id', $userId)
            ->latest()
            ->take(3)
            ->get();

        return view('karyawan.dashboard', compact(
            'totalVolumeBulanIni',
            'gajiPending',
            'gajiTerakhirDibayar',
            'shiftHariIni',
            'shiftMendatang',
            'boronganAkanDikerjakan',
            'riwayatGaji'
        ));
    }
}