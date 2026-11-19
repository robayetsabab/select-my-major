<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SeniorExperience;
use Illuminate\Http\Request;

class ExperienceApiController extends Controller
{
    public function index(Request $request)
    {
        $perPage = min(max((int) $request->query('per_page', 50), 1), 100);
        $query = SeniorExperience::published()->with(['major:id,name,slug', 'subfield:id,name,slug'])
            ->filter($request->only(['q', 'major', 'status', 'sort']));
        return response()->json($query->paginate($perPage));
    }

    public function show(SeniorExperience $experience)
    {
        abort_unless($experience->is_published, 404);
        return response()->json(['data' => $experience->load(['major:id,name,slug', 'subfield:id,name,slug'])]);
    }
}
