<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Penggajian;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PenggajianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $penggajians = Penggajian::with('user')->latest()->paginate(10);

        return view('admin.penggajian.index', compact('penggajians'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::all();

        return view('admin.penggajian.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id'      => 'required|exists:users,id',
            'periode'      => 'required|string|max:100', // Contoh: "Januari 2026" atau "2026-01"
            'total_volume' => 'required|integer|min:0',
            'tarif'        => 'required|numeric|min:0',
            'status'       => 'required|in:dibayar,belum',
            'bukti'        => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $validated['total_gaji'] = $validated['total_volume'] * $validated['tarif'];

        if ($request->hasFile('bukti')) {
            $validated['bukti'] = $request->file('bukti')->store('bukti_penggajian', 'public');
        }

        Penggajian::create($validated);

        return redirect()->route('admin.penggajian.index')->with('success', 'Data penggajian berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Penggajian $penggajian)
    {
        $penggajian->load('user');

        return view('admin.penggajian.show', compact('penggajian'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Penggajian $penggajian)
    {
        $users = User::all();

        return view('admin.penggajian.edit', compact('penggajian', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Penggajian $penggajian)
    {
        $validated = $request->validate([
            'user_id'      => 'required|exists:users,id',
            'periode'      => 'required|string|max:100',
            'total_volume' => 'required|integer|min:0',
            'tarif'        => 'required|numeric|min:0',
            'status'       => 'required|in:dibayar,belum',
            'bukti'        => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $validated['total_gaji'] = $validated['total_volume'] * $validated['tarif'];

        if ($request->hasFile('bukti')) {
            // Hapus file lama jika ada
            if ($penggajian->bukti && Storage::disk('public')->exists($penggajian->bukti)) {
                Storage::disk('public')->delete($penggajian->bukti);
            }

            // Simpan file baru
            $validated['bukti'] = $request->file('bukti')->store('bukti-penggajian', 'public');
        }

        $penggajian->update($validated);

        return redirect()->route('admin.penggajian.index')
                        ->with('success', 'Data penggajian berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Penggajian $penggajian)
    {
        if ($penggajian->bukti && Storage::disk('public')->exists($penggajian->bukti)) {
            Storage::disk('public')->delete($penggajian->bukti);
        }

        $penggajian->delete();

        return redirect()->route('admin.penggajian.index')
                        ->with('success', 'Data penggajian berhasil dihapus.');
    }
}
