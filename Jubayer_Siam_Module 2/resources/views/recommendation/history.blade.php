@extends('layouts.app')
@section('title', 'My recommendations')

@section('content')
<section class="page-hero page-hero-compact"><div class="container py-5">
    <p class="eyebrow">MY RESULTS</p>
    <h1 class="display-6 fw-bold mb-2">Hello, {{ auth()->user()->name }}</h1>
    <p class="lead text-body-secondary mb-0">Every time you take the quiz, your recommendation is saved here so you can compare results over time.</p>
</div></section>
<section class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-3"><h2 class="h4 mb-0">Past recommendations</h2><a href="{{ route('quiz.show') }}" class="btn btn-primary"><i class="bi bi-compass me-1"></i>Take the quiz</a></div>
    @forelse ($attempts as $attempt)
        <a href="{{ route('recommendation.show', $attempt) }}" class="suggestion-link mb-3">
            <span class="suggestion-icon"><i class="bi bi-stars"></i></span>
            <span><strong>{{ $attempt->topMajor?->name ?? 'Result' }}@if ($attempt->is_tie) <small>(tie)</small>@endif</strong><small>{{ $attempt->percentages[$attempt->topMajor?->slug] ?? 0 }}% match · {{ $attempt->confidence }} · {{ $attempt->created_at->format('d M Y, H:i') }}</small></span>
            <i class="bi bi-arrow-up-right ms-auto"></i>
        </a>
    @empty
        <div class="empty-state"><i class="bi bi-compass"></i><h3>No results yet</h3><p>Take the 12-question quiz to get your first recommendation.</p></div>
    @endforelse
    {{ $attempts->links() }}
</section>
@endsection
