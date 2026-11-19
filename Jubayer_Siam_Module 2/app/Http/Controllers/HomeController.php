<?php

namespace App\Http\Controllers;

use App\Models\Career;
use App\Models\Major;
use App\Models\SeniorExperience;
use App\Models\Subfield;

class HomeController extends Controller
{
    public function index()
    {
        $majors = Major::orderBy('sort_order')->get();
        $stats = [
            'subfields' => Subfield::count(),
            'careers' => Career::count(),
            'stories' => SeniorExperience::published()->count(),
        ];
        return view('home', compact('majors', 'stats'));
    }
}
