<?php

namespace App\Http\Controllers\EngineeringPartner\Auth;

use App\Http\Controllers\Controller;
use App\Models\EngineeringPartner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function showRegisterForm()
    {
        return view('engineering_partner.auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'company_name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:engineering_partners',
            'mobile' => 'required|string|min:8|max:20|unique:engineering_partners,mobile',
            'password' => 'required|string|min:8|confirmed',
            'toc' => 'accepted',
        ]);

        $partner = EngineeringPartner::create([
            'company_name' => $validated['company_name'],
            'email' => $validated['email'],
            'mobile' => $validated['mobile'],
            'password' => Hash::make($validated['password']),
        ]);

        Auth::guard('engineering')->login($partner);

        return redirect()->route('engineering.dashboard');
    }
}
