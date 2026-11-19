<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Career;
use App\Models\Major;
use App\Models\Subfield;
use Illuminate\Http\Request;

class ExploreApiController extends Controller
{
    private function perPage(Request $request): int
    {
        return min(max((int) $request->query('per_page', 100), 1), 100);
    }

    public function majors()
    {
        return response()->json([
            'data' => Major::withCount(['subfields', 'careers', 'experiences'])->orderBy('sort_order')->get(),
        ]);
    }

    public function subfields(Request $request)
    {
        $query = Subfield::with('major')
            ->filter($request->only(['q', 'major', 'difficulty', 'tool']))
            ->orderBy('major_id')->orderBy('sort_order');
        return response()->json($query->paginate($this->perPage($request)));
    }

    public function subfield(Subfield $subfield)
    {
        return response()->json(['data' => $subfield->load('major')]);
    }

    public function careers(Request $request)
    {
        $query = Career::with('major')
            ->filter($request->only(['q', 'major', 'level', 'industry']))
            ->orderBy('major_id')->orderBy('sort_order');
        return response()->json($query->paginate($this->perPage($request)));
    }

    public function career(Career $career)
    {
        return response()->json(['data' => $career->load('major')]);
    }

    public function search(Request $request)
    {
        $term = trim((string) $request->query('q', ''));
        if ($term === '') {
            return response()->json(['subfields' => [], 'careers' => []]);
        }
        return response()->json([
            'subfields' => Subfield::with('major')->filter(['q' => $term])->limit(8)->get(),
            'careers' => Career::with('major')->filter(['q' => $term])->limit(8)->get(),
        ]);
    }
}
