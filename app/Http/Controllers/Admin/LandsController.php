<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Investors;
use Illuminate\Http\Request;

class LandsController extends Controller
{

    public function index()
    {

        return view('admin.Lands.list');
    }
    public function add(){
        $data['investors'] = Investors::query()->get();
        return view('admin.Lands.addLand',$data);

    }
}
