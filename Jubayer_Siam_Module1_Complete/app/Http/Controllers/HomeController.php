<?php

namespace App\Http\Controllers;

use App\Models\Major;

class HomeController extends Controller
{
    public function index()
    {
        $majors = Major::orderBy('sort_order')->get();

        return view('home', compact('majors'));
    }
}
