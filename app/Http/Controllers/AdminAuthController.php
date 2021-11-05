<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    public function login()
    {
        if(auth()->guard('admin')->check()){
            return redirect()->intended(route('admin.dashboard.index'));
        }

        return view('admin.login');
    }

    public function login_check(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required','alpha_dash'],
            'password' => ['required'],
        ]);

        if (Auth::guard('admin')->attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended(route('admin.dashboard.index'));
        }

        flash('Invalid credentials!')->error();
        return redirect()->back();
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
