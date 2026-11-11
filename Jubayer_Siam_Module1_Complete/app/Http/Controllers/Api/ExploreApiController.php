<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Career;
use App\Models\Major;
use App\Models\Subfield;
use Illuminate\Http\Request;

class ExploreApiController extends Controller
{
    public function majors()
    {
        return response()->json([
            'data' => Major::withCount(['subfields', 'careers'])->orderBy('sort_order')->get(),
        ]);
    }

    public function subfields(Request $request)
    {
        $query = Subfield::with('major')->orderBy('major_id')->orderBy('sort_order');
        if ($request->filled('q')) {
            $term = trim($request->string('q')->toString());
            $query->where(function ($builder) use ($term) {
                $builder->where('name', 'like', "%{$term}%")
                    ->orWhere('summary', 'like', "%{$term}%")
                    ->orWhere('details', 'like', "%{$term}%")
                    ->orWhere('main_focus', 'like', "%{$term}%")
                    ->orWhere('real_world_example', 'like', "%{$term}%")
                    ->orWhere('tools', 'like', "%{$term}%");
            });
        }
        if ($request->filled('major')) {
            $query->whereHas('major', fn ($builder) => $builder->where('slug', $request->query('major')));
        }
        if ($request->filled('difficulty')) $query->where('difficulty', $request->query('difficulty'));
        if ($request->filled('tool')) $query->where('tools', 'like', '%' . $request->query('tool') . '%');

        return response()->json($query->paginate(min(max((int) $request->query('per_page', 100), 1), 100)));
    }

    public function subfield(Subfield $subfield)
    {
        return response()->json(['data' => $subfield->load('major')]);
    }

    public function careers(Request $request)
    {
        $query = Career::with('major')->orderBy('major_id')->orderBy('sort_order');
        if ($request->filled('q')) {
            $term = trim($request->string('q')->toString());
            $query->where(function ($builder) use ($term) {
                $builder->where('title', 'like', "%{$term}%")
                    ->orWhere('description', 'like', "%{$term}%")
                    ->orWhere('opportunities', 'like', "%{$term}%");
            });
        }
        if ($request->filled('major')) {
            $query->whereHas('major', fn ($builder) => $builder->where('slug', $request->query('major')));
        }
        if ($request->filled('level')) $query->where('level', $request->query('level'));
        if ($request->filled('industry')) $query->whereJsonContains('industries', $request->query('industry'));

        return response()->json($query->paginate(min(max((int) $request->query('per_page', 100), 1), 100)));
    }

    public function career(Career $career)
    {
        $career->load('major');
        return response()->json(['data' => $career]);
    }

    public function search(Request $request)
    {
        $term = trim($request->query('q', ''));
        if ($term === '') return response()->json(['subfields' => [], 'careers' => []]);

        $subfields = Subfield::with('major')
            ->where(fn ($q) => $q->where('name', 'like', "%{$term}%")
                ->orWhere('summary', 'like', "%{$term}%")
                ->orWhere('details', 'like', "%{$term}%"))
            ->limit(8)->get();
        $careers = Career::with('major')
            ->where(fn ($q) => $q->where('title', 'like', "%{$term}%")
                ->orWhere('description', 'like', "%{$term}%")
                ->orWhere('opportunities', 'like', "%{$term}%"))
            ->limit(8)->get();
        return response()->json(['subfields' => $subfields, 'careers' => $careers]);
    }
}
