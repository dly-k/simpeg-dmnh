<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $users = User::with('pegawai')
            ->when($search, function ($query, $search) {
                $query->where('username', 'like', '%'.$search.'%')
                    ->orWhereHas('pegawai', function($q) use ($search) {
                        $q->where('nama_lengkap', 'like', '%'.$search.'%');
                    });
            })
            ->paginate(10);

        // Hanya pegawai yang belum punya akun
        $pegawais = Pegawai::whereDoesntHave('user')->get(); 

        return view('auth.master-data', compact('users', 'pegawais'));
    }

    /**
     * Menyimpan pengguna baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'pegawai_id' => 'required|exists:pegawais,id|unique:users,pegawai_id',
            'username' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:8',
            // PERBAIKAN: Tambahkan 'dosen' ke dalam validasi
            'role' => 'required|in:admin,admin_verifikator,tata_usaha,dosen', 
        ]);

        User::create([
            'pegawai_id' => $request->pegawai_id,
            'username' => $request->username,
            // Pastikan password di-hash jika Model User belum menggunakan casts hashed
            'password' => Hash::make($request->password), 
            'role' => $request->role,
        ]);

        return redirect()->route('master-data.index')->with('success', 'Pengguna baru berhasil ditambahkan.');
    }

    /**
     * Memperbarui data pengguna yang ada.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'username' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($user->id)],
            // PERBAIKAN: Tambahkan 'dosen' ke dalam validasi
            'role' => 'required|in:admin,admin_verifikator,tata_usaha,dosen', 
            'password' => 'nullable|string|min:8', 
        ]);

        $user->username = $request->username;
        $user->role = $request->role;
        
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        
        $user->save();

        return redirect()->route('master-data.index')->with('success', 'Data pengguna berhasil diperbarui.');
    }

    /**
     * Menghapus pengguna dari database.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('master-data.index')->with('success', 'Pengguna berhasil dihapus.');
    }
}