<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SpaController extends Controller
{
    public function index(Request $request)
    {
        info($request->ajax());
        return view('welcome');
    }
}
