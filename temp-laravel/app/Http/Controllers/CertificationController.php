<?php

namespace App\Http\Controllers;

use App\Models\Certification;
use App\Models\Major;
use Illuminate\Http\Request;

class CertificationController extends Controller
{
    public function index(Request $request)
    {
        $majors = Major::orderBy('sort_order')->get();

        $selected = $request->query('major');
        $freeOnly = $request->boolean('free');

        $query = Certification::with('major')->orderBy('major_id')->orderBy('sort_order');

        if ($selected) {
            $query->whereHas('major', function ($q) use ($selected) {
                $q->where('slug', $selected);
            });
        }

        if ($freeOnly) {
            $query->where('is_free', true);
        }

        $certifications = $query->get()->groupBy('major_id');

        return view('certifications.index', compact('majors', 'certifications', 'selected', 'freeOnly'));
    }
}
