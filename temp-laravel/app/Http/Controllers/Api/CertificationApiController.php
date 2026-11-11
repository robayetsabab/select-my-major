<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Certification;
use Illuminate\Http\Request;

class CertificationApiController extends Controller
{
    public function index(Request $request)
    {
        $query = Certification::with('major')->orderBy('major_id')->orderBy('sort_order');

        if ($request->filled('q')) {
            $term = trim($request->string('q')->toString());
            $query->where(fn ($builder) => $builder->where('name', 'like', "%{$term}%")
                ->orWhere('provider', 'like', "%{$term}%")
                ->orWhere('level', 'like', "%{$term}%"));
        }
        if ($request->filled('major')) {
            $query->whereHas('major', fn ($builder) => $builder->where('slug', $request->query('major')));
        }
        if ($request->query('cost') === 'free') {
            $query->where(function ($q) { $q->where('is_free', true)->orWhere('has_free_option', true); });
        } elseif ($request->query('cost') === 'paid') {
            $query->where(function ($q) { $q->where('is_free', false)->where(function ($nested) { $nested->whereNull('has_free_option')->orWhere('has_free_option', false); }); });
        }
        if ($request->filled('provider')) {
            $query->where('provider', 'like', '%' . $request->query('provider') . '%');
        }
        if ($request->filled('level')) {
            $query->where('level', 'like', '%' . $request->query('level') . '%');
        }

        $items = $query->get();

        return response()->json(['data' => $items, 'meta' => ['count' => $items->count()]]);
    }

    public function show(Certification $certification)
    {
        return response()->json(['data' => $certification->load('major')]);
    }
}
