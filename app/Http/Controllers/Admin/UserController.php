<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        $karyawans = User::where('role', 'karyawan')
            ->latest()
            ->paginate(10);

        return view('admin.karyawan.index', compact('karyawans'));
    }

    /**
     * Menampilkan form buat akun karyawan baru.
     */
    public function create()
    {
        return view('admin.karyawan.create');
    }

    /**
     * Menyimpan akun karyawan baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Otomatis set role menjadi 'karyawan' dan hash password
        $validated['role'] = 'karyawan';
        $validated['password'] = Hash::make($request->password);

        User::create($validated);

        return redirect()->route('admin.karyawan.index')
                        ->with('success', 'Akun karyawan berhasil dibuat.');
    }

    public function show(User $karyawan)
    {
        // Load relasi profile, borongans, shifts, dan penggajians
        $karyawan->load(['profile', 'borongans', 'shifts', 'penggajians']);

        return view('admin.karyawan.show', compact('karyawan'));
    }

    /**
     * Menampilkan form edit data/akun karyawan.
     */
    public function edit(User $karyawan)
    {
        return view('admin.karyawan.edit', compact('karyawan'));
    }

    /**
     * Memperbarui data/akun karyawan.
     */
    public function update(Request $request, User $karyawan)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => ['required', 'email', Rule::unique('users')->ignore($karyawan->id)],
            'password' => 'nullable|string|min:8|confirmed', // Isi jika ingin mereset password karyawan
        ]);

        $data = [
            'name'  => $request->name,
            'email' => $request->email,
        ];

        // Jika admin mengisi password baru untuk karyawan
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $karyawan->update($data);

        return redirect()->route('admin.karyawan.index')
                         ->with('success', 'Data akun karyawan berhasil diperbarui.');
    }

    /**
     * Menghapus akun karyawan.
     */
    public function destroy(User $karyawan)
    {
        // Berada pada onDelete('cascade') di migration, maka borongan/shift/penggajian terkait akan otomatis terhapus
        $karyawan->delete();

        return redirect()->route('admin.karyawan.index')
                         ->with('success', 'Akun karyawan berhasil dihapus.');
    }
}
