<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    // Menampilkan halaman profil
    public function index()
    {
        $user = Auth::user();
        return view('backend.admin.profile.index', compact('user'));
    }

    // 🔥 Perbaikan: method harus bernama "update" agar match dengan route PATCH /profile
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'no_hp' => 'required|numeric|min:10',
            'email' => 'required|email',
            'username' => 'required',
            'name' => 'required'
        ], [
            'no_hp.required' => 'No HP tidak boleh kosong',
            'no_hp.numeric' => 'No HP harus berupa angka',
            'no_hp.min' => 'No HP harus lebih dari 10 digit',
        ]);

        if ($validator->fails()) {
            // Mengarahkan ke form dengan error dan menjaga tab aktif
            return redirect()->back()->withErrors($validator)
                                     ->withInput()
                                     ->with('activeTab', 'profile-edit'); // Menyimpan tab yang aktif
        }

        $user = Auth::user();
        $user->no_hp = $request->no_hp;
        $user->email = $request->email;
        $user->username = $request->username;
        $user->name = $request->name;

        // Jika ada foto profil dari Cloudinary
        if ($request->profile_photo) {
            $user->profile_photo = $request->profile_photo;
        }

        $user->save();

        // Setelah sukses, arahkan ke halaman profile dan tetapkan tab aktif
        return redirect()->route('profile.index')
                         ->with('success', 'Profil berhasil diperbarui')
                         ->with('activeTab', 'profile-edit');
    }

    // Form ganti password (jika ingin halaman khusus)
    public function changePasswordForm()
    {
        return view('backend.admin.profile.change-password');
    }

    // Proses update password
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required'],
            'new_password' => ['required', 'min:8', 'confirmed'],
        ]);

        $user = Auth::user();

        // Cek password lama
        if (!Hash::check($request->current_password, $user->password)) {
            // Jika password lama salah, tetapkan tab password
            return redirect()->back()->withErrors(['current_password' => 'Password lama salah'])
                                     ->with('activeTab', 'profile-change-password');
        }

        // Update password baru
        $user->password = Hash::make($request->new_password);
        $user->save();

        // Setelah sukses, arahkan kembali dan tetapkan tab password
        return redirect()->back()
                         ->with('success', 'Password berhasil diubah')
                         ->with('activeTab', 'profile-change-password');
    }
}
