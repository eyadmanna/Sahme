<?php

namespace App\Http\Controllers\EngineeringPartner\Auth;

use App\Http\Controllers\Controller;
use App\Models\EngineeringPartner;
use App\Models\Lookups;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function showRegisterForm()
    {
        $data["provinces"] = Lookups::query()->where([
            "s_key" => "province"
        ])->whereNot("parent_id", 0)->where("status", 1)->get();

        return view('engineering_partner.auth.register',compact('data'));
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
