<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = \Auth::user();
        $page_title = 'Profile';

        return view('page.profile.edit', compact('user', 'page_title'));
    }

    public function update(Request $request)
    {
        // Ambil data user berdasarkan ID
        $user = \Auth::user();

        // Validasi input dari form
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => [
                'required',
                'string',
                'max:15',
                'unique:users,username,' . $user->id,
                'regex:/^[a-z0-9_]+$/', // hanya huruf kecil dan angka, tanpa spasi
            ],
            'email' => 'required|email|unique:users,email,' . $user->id,
            'current_password' => 'required',
            'password' => 'nullable|min:8|confirmed',
        ], [
            'username.regex' => 'Username hanya boleh berisi huruf kecil, angka, dan underscore (_).',
        ]);

        // Validasi password lama
        if (!Hash::check($request->current_password, $user->password)) {
            throw ValidationException::withMessages([
                'current_password' => 'The current password is incorrect.',
            ]);
        }

        // Update profil user
        $user->name = $request->name;
        $user->username = strtolower(str_replace(' ', '', $request->username)); // Alternative: Str::slug($request->username, '');
        $user->email = $request->email;

        // Update password jika diisi
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('profile.edit')->with('success', 'Berhasil Update Profile.');
    }

}
