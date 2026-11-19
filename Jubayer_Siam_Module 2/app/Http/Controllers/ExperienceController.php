<?php

namespace App\Http\Controllers;

use App\Models\Major;
use App\Models\SeniorExperience;
use Illuminate\Http\Request;

/** Feature 8 - Senior Students' Experiences. Public to read; helpful votes need a student login. */
class ExperienceController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->only(['q', 'major', 'status', 'sort']);
        $majors = Major::orderBy('sort_order')->get();

        $experiences = SeniorExperience::published()->with(['major', 'subfield'])
            ->filter($filters)->paginate(9)->withQueryString();

        // Summary strip: what seniors say about each major (all published stories).
        $stats = SeniorExperience::published()
            ->selectRaw('major_id, COUNT(*) as total, AVG(satisfaction) as avg_satisfaction, AVG(difficulty) as avg_difficulty, SUM(would_choose_again) as choose_again')
            ->groupBy('major_id')->get()->keyBy('major_id');

        $votedIds = auth()->check()
            ? auth()->user()->experienceVotes()->pluck('senior_experiences.id')->all()
            : [];

        return view('experiences.index', compact('experiences', 'majors', 'stats', 'filters', 'votedIds'));
    }

    public function show(SeniorExperience $experience)
    {
        abort_unless($experience->is_published, 404);
        $experience->load(['major', 'subfield']);

        $more = SeniorExperience::published()->with('major')
            ->where('major_id', $experience->major_id)->where('id', '!=', $experience->id)
            ->orderByDesc('helpful_count')->take(3)->get();

        $voted = auth()->check() && $experience->voters()->where('users.id', auth()->id())->exists();
        return view('experiences.show', compact('experience', 'more', 'voted'));
    }

    public function helpful(Request $request, SeniorExperience $experience)
    {
        abort_unless($experience->is_published, 404);
        $user = $request->user();

        if ($experience->voters()->where('users.id', $user->id)->exists()) {
            $experience->voters()->detach($user->id);
            $voted = false;
        } else {
            $experience->voters()->attach($user->id);
            $voted = true;
        }
        $experience->update(['helpful_count' => $experience->voters()->count()]);

        if ($request->expectsJson()) {
            return response()->json(['voted' => $voted, 'count' => $experience->helpful_count]);
        }
        return back();
    }
}
