<?php

namespace App\Http\Controllers\EngineeringPartner;

use App\Http\Controllers\Controller;
use App\Models\Lookups;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class LookupsController extends Controller
{
    public function get_children_by_parent(Request $request)
    {
        $obj = Lookups::query()->find($request->input("id"));
        $children = View::make('ajax.lookups_options', ["options" => $obj->children])->render();
        return response()->json([
            "children" => $children,
             ]);
    }
}
