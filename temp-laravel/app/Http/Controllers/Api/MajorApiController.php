<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Major;
use Illuminate\Http\Request;

class MajorApiController extends Controller
{
    public function index(Request $request)
    {
        $query = Major::query()->withCount('certifications')->orderBy('id');

        if ($request->filled('q')) {
            $term = trim($request->string('q')->toString());
            $query->where(fn ($builder) => $builder->where('name', 'like', "%{$term}%")
                ->orWhere('tagline', 'like', "%{$term}%")
                ->orWhere('overview', 'like', "%{$term}%"));
        }

        $items = $query->get();

        return response()->json(['data' => $items, 'meta' => ['count' => $items->count()]]);
    }

    public function show(Major $major)
    {
        return response()->json(['data' => $major->load('certifications')]);
    }

    public function compare(Request $request)
    {
        $ids = collect(explode(',', (string) $request->query('ids')))
            ->map(fn ($id) => (int) trim($id))->filter()->unique()->take(4);

        if ($ids->count() < 2) {
            return response()->json(['message' => 'Provide at least two major IDs in the ids query parameter.'], 422);
        }

        $items = Major::whereIn('id', $ids)->orderBy('id')->get();

        return response()->json(['data' => $items, 'meta' => ['count' => $items->count()]]);
    }
}
