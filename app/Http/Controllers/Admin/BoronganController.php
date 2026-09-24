<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Borongan;
use App\Models\User;
use Illuminate\Http\Request;

class BoronganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $borongans = Borongan::with('user')->latest()->paginate(10);

        return view('admin.borongan.index', compact('borongans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::all();

        return view('admin.borongan.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_barang'        => 'required|string|max:255',
            'satuan'             => 'required|string|max:50',
            'volume'             => 'required|integer|min:1',
            'alamat_tujuan'      => 'required|string|max:255',
            'tanggal_pengiriman' => 'required|date',
            'user_id'            => 'nullable|exists:users,id',
        ]);

        // Jika user_id tidak dipilih/dikirim dari form, gunakan ID user yang sedang login
        $validated['user_id'] = $request->user_id ?? auth()->id();

        Borongan::create($validated);

        return redirect()->route('admin.borongan.index')
                        ->with('success', 'Data borongan berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Borongan $borongan)
    {
        $borongan->load('user');

        return view('admin.borongan.show', compact('borongan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Borongan $borongan)
    {
        $users = User::all();

        return view('admin.borongan.edit', compact('borongan', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Borongan $borongan)
    {
        $validated = $request->validate([
            'nama_barang'        => 'required|string|max:255',
            'satuan'             => 'required|string|max:50',
            'volume'             => 'required|integer|min:1',
            'alamat_tujuan'      => 'required|string|max:255',
            'tanggal_pengiriman' => 'required|date',
            'user_id'            => 'nullable|exists:users,id',
        ]);

        // Jika user_id tidak dikirim, pertahankan user_id yang lama
        $validated['user_id'] = $request->user_id ?? $borongan->user_id;

        $borongan->update($validated);

        return redirect()->route('admin.borongan.index')
                        ->with('success', 'Data borongan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Borongan $borongan)
    {
        $borongan->delete();

        return redirect()->route('admin.borongan.index')
                        ->with('success', 'Data borongan berhasil dihapus.');
    }
}
