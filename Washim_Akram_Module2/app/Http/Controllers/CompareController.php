<?php

namespace App\Http\Controllers;

use App\Models\Major;
use Illuminate\Http\Request;

class CompareController extends Controller
{
    public function index(Request $request)
    {
        $majors = Major::orderBy('name')->get();
        $ids = collect($request->input('majors', []))
            ->map(fn ($id) => (int) $id)->unique()->take(4)->values();

        $selected = $ids->isEmpty()
            ? collect()
            : Major::whereIn('id', $ids)->get()->sortBy(fn ($major) => $ids->search($major->id))->values();

        return view('compare.index', compact('majors', 'selected'));
    }
}
