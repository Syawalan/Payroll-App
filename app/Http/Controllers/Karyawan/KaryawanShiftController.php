<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use App\Models\Shift;
use Carbon\Carbon;
use Illuminate\Http\Request;

class KaryawanShiftController extends Controller
{
    /**
     * Menampilkan daftar jadwal shift milik karyawan yang sedang login.
     */
    public function index(Request $request)
    {
        $userId = auth()->id();
        $bulanSelected = $request->input('bulan', Carbon::now()->format('Y-m'));

        // 1. Shift Hari Ini (jika ada)
        $shiftHariIni = Shift::where('user_id', $userId)
            ->whereDate('tanggal', Carbon::today())
            ->first();

        // 2. Daftar Shift dengan Filter Bulan
        $date = Carbon::parse($bulanSelected);
        $shifts = Shift::where('user_id', $userId)
            ->whereYear('tanggal', $date->year)
            ->whereMonth('tanggal', $date->month)
            ->orderBy('tanggal', 'asc')
            ->paginate(15)
            ->withQueryString();

        return view('karyawan.shift.index', compact('shiftHariIni', 'shifts', 'bulanSelected'));
    }

    /**
     * Menampilkan detail rincian shift tertentu.
     */
    public function show($id)
    {
        $shift = Shift::where('user_id', auth()->id())->findOrFail($id);

        return view('karyawan.shift.show', compact('shift'));
    }
}