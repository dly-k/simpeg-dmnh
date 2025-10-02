<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('dashboard');
        }

        return back()->withErrors([
            'username' => 'ID Pengguna atau Kata Sandi salah.',
        ])->onlyInput('username');
    }

public function logout(Request $request)
    {
        Auth::logout(); // Menghapus informasi otentikasi pengguna

        $request->session()->invalidate(); // Membatalkan sesi saat ini

        $request->session()->regenerateToken(); // Membuat token CSRF baru

        return redirect('/login'); // Mengarahkan pengguna kembali ke halaman login
    }
    
}