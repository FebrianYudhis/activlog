<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class AdminController extends Controller
{
    public function index()
    {
        $data = [
            'judul' => "Masuk Sebagai Admin"
        ];

        return view('auth.admin', $data);
    }

    public function verifikasiLogin(Request $request)
    {
        $validated = $request->validate([
            'passkey' => 'required',
        ]);

        if ($validated['passkey'] == env('PASSKEY_ADMIN')) {
            $request->session()->put('admin', true);
            return redirect()->route('panel');
        } else {
            Alert::error('Error', 'Passkey Yang Anda Masukkan Salah !');
            return redirect()->route('admin');
        }
    }
}
