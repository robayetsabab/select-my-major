<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\StudentQuestion;
use Illuminate\Http\Request;

class QuestionApiController extends Controller
{
    public function index(Request $request)
    {
        $perPage = min(
            max($request->integer('per_page', 10), 1),
            100
        );

        $items = StudentQuestion::with(['user:id,name', 'major:id,name'])
            ->visibleTo($request->user())
            ->when($request->filled('q'), fn ($q) => $q->where(fn ($s) =>
                $s->where('title', 'like', '%' . $request->q . '%')
                  ->orWhere('body', 'like', '%' . $request->q . '%')))
            ->when($request->filled('type'), fn ($q) => $q->where('type', $request->type))
            ->when($request->filled('category'), fn ($q) => $q->where('category', $request->category))
            ->when($request->filled('major_id'), fn ($q) => $q->where('major_id', $request->major_id))
            ->when($request->filled('status') && $request->user()->isAdmin(), fn ($q) => $q->where('status', $request->status))
            ->latest()
            ->paginate($perPage);

        return response()->json($items);
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

        $item = $request->user()->questions()->create(
            $data + ['status' => 'pending']
        );

        return response()->json([
            'message' => 'Submission received for review.',
            'data' => $item
        ], 201);
    }

    public function show(Request $request, StudentQuestion $question)
    {
        abort_unless(
            $request->user()->isAdmin()
            || $question->status === 'published'
            || $question->user_id === $request->user()->id,
            403
        );

        return response()->json(
            $question->load(['user:id,name', 'major:id,name'])
        );
    }

    public function update(Request $request, StudentQuestion $question)
    {
        abort_unless(
            $request->user()->isAdmin()
            || $question->user_id === $request->user()->id,
            403
        );

        $rules = $request->user()->isAdmin()
            ? [
                'status' => ['sometimes', 'in:pending,published,rejected'],
                'admin_reply' => ['nullable', 'string', 'max:3000']
            ]
            : [
                'title' => ['sometimes', 'string', 'max:150'],
                'body' => ['sometimes', 'string', 'min:10', 'max:5000']
            ];

        $question->update($request->validate($rules));

        return response()->json([
            'message' => 'Updated.',
            'data' => $question
        ]);
    }

    public function destroy(Request $request, StudentQuestion $question)
    {
        abort_unless(
            $request->user()->isAdmin()
            || $question->user_id === $request->user()->id,
            403
        );

        $question->delete();

        return response()->json([
            'message' => 'Deleted.'
        ]);
    }
}
