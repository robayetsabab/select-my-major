<?php

namespace App\Http\Controllers;

use App\Models\Major;

class MajorController extends Controller
{
    // Feature 1: Major Overview & Selection
    public function index()
    {
        $majors = Major::orderBy('id')->get();
        return view('majors.index', compact('majors'));
    }

    public function show(Major $major)
    {
        $major->load('certifications');
        return view('majors.show', compact('major'));
    }
}
