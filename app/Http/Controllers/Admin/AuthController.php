<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function form()
    {
        return Auth::check() ? redirect()->route('admin.dashboard') : view('admin.login');
    }

    public function masuk(Request $request)
    {
        $kredensial = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Hanya akun admin yang boleh masuk lewat form ini.
        if (! Auth::attempt($kredensial + ['is_admin' => true], $request->boolean('ingat'))) {
            return back()->withErrors(['email' => 'Email atau password salah.'])->onlyInput('email');
        }

        $request->session()->regenerate();

        return redirect()->intended(route('admin.dashboard'));
    }

    public function keluar(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('beranda');
    }
}
