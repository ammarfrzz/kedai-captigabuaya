<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AkunController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('admin.akun.index', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        // Cek apakah update profile atau update password
        if ($request->has('current_password') || $request->has('new_password')) {
            $request->validate([
                'current_password' => ['required', 'current_password'],
                'new_password' => ['required', 'string', 'min:8', 'confirmed'],
            ], [
                'current_password.current_password' => 'Password saat ini tidak sesuai.',
                'new_password.min' => 'Password baru minimal 8 karakter.',
                'new_password.confirmed' => 'Konfirmasi password baru tidak cocok.',
            ]);

            $user->update([
                'password' => Hash::make($request->new_password),
            ]);

            return redirect()->route('admin.akun')->with('success', 'Kata sandi berhasil diperbarui.');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
        ]);

        $user->update($validated);

        return redirect()->route('admin.akun')->with('success', 'Informasi profil berhasil diperbarui.');
    }
}
