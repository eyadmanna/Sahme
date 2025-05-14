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
            "master_key" => "province"
        ])->whereNot("parent_id", 0)->where("status", 1)->get();

        return view('engineering_partner.auth.register',compact('data'));
    }

    public function register(Request $request)
    {
         $request->validate([
            'company_name' => 'required|string|max:255',
            'mobile' => 'required|string|max:15',
            'province_cd' => 'required',
            'city_cd' => 'required',
            'district_cd' => 'required',
            'address' => 'required|string|max:255',
            'experience_years' => 'required|integer|min:0',
            'commercial_registration_number' => 'required|string|max:255',
            'specializations' => 'required|string|max:255',
            'tax_number' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'logo' => 'required|file|mimes:jpeg,jpg,png,pdf|max:10240',
            'company_profile' => 'required|file|mimes:jpeg,jpg,png,pdf|max:10240',
            'commercial_registration' => 'required|file|mimes:jpeg,jpg,png,pdf|max:10240',
            'liecence' => 'required|file|mimes:jpeg,jpg,png,pdf|max:10240',
            'tax_record' => 'required|file|mimes:jpeg,jpg,png,pdf|max:10240',
            'previous_projects' => 'required|file|mimes:jpeg,jpg,png,pdf|max:10240',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $uploadFields = [
            'logo' => 'logo',
            'company_profile' => 'company',
            'commercial_registration' => 'commercial',
            'liecence' => 'liecence',
            'tax_record' => 'tax',
            'previous_projects' => 'projects',
        ];

        $paths = [];

        foreach ($uploadFields as $field => $prefix) {
            if ($request->hasFile($field)) {
                $file = $request->file($field);
                $fileName = time() . '_' . $prefix . '.' . $file->getClientOriginalExtension();
                $file->move(public_path("uploads/{$field}"), $fileName);
                $paths[$field] = "uploads/{$field}/" . $fileName;
            }
        }

        $partner = EngineeringPartner::create([
            'company_name' => $request->company_name,
            'mobile' => $request->mobile,
            'province_cd' => $request->province_cd,
            'city_cd' => $request->city_cd,
            'district_cd' => $request->district_cd,
            'address' => $request->address,
            'experience_years' => $request->experience_years,
            'commercial_registration_number' => $request->commercial_registration_number,
            'specializations' => $request->specializations,
            'tax_number' => $request->tax_number,
            'email' => $request->email,
            'logo' => $paths['logo'] ?? null,
            'company_profile' => $paths['company_profile'] ?? null,
            'commercial_registration' => $paths['commercial_registration'] ?? null,
            'liecence' => $paths['liecence'] ?? null,
            'tax_record' => $paths['tax_record'] ?? null,
            'previous_projects' => $paths['previous_projects'] ?? null,
             'password' => Hash::make($request->password),
        ]);
        Auth::guard('engineering')->login($partner);
         return redirect()->route('engineering.dashboard')->with('success', 'تم التسجيل بنجاح!');
    }
}
