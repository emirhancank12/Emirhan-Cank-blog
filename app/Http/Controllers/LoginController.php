<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function index()
    {
        return view('login');
    }

    public function giris(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string'
        ]);

        $admin = (
            $request->username === config('blog.admin_username') &&
            $request->password === config('blog.admin_password')
        );

        $kullanici = (
            $request->username === config('blog.username') &&
            $request->password === config('blog.password')
        );

        if ($admin || $kullanici) {
            $request->session()->regenerate();

            session([
                'giris' => true,
                'admin' => $admin,
                'kullanici' => $request->username
            ]);

            return redirect('/blog');
        }

        return back()->with('hata', 'Kullanıcı adı veya şifre yanlış!');
    }

    public function cikis(Request $request)
    {
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
