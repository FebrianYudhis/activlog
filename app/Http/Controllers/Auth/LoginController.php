<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/app';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    public function username()
    {
        return 'username';
    }

    public function showLoginForm()
    {
        $data = ['judul' => 'Login'];

        return view('auth.login', $data);
    }

    protected function loggedOut(Request $request)
    {
        Alert::success('Berhasil', 'Anda Berhasil Keluar !');
        return redirect()->route('login');
    }

    protected function authenticated(Request $request, $user)
    {
        Alert::success('Berhasil', 'Anda Berhasil Masuk Sebagai ' . $user->name);
        return redirect()->route('app');
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        Alert::error('Gagal', 'Username atau Password Anda Salah !');
        return redirect()->route('login');
    }
}
