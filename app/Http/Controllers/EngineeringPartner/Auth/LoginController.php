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
 
        if (Auth::guard('engineering')->attempt($credentials)) {
            $request->session()->regenerate();


                return response()->json([
                    'status' => 'success',
                    'redirect' => route('engineering.dashboard'),
                    'message' => 'تم تسجيل الدخول بنجاح'
                ]);


         }

         $errorMessage = 'بيانات الدخول غير صحيحة أو لم يتم تفعيل الحساب.';


            return response()->json([
                'status' => 'error',
                'message' => $errorMessage
            ], 422);


    }
    public function logout(Request $request)
    {
        Auth::guard('engineering')->logout();
        return redirect('/engineering/login');
    }
}
