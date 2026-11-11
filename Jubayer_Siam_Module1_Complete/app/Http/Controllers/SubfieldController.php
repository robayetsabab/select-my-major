<?php

namespace App\Http\Controllers;

use App\Models\Major;
use App\Models\Subfield;
use Illuminate\Http\Request;

class SubfieldController extends Controller
{
    public function index(Request $request)
    {
        $majors = Major::orderBy('sort_order')->get();
        $query = Subfield::with('major')->orderBy('major_id')->orderBy('sort_order');

        if ($request->filled('q')) {
            $term = trim($request->string('q')->toString());
            $query->where(function ($builder) use ($term) {
                $builder->where('name', 'like', "%{$term}%")
                    ->orWhere('summary', 'like', "%{$term}%")
                    ->orWhere('details', 'like', "%{$term}%")
                    ->orWhere('main_focus', 'like', "%{$term}%")
                    ->orWhere('real_world_example', 'like', "%{$term}%");
            });
        }
        if ($request->filled('major')) {
            $query->whereHas('major', fn ($builder) => $builder->where('slug', $request->query('major')));
        }
        if ($request->filled('difficulty')) {
            $query->where('difficulty', $request->query('difficulty'));
        }

        $subfields = $query->paginate(12)->withQueryString();
        return view('subfields.index', compact('majors', 'subfields'));
    }

    public function show(Subfield $subfield)
    {
        $subfield->load('major');
        $siblings = Subfield::where('major_id', $subfield->major_id)
            ->where('id', '!=', $subfield->id)
            ->orderBy('sort_order')->get();

        $related = collect($subfield->related_slugs ?? [])->isNotEmpty()
            ? Subfield::whereIn('slug', $subfield->related_slugs)->get()
            : $siblings->take(3);
        $relatedCareers = $subfield->major->careers()->orderBy('sort_order')->take(3)->get();

        return view('subfields.show', compact('subfield', 'siblings', 'related', 'relatedCareers'));
    }
}
