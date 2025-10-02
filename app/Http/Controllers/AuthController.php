<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

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
    
    public function updatePassword(Request $request)
    {
        $request->validate([
            'password_lama' => 'required',
            'password_baru' => 'required|min:8|confirmed',
        ]);

        if (!Hash::check($request->password_lama, auth()->user()->password)) {
            throw ValidationException::withMessages([
                'password_lama' => ['Kata sandi lama Anda tidak cocok.'],
            ]);
        }

        auth()->user()->update([
            'password' => Hash::make($request->password_baru),
        ]);

        // PERBAIKAN: Selalu kembalikan respons JSON untuk permintaan AJAX
        if ($request->expectsJson()) {
            return response()->json(['message' => 'Kata sandi berhasil diubah!']);
        }

        return back()->with('status', 'Kata sandi berhasil diubah!');
    }
}