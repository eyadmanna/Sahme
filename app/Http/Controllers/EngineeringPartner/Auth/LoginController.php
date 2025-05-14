<?php

namespace App\Http\Controllers\EngineeringPartner\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('engineering_partner.auth.login');
    }

    public function login(Request $request)
    {

        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:8',
        ]);
        $credentials = $request->only('email', 'password');
        $credentials['status_cd'] = 16; // تأكد المستخدم مفعل

        if (Auth::guard('engineering')->attempt($credentials)) {
            $request->session()->regenerate();
             return redirect()->route('engineering.dashboard');
        }

        return back()->withErrors([
            'email' => 'بيانات الدخول غير صحيحة أو لم يتم تفعيل الحساب.',
        ]);
    }


    public function logout(Request $request)
    {
        Auth::guard('engineering')->logout();
        return redirect('/engineering/login');
    }
}
