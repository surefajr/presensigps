<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use App\Models\Guru;


class AuthController extends Controller
{
    public function proseslogin(Request $request)
    {
        $username = $request->username;
        $password = $request->password;
    
        // Ambil data guru berdasarkan username
        $guru = Guru::where('username', $username)->first();
    
        // Verifikasi password
        if ($guru && Hash::check($password, $guru->password)) {
            // Jika password cocok, autentikasi berhasil
            Auth::guard('guru')->login($guru);
            return redirect('/dashboard');
        } else {
            // Jika password tidak cocok atau Username tidak ditemukan
            return redirect('/')->with(['warning' => 'Username atau Password Salah']);
        }
    }


    public function proseslogout()
    {
        if (Auth::guard('guru')->check()) {
            Auth::guard('guru')->logout();
            return redirect('/');
        }
    }

    public function proseslogoutadmin()
    {
        if (Auth::guard('user')->check()) {
            Auth::guard('user')->logout();
            return redirect('/panel');
        }
    }

    public function prosesloginadmin(Request $request)
    {
        $credentials = ['email' => $request->email, 'password' => $request->password];

        if (Auth::guard('user')->attempt($credentials)) {
            return redirect('/panel/dashboardadmin');
        } else {
            return redirect('/panel')->with(['warning' => 'Email atau Password Salah']);
        }
    }

}
