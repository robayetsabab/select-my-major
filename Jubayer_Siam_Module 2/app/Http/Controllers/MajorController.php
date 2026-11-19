<?php

namespace App\Http\Controllers;

use App\Models\Major;
use App\Models\SeniorExperience;

/** Feature 1 (Robayet) - simple version so the navigation and home page links work. Replace with the team version when merging. */
class MajorController extends Controller
{
    public function index()
    {
        $majors = Major::withCount(['subfields', 'careers', 'certifications', 'experiences'])->orderBy('sort_order')->get();
        return view('majors.index', compact('majors'));
    }

    public function show(Major $major)
    {
        $major->load(['subfields' => fn ($q) => $q->orderBy('sort_order'), 'careers' => fn ($q) => $q->orderBy('sort_order')]);
        $experiences = SeniorExperience::published()->where('major_id', $major->id)->orderByDesc('helpful_count')->take(3)->get();
        return view('majors.show', compact('major', 'experiences'));
    }
}
