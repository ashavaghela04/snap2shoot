<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    // Login User
    public function login(Request $request)
    {
        
        $email = $request->email;
        $password = $request->password;
        if ($email == "admin@gmail.com" && $password == "123456") {
            Session::put('admin', true);

            return redirect('/admin/dashboard');
        }

        return back()->with('error', 'Invalid Email or Password');
    }

    // Dashboard
    public function dashboard()
    {
         if (!Session::get('admin')) {
            return redirect('/auth/login');
        }

        return view('admin.dashboard');
    }

    // Logout
    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}
