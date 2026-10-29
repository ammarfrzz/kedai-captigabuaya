<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        // ── RATE LIMITER: maks 5 percobaan per menit per IP+username ──
        $throttleKey = Str::lower($request->input('username')) . '|' . $request->ip();

        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            throw ValidationException::withMessages([
                'username' => "Terlalu banyak percobaan login. Coba lagi dalam {$seconds} detik.",
            ]);
        }

        $username = $request->input('username');
        $loginField = filter_var($username, FILTER_VALIDATE_EMAIL) ? 'email' : 'name';

        $attemptData = [
            $loginField => $username,
            'password'  => $request->input('password'),
        ];

        if (Auth::attempt($attemptData, $request->boolean('remember', false))) {
            RateLimiter::clear($throttleKey);
            $request->session()->regenerate();
            return redirect()->intended(route('admin.dashboard'))
                ->with('success', 'Selamat datang kembali, Admin!');
        }

        RateLimiter::hit($throttleKey, 60); // decay 60 detik

        throw ValidationException::withMessages([
            'username' => 'Email/Username atau kata sandi yang Anda masukkan salah.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login')->with('success', 'Anda telah berhasil keluar.');
    }
}
