<?php

namespace App\Http\Controllers;

use App\Models\Certification;
use App\Models\Major;
use Illuminate\Http\Request;

class CertificationController extends Controller
{
    // Feature 4: Certifications & Learning Resources (with filters)
    public function index(Request $request)
    {
        $query = Certification::with('major');

        if ($request->filled('major')) {
            $query->where('major_id', $request->major);
        }
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }
        if ($request->boolean('free')) {
            $query->where(function ($q) {
                $q->where('has_free_option', true)->orWhere('price_usd', 0);
            });
        }
        if ($request->filled('q')) {
            $query->where('name', 'like', '%' . $request->q . '%');
        }

        $certifications = $query->orderBy('major_id')->orderBy('name')->get();
        $majors = Major::orderBy('id')->get();

        return view('certifications.index', compact('certifications', 'majors'));
    }
}
