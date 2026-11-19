<?php

namespace App\Http\Controllers;

use App\Models\Major;
use App\Models\SeniorExperience;
use App\Models\Subfield;
use Illuminate\Http\Request;

class SubfieldController extends Controller
{
    public function index(Request $request)
    {
        $majors = Major::orderBy('sort_order')->get();
        $subfields = Subfield::with('major')
            ->filter($request->only(['q', 'major', 'difficulty']))
            ->orderBy('major_id')->orderBy('sort_order')
            ->paginate(12)->withQueryString();
        $totalSubfields = Subfield::count();

        return view('subfields.index', compact('majors', 'subfields', 'totalSubfields'));
    }

    public function show(Subfield $subfield)
    {
        $subfield->load('major');
        $siblings = Subfield::where('major_id', $subfield->major_id)
            ->where('id', '!=', $subfield->id)->orderBy('sort_order')->get();

        $related = collect($subfield->related_slugs ?? [])->isNotEmpty()
            ? Subfield::whereIn('slug', $subfield->related_slugs)->get()
            : $siblings->take(3);
        $relatedCareers = $subfield->major->careers()->orderBy('sort_order')->take(3)->get();

        // Senior students who studied/are studying this area (falls back to the same major).
        $experiences = SeniorExperience::published()->with('major')
            ->where('subfield_id', $subfield->id)->take(2)->get();
        if ($experiences->isEmpty()) {
            $experiences = SeniorExperience::published()->with('major')
                ->where('major_id', $subfield->major_id)->orderByDesc('helpful_count')->take(2)->get();
        }

        return view('subfields.show', compact('subfield', 'siblings', 'related', 'relatedCareers', 'experiences'));
    }
}
