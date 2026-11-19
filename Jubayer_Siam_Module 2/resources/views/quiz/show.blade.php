@extends('layouts.app')
@section('title', 'Find my major')

@section('content')
<section class="page-hero page-hero-compact"><div class="container py-5">
    <p class="eyebrow">MAJOR RECOMMENDATION QUIZ</p>
    <h1 class="display-5 fw-bold mb-3">Which major fits you best?</h1>
    <p class="lead text-body-secondary mb-0">{{ $questions->count() }} short questions about your interests, strengths and working style. There are no right or wrong answers — pick what feels most like you.</p>
</div></section>

<section class="container py-4 py-lg-5">
    @if ($last)
        <div class="alert alert-info d-flex flex-wrap justify-content-between align-items-center gap-2">
            <span>You last got <strong>{{ $last->topMajor?->name }}</strong> on {{ $last->created_at->format('d M Y') }}.</span>
            <a href="{{ route('recommendation.show', $last) }}" class="btn btn-sm btn-outline-primary">View that result</a>
        </div>
    @endif
    @if ($errors->any())<div class="alert alert-danger">{{ $errors->first() }}</div>@endif

    @if ($questions->isEmpty())
        <div class="empty-state"><h3>No quiz questions yet</h3><p>Run <code>php artisan migrate:fresh --seed</code>.</p></div>
    @else
    <form method="POST" action="{{ route('quiz.submit') }}" id="quiz-form" data-total="{{ $questions->count() }}">@csrf
        <div class="quiz-progress mb-4"><div class="d-flex justify-content-between small text-body-secondary mb-1"><span id="quiz-progress-text">0 of {{ $questions->count() }} answered</span><span id="quiz-progress-pct">0%</span></div><div class="progress" role="progressbar" aria-label="Quiz progress"><div class="progress-bar" id="quiz-progress-bar" style="width:0%"></div></div></div>
        @foreach ($questions as $i => $question)
            <fieldset class="content-panel quiz-question mb-4" data-question="{{ $question->id }}">
                <legend class="float-none w-auto p-0 mb-1"><span class="eyebrow">QUESTION {{ $i + 1 }} · {{ strtoupper(str_replace('_', ' ', $question->category)) }}</span></legend>
                <h2 class="h5 mb-3">{{ $question->question }}</h2>
                <div class="row g-2">
                    @foreach ($question->options as $option)
                        <div class="col-md-6">
                            <input class="btn-check quiz-input" type="radio" name="answers[{{ $question->id }}]" id="opt-{{ $option->id }}" value="{{ $option->id }}" @checked((int) old('answers.' . $question->id) === $option->id)>
                            <label class="quiz-option w-100" for="opt-{{ $option->id }}">{{ $option->label }}</label>
                        </div>
                    @endforeach
                </div>
            </fieldset>
        @endforeach
        <div class="d-flex flex-wrap gap-2"><button type="submit" class="btn btn-primary btn-lg" id="quiz-submit"><i class="bi bi-stars me-1"></i>Show my recommendation</button></div>
    </form>
    @endif
</section>
@endsection

@push('scripts')
<script src="{{ asset('js/quiz.js') }}"></script>
@endpush
