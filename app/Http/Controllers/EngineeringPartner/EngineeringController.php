<?php

namespace App\Http\Controllers\EngineeringPartner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EngineeringController extends Controller
{
    public function profile()
    {
        $user=Auth::user();
        return view('engineering_partner.profile.index',compact('user'));
    }


}
