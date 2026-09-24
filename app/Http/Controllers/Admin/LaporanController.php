<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Laporan;
use App\Models\Penggajian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class LaporanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $laporans = Laporan::latest()->paginate(10);

        return view('admin.laporan.index', compact('laporans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $periodes = Penggajian::select('periode')->distinct()->pluck('periode');

        return view('admin.laporan.create', compact('periodes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'periode' => 'required|string',
        ]);

        $periode = $request->periode;

        // 1. Ambil data penggajian sesuai periode beserta data user
        $penggajians = Penggajian::with('user')
            ->where('periode', $periode)
            ->get();

        if ($penggajians->isEmpty()) {
            return redirect()->back()->with('error', 'Tidak ada data penggajian untuk periode tersebut.');
        }

        // 2. Buat nama file unik
        $cleanPeriode = Str::slug($periode);
        $fileName = 'laporan_penggajian_' . $cleanPeriode . '_' . time() . '.csv';
        $filePath = 'laporan-export/' . $fileName;

        // 3. Generate isi file CSV
        $csvHeader = ["No", "Nama Karyawan", "Email", "Periode", "Total Volume", "Tarif", "Total Gaji", "Status"];
        
        $handle = fopen('php://temp', 'r+');
        fputcsv($handle, $csvHeader);

        foreach ($penggajians as $index => $item) {
            fputcsv($handle, [
                $index + 1,
                $item->user->name ?? 'N/A',
                $item->user->email ?? 'N/A',
                $item->periode,
                $item->total_volume,
                $item->tarif,
                $item->total_gaji,
                ucfirst($item->status),
            ]);
        }

        rewind($handle);
        $csvContent = stream_get_contents($handle);
        fclose($handle);

        // 4. Simpan file CSV ke public storage
        Storage::disk('public')->put($filePath, $csvContent);

        // 5. Simpan record riwayat laporan ke database
        Laporan::create([
            'periode'     => $periode,
            'file_export' => $filePath,
        ]);

        return redirect()->route('admin.laporan.index')
                        ->with('success', 'Laporan berhasil di-export dan disimpan.');
    }

    public function download(Laporan $laporan)
    {
        if ($laporan->file_export && Storage::disk('public')->exists($laporan->file_export)) {
            return Storage::disk('public')->download($laporan->file_export);
        }

        return redirect()->back()->with('error', 'File laporan tidak ditemukan.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Laporan $laporan)
    {
        if ($laporan->file_export && Storage::disk('public')->exists($laporan->file_export)) {
            Storage::disk('public')->delete($laporan->file_export);
        }

        // Hapus record dari database
        $laporan->delete();

        return redirect()->route('admin.laporan.index')
                        ->with('success', 'Riwayat laporan berhasil dihapus.');
    }
}
