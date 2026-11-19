@extends('layouts.app')
@section('title', $experience->headline)

@section('content')
<section class="detail-hero">
    <div class="container py-5">
        <nav aria-label="breadcrumb"><ol class="breadcrumb"><li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li><li class="breadcrumb-item"><a href="{{ route('experiences.index') }}">Senior stories</a></li><li class="breadcrumb-item active" aria-current="page">{{ $experience->student_name }}</li></ol></nav>
        <div class="d-flex flex-wrap gap-2 mb-3"><span class="major-label">{{ $experience->major->name }}</span><span class="level-label">{{ $experience->status === 'completed' ? 'Completed' : 'Currently studying' }} · {{ $experience->stage_label }}</span>@if ($experience->subfield)<span class="level-label">Focus: {{ $experience->subfield->name }}</span>@endif</div>
        <h1 class="display-6 fw-bold">{{ $experience->headline }}</h1>
        <div class="exp-person mt-3">
            <div class="avatar avatar-lg">{{ strtoupper(mb_substr($experience->student_name, 0, 1)) }}</div>
            <div><strong>{{ $experience->student_name }}</strong><small class="d-block text-body-secondary">{{ $experience->batch }}@if ($experience->current_position) · {{ $experience->current_position }}@endif</small></div>
        </div>
    </div>
</section>

<section class="container py-5"><div class="row g-4">
    <div class="col-lg-8">
        <div class="content-panel"><span class="eyebrow">THE JOURNEY</span><h2 class="h4 mt-2">Their story</h2><p class="mb-0">{{ $experience->story }}</p></div>
        <div class="row g-4 mt-0">
            <div class="col-md-6"><div class="content-panel h-100"><span class="eyebrow">BEST PART</span><p class="mb-0 mt-2">{{ $experience->best_part }}</p></div></div>
            <div class="col-md-6"><div class="content-panel h-100"><span class="eyebrow">BIGGEST CHALLENGE</span><p class="mb-0 mt-2">{{ $experience->challenges }}</p></div></div>
        </div>
        <div class="content-panel mt-4 advice-panel"><span class="eyebrow">ADVICE FOR JUNIORS</span><p class="mb-0 mt-2 fs-5">{{ $experience->advice }}</p></div>

        <div class="d-flex flex-wrap align-items-center gap-3 mt-4">
            @auth
                <button type="button" id="helpful-btn" class="btn {{ $voted ? 'btn-primary' : 'btn-outline-primary' }}" data-url="{{ route('experiences.helpful', $experience) }}">
                    <i class="bi bi-hand-thumbs-up me-1"></i><span id="helpful-label">{{ $voted ? 'Marked helpful' : 'This was helpful' }}</span> · <span id="helpful-count">{{ $experience->helpful_count }}</span>
                </button>
            @else
                <a class="btn btn-outline-primary" href="{{ route('login') }}"><i class="bi bi-hand-thumbs-up me-1"></i>Log in to mark helpful · {{ $experience->helpful_count }}</a>
            @endauth
            <a class="btn btn-outline-secondary" href="{{ route('experiences.index', ['major' => $experience->major->slug]) }}">More {{ $experience->major->name }} stories</a>
        </div>
    </div>
    <aside class="col-lg-4">
        <div class="content-panel">
            <h2 class="h5">Their feedback on the major</h2>
            <div class="feedback-row"><span>Satisfaction</span>@include('partials.rating', ['value' => $experience->satisfaction])</div>
            <div class="feedback-row"><span>Difficulty</span>@include('partials.rating', ['value' => $experience->difficulty])</div>
            <div class="feedback-row"><span>Would choose it again</span><strong class="{{ $experience->would_choose_again ? 'text-success' : 'text-danger' }}">{{ $experience->would_choose_again ? 'Yes' : 'Not sure' }}</strong></div>
            <hr>
            <h3 class="h6">Skills they built</h3>
            <div class="tool-cloud">@foreach ($experience->skills ?? [] as $skill)<span>{{ $skill }}</span>@endforeach</div>
        </div>
        @if ($experience->subfield)
            <div class="content-panel mt-4"><h2 class="h5">Explore their focus area</h2><a class="btn btn-outline-primary w-100" href="{{ route('subfields.show', $experience->subfield) }}">{{ $experience->subfield->name }}</a></div>
        @endif
        @if ($more->isNotEmpty())
            <div class="content-panel mt-4"><h2 class="h5">More from {{ $experience->major->name }}</h2>
                <div class="related-list">@foreach ($more as $item)<a href="{{ route('experiences.show', $item) }}"><span>{{ $item->headline }}<small class="d-block text-body-secondary">{{ $item->student_name }}</small></span><i class="bi bi-arrow-up-right"></i></a>@endforeach</div></div>
        @endif
    </aside>
</div></section>
@endsection

@push('scripts')
<script src="{{ asset('js/experiences.js') }}"></script>
@endpush
