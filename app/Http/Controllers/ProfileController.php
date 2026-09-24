<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function edit()
    {
        $admin = User::where('role', 'admin')->get();
        $karyawan = User::where('role', 'karyawan')->get();

        $role = Auth::user()->role;

        if ($role === 'admin') {
            return view('admin.profile.index', compact('admin'));
        } elseif ($role === 'karyawan') {
            return view('karyawan.profile.index', compact('karyawan'));
        }
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
            ],
            'password' => 'nullable|min:8|confirmed'
        ]);

        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->back()->with('success', 'Profil berhasil diperbarui!');
    }
}
