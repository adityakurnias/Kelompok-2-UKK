<?php
// app/Http/Controllers/ProfileController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Menampilkan halaman profil
     */
    public function index()
    {
        $user = Auth::user();
        return view('profile.index', compact('user'));
    }
    
    /**
     * Menampilkan form edit profil
     */
    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }
    
    /**
     * Update data profil
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
        ]);
        
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);
        
        return redirect()->route('profile')
            ->with('success', 'Profil berhasil diperbarui');
    }
    
    /**
     * Update foto profil
     */
    public function updatePhoto(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);
        
        $user = Auth::user();
        
        // Hapus foto lama jika ada
        if ($user->photo) {
            Storage::delete('public/users/' . $user->photo);
        }
        
        // Upload foto baru
        $photoName = time() . '.' . $request->photo->extension();
        $request->photo->storeAs('public/users', $photoName);
        
        $user->update(['photo' => $photoName]);
        
        return redirect()->route('profile')
            ->with('success', 'Foto profil berhasil diperbarui');
    }
    
    /**
     * Ganti password
     */
    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed',
        ]);
        
        $user = Auth::user();
        
        // Cek password lama
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->with('error', 'Password saat ini salah');
        }
        
        // Update password baru
        $user->update([
            'password' => Hash::make($request->new_password)
        ]);
        
        return redirect()->route('profile')
            ->with('success', 'Password berhasil diubah');
    }
}