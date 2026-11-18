<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Major;
use Illuminate\Http\Request;

class MajorApiController extends Controller
{
    public function index(Request $request)
    {
        $majors = Major::query()
            ->when($request->filled('q'), fn ($q) => $q->where('name', 'like', '%' . $request->q . '%'))
            ->orderBy('name')->get();

        return response()->json(['data' => $majors]);
    }

    public function compare(Request $request)
    {
        $validated = $request->validate([
            'ids' => ['required', 'array', 'min:2', 'max:4'],
            'ids.*' => ['integer', 'distinct', 'exists:majors,id'],
        ]);

        $majors = Major::whereIn('id', $validated['ids'])->get()
            ->sortBy(fn ($major) => array_search($major->id, $validated['ids']))
            ->values();

        return response()->json(['data' => $majors]);
    }
}
