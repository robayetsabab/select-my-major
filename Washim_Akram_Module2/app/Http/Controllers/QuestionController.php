<?php

namespace App\Http\Controllers;

use App\Models\Major;
use App\Models\StudentQuestion;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function index(Request $request)
    {
        $questions = StudentQuestion::with(['user:id,name', 'major:id,name'])
            ->visibleTo($request->user())
            ->when($request->filled('q'), fn ($q) => $q->where(function ($sub) use ($request) {
                $sub->where('title', 'like', '%' . $request->q . '%')
                    ->orWhere('body', 'like', '%' . $request->q . '%');
            }))
            ->when($request->filled('type'), fn ($q) => $q->where('type', $request->type))
            ->when($request->filled('category'), fn ($q) => $q->where('category', $request->category))
            ->when($request->filled('major_id'), fn ($q) => $q->where('major_id', $request->major_id))
            ->when($request->filled('status') && $request->user()?->isAdmin(), fn ($q) => $q->where('status', $request->status))
            ->latest()
            ->paginate(8)
            ->withQueryString();

        return view('questions.index', ['questions' => $questions, 'majors' => Major::orderBy('name')->get()]);
    }

    public function create()
    {
        return view('questions.create', ['majors' => Major::orderBy('name')->get()]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'type' => ['required', 'in:question,feedback'],
            'category' => ['required', 'in:major,learning_resource,career'],
            'major_id' => ['nullable', 'exists:majors,id'],
            'title' => ['required', 'string', 'max:150'],
            'body' => ['required', 'string', 'min:10', 'max:5000'],
        ]);

        $request->user()->questions()->create($data + ['status' => 'pending']);

        return redirect()->route('questions.index')->with('success', 'Your submission has been sent to the admin for review.');
    }

    public function show(Request $request, StudentQuestion $question)
    {
        abort_unless(
            $request->user()->isAdmin() ||
            $question->status === 'published' ||
            $question->user_id === $request->user()->id,
            403
        );

        return view('questions.show', compact('question'));
    }

    public function moderate(Request $request, StudentQuestion $question)
    {
        abort_unless($request->user()->isAdmin(), 403);
        $data = $request->validate([
            'status' => ['required', 'in:published,rejected'],
            'admin_reply' => ['nullable', 'string', 'max:3000'],
        ]);
        $question->update($data);
        return back()->with('success', 'Submission moderation updated.');
    }
}
