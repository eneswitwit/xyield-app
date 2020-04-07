<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ListingsController extends Controller
{
    public function index(Request $request)
    {
        return view('listings');
    }
}
