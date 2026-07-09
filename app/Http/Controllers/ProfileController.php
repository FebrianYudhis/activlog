<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function passwordForm()
    {
        $data = [
            'judul' => 'Ganti Password'
        ];

        // Ensure we load the correct layout depending on if the user is an admin or not, 
        // actually we can just use main layout for users and if admin they can access it from panel.
        // Let's pass a variable or just use main layout for everyone to keep it simple, or check role.
        $layout = Auth::user()->role === 'admin' && request()->is('panel/*') ? 'layouts.panel' : 'layouts.main';
        $data['layout'] = $layout;

        return view('profile.password', $data);
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'min:8', 'confirmed'],
        ], [
            'current_password.required' => 'Password saat ini wajib diisi.',
            'current_password.current_password' => 'Password saat ini tidak sesuai.',
            'password.required' => 'Password baru wajib diisi.',
            'password.min' => 'Password baru minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password baru tidak cocok.',
        ]);

        $user = Auth::user();
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->back()->with('success', 'Password berhasil diubah!');
    }
}
