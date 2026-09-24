<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Shift;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;

class ShiftController extends Controller
{
    /**
     * Menampilkan daftar semua shift karyawan dengan filter.
     */
    public function index(Request $request)
    {
        $query = Shift::with('user')->latest('tanggal');

        // Filter berdasarkan karyawan
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        // Filter berdasarkan bulan
        if ($request->filled('bulan')) {
            $bulan = Carbon::parse($request->bulan);
            $query->whereYear('tanggal', $bulan->year)
                  ->whereMonth('tanggal', $bulan->month);
        }

        $shifts = $query->paginate(15)->withQueryString();
        $karyawans = User::where('role', 'karyawan')->orderBy('name')->get();

        return view('admin.shift.index', compact('shifts', 'karyawans'));
    }

    /**
     * Menampilkan form tambah shift (Single & Batch).
     */
    public function create()
    {
        $karyawans = User::where('role', 'karyawan')->orderBy('name')->get();
        return view('admin.shift.create', compact('karyawans'));
    }

    /**
     * Menyimpan 1 data shift tunggal.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id'     => 'required|exists:users,id',
            'tanggal'     => 'required|date',
            'jam_mulai'   => 'required',
            'jam_selesai' => 'required|after:jam_mulai',
        ]);

        // Cek duplikasi shift pada tanggal yang sama untuk user yang sama
        $exists = Shift::where('user_id', $request->user_id)
                       ->where('tanggal', $request->tanggal)
                       ->exists();

        if ($exists) {
            return back()->withInput()->withErrors(['tanggal' => 'Karyawan ini sudah memiliki jadwal shift pada tanggal tersebut.']);
        }

        Shift::create($validated);

        return redirect()->route('admin.shifts.index')
                         ->with('success', 'Jadwal shift berhasil ditambahkan.');
    }

    /**
     * Menyimpan shift berulang secara otomatis (Batch Generation).
     */
    public function storeBatch(Request $request)
    {
        $validated = $request->validate([
            'user_id'     => 'required|exists:users,id',
            'hari'        => 'required|array|min:1',
            'hari.*'      => 'in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday',
            'jam_mulai'   => 'required',
            'jam_selesai' => 'required',
            'start_date'  => 'required|date',
            'end_date'    => 'required|date|after_or_equal:start_date',
        ]);

        $period = CarbonPeriod::create($request->start_date, $request->end_date);
        $insertedCount = 0;
        $skippedCount = 0;

        foreach ($period as $date) {
            // Cek apakah hari pada tanggal tersebut dipilih oleh admin
            if (in_array($date->format('l'), $request->hari)) {
                $shift = Shift::firstOrCreate(
                    [
                        'user_id' => $request->user_id,
                        'tanggal' => $date->format('Y-m-d'),
                    ],
                    [
                        'jam_mulai'   => $request->jam_mulai,
                        'jam_selesai' => $request->jam_selesai,
                    ]
                );

                if ($shift->wasRecentlyCreated) {
                    $insertedCount++;
                } else {
                    $skippedCount++;
                }
            }
        }

        $message = "Berhasil membuat $insertedCount jadwal shift berulang.";
        if ($skippedCount > 0) {
            $message .= " ($skippedCount tanggal dilewati karena sudah ada jadwal).";
        }

        return redirect()->route('admin.shifts.index')->with('success', $message);
    }

    /**
     * Form edit shift.
     */
    public function edit(Shift $shift)
    {
        $karyawans = User::where('role', 'karyawan')->orderBy('name')->get();
        return view('admin.shift.edit', compact('shift', 'karyawans'));
    }

    /**
     * Update shift.
     */
    public function update(Request $request, Shift $shift)
    {
        $validated = $request->validate([
            'user_id'     => 'required|exists:users,id',
            'tanggal'     => 'required|date',
            'jam_mulai'   => 'required',
            'jam_selesai' => 'required|after:jam_mulai',
        ]);

        $shift->update($validated);

        return redirect()->route('admin.shifts.index')
                         ->with('success', 'Jadwal shift berhasil diperbarui.');
    }

    /**
     * Hapus shift.
     */
    public function destroy(Shift $shift)
    {
        $shift->delete();

        return redirect()->route('admin.shifts.index')
                         ->with('success', 'Jadwal shift berhasil dihapus.');
    }
}