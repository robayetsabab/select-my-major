<?php

namespace App\Http\Controllers;

use App\Models\Career;
use App\Models\Major;

class CareerController extends Controller
{
    public function index()
    {
        $majors = Major::orderBy('sort_order')->get();
        $careers = Career::with('major')->orderBy('major_id')->orderBy('sort_order')->get();
        $industries = $careers->flatMap(fn ($career) => $career->industries ?? [])->unique()->sort()->values();
        return view('careers.index', compact('majors', 'careers', 'industries'));
    }

    public function show(Career $career)
    {
        $career->load('major');

        // Load every linked role once; a missing slug no longer crashes the page (it is simply skipped).
        $slugs = array_unique(array_merge(
            $career->previous_roles ?? [], $career->next_roles ?? [], $career->related_roles ?? []
        ));
        $linked = Career::with('major')->whereIn('slug', $slugs)->get()->keyBy('slug');

        $previousRoles = collect($career->previous_roles ?? [])->map(fn ($s) => $linked->get($s))->filter()->values();
        $nextRoles = collect($career->next_roles ?? [])->map(fn ($s) => $linked->get($s))->filter()->values();
        $relatedCareers = $linked->values();

        return view('careers.show', compact('career', 'previousRoles', 'nextRoles', 'relatedCareers'));
    }
}
