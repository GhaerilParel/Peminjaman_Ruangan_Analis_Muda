<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;    

class AuthController extends Controller
{
    // Register
    public function register(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => [
            'required',
            'string',
            'email',
            'max:255',
            'unique:users',
            function ($attribute, $value, $fail) {
                if (!str_ends_with($value, '@apps.ipb.ac.id')) {
                    $fail('Email harus menggunakan domain @apps.ipb.ac.id.');
                }
            },
        ],
        'password' => [
            'required',
            'string',
            'min:8',              // Minimal 8 karakter
            'regex:/[A-Z]/',      // Harus ada huruf besar
            'regex:/[a-z]/',      // Harus ada huruf kecil
            'regex:/[0-9]/',      // Harus ada angka
            'confirmed'
        ],
    ], [
        'password.regex' => 'Password harus mengandung huruf besar, huruf kecil, dan angka.',
        'password.min' => 'Minimal 8 karakter.',
    ]);

    // Simpan user ke database
    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
    ]);

    // Arahkan user ke halaman login setelah registrasi
    return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan login.');
}

    // Login untuk user biasa
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => [
                'required',
                'email',
                function ($attribute, $value, $fail) {
                    if (!str_ends_with($value, '@apps.ipb.ac.id')) {
                        $fail('Email harus menggunakan domain @apps.ipb.ac.id.');
                    }
                },
            ],
            'password' => 'required',
        ]);

        // Periksa apakah email ada di database
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return back()->withErrors(['email' => 'Email belum terdaftar!'])->withInput();
        }

        // Periksa kredensial login
        if (Auth::guard('web')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/index')->with('success', 'Login berhasil!');
        }

        return back()->withErrors(['email' => 'Email atau password salah!'])->withInput();
    }

    // Logout untuk user biasa
    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/index')->with('success', 'Logout berhasil!');
    }
}
