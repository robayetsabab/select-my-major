<?php

namespace App\Http\Controllers;

use App\Models\Career;
use App\Models\Major;
use Illuminate\Http\Request;

class CareerController extends Controller
{
    public function index(Request $request)
    {
        $majors = Major::orderBy('sort_order')->get();
        $careers = Career::with('major')->orderBy('major_id')->orderBy('sort_order')->get();
        $industries = $careers->flatMap(fn ($career) => $career->industries ?? [])->unique()->sort()->values();
        return view('careers.index', compact('majors', 'careers', 'industries'));
    }

    public function show(Career $career)
    {
        $career->load('major');
        $relatedSlugs = array_unique(array_merge(
            $career->previous_roles ?? [], $career->next_roles ?? [], $career->related_roles ?? []
        ));
        $relatedCareers = Career::with('major')->whereIn('slug', $relatedSlugs)->get();
        return view('careers.show', compact('career', 'relatedCareers'));
    }
}
