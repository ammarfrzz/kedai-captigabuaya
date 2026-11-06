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
        if ($request->filled('current_password') || $request->filled('new_password')) {
            $request->validate([
                'current_password' => ['required', 'current_password'],
                'new_password' => ['required', 'string', 'min:8', 'confirmed'],
            ], [
                'current_password.required' => 'Password saat ini wajib diisi.',
                'current_password.current_password' => 'Password saat ini tidak sesuai.',
                'new_password.required' => 'Password baru wajib diisi.',
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
            'avatar' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:5120'],
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'name.max' => 'Nama lengkap maksimal 255 karakter.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format alamat email tidak valid.',
            'email.unique' => 'Alamat email ini sudah digunakan oleh akun lain.',
            'avatar.image' => 'File foto profil harus berupa gambar.',
            'avatar.mimes' => 'Format foto profil harus JPG, PNG, atau WEBP.',
            'avatar.max' => 'Ukuran foto profil maksimal 5 MB.',
        ]);

        if ($request->hasFile('avatar') && $request->file('avatar')->isValid()) {
            $avatarFile = $request->file('avatar');
            $filename = 'avatar_user_' . $user->id . '_' . time() . '.' . ($avatarFile->getClientOriginalExtension() ?: 'jpg');
            
            $targetDir = public_path('images/avatars');
            if (!file_exists($targetDir)) {
                @mkdir($targetDir, 0777, true);
            }
            $targetPath = $targetDir . DIRECTORY_SEPARATOR . $filename;

            // Hapus avatar lama jika ada di images/avatars
            if (!empty($user->avatar) && str_starts_with($user->avatar, 'images/avatars/')) {
                $oldPath = public_path($user->avatar);
                if (file_exists($oldPath)) {
                    @unlink($oldPath);
                }
            }

            // Copy/move file
            $realPath = $avatarFile->getRealPath();
            $saved = false;
            if ($realPath && file_exists($realPath)) {
                $saved = @copy($realPath, $targetPath);
            }
            if (!$saved && method_exists($avatarFile, 'getContent')) {
                $saved = (file_put_contents($targetPath, $avatarFile->getContent()) !== false);
            }

            if ($saved) {
                $validated['avatar'] = 'images/avatars/' . $filename;
            }
        }

        $user->update($validated);

        return redirect()->route('admin.akun')->with('success', 'Informasi profil berhasil diperbarui.');
    }
}
