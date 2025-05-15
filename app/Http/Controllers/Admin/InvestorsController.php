<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Investors;
use Illuminate\Http\Request;

class InvestorsController extends Controller
{
    //
    public function getInvestorDetails(Request $request)
    {
        $investor = Investors::find($request->id);
        if (!$investor) {
            return response()->json('Investor not found', 404);
        }
        return view('admin.Lands.ajax.investor_details', compact('investor'))->render();
    }
}
