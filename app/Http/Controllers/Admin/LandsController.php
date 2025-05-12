<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LandsController extends Controller
{

    public function index()
    {

        return view('admin.Lands.list');
    }
    public function add(){
        return view('admin.Lands.addLand');

    }
}
