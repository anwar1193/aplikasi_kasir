<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    
    public function index()
    {
        return view('login.index', [
            'title' => 'App Kasir | Login Page'
        ]);
    }

    public function authenticate(Request $request)
    {
        // Validasi Form
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required|min:1'
        ]);

        // Jika user & password sesuai
        if(Auth::attempt($credentials)){
            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        }

        // Jika user & password salah
        return back()->with('loginError', 'Login failed!');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

}
