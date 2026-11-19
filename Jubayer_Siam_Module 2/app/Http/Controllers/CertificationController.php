<?php

namespace App\Http\Controllers;

use App\Models\Major;

/** Feature 4 (Robayet) - simple version so the navigation link works. Replace with the team version when merging. */
class CertificationController extends Controller
{
    public function index()
    {
        $majors = Major::with(['certifications' => fn ($q) => $q->orderBy('sort_order')])->orderBy('sort_order')->get();
        return view('certifications.index', compact('majors'));
    }
}
