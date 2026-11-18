<?php

namespace App\Http\Controllers;

use App\Models\Major;

class MajorController extends Controller
{
    public function index()
    {
        $majors = Major::orderBy('sort_order')->get();

        return view('majors.index', compact('majors'));
    }

    public function show(Major $major)
    {
        $others = Major::where('id', '!=', $major->id)->orderBy('sort_order')->get();
        $counts = ['certifications' => $major->certifications()->count()];

        return view('majors.show', compact('major', 'others', 'counts'));
    }
}
