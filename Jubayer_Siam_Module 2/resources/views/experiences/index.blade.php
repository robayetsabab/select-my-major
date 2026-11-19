@extends('layouts.app')
@section('title', 'Senior students\' experiences')

@section('content')
<section class="page-hero page-hero-compact">
    <div class="container py-5">
        <p class="eyebrow">MODULE 2 · FEATURE 08</p>
        <div class="row align-items-end g-4">
            <div class="col-lg-8">
                <h1 class="display-5 fw-bold mb-3">Hear it from students who’ve been there.</h1>
                <p class="lead text-body-secondary mb-0">Real-style experiences, honest advice and feedback from students who are studying or have completed each major.</p>
            </div>
            <div class="col-lg-4 text-lg-end"><span class="hero-stat"><strong>{{ $experiences->total() }}</strong><span>stories shown</span></span></div>
        </div>
    </div>
</section>

<section class="container py-4 py-lg-5">
    <div class="row g-3 mb-4">
        @foreach ($majors as $major)
            @php $s = $stats->get($major->id); @endphp
            <div class="col-md-6 col-xl-3">
                <a href="{{ route('experiences.index', ['major' => $major->slug]) }}" class="stat-card" style="--accent: {{ $major->accent }}">
                    <strong>{{ $major->name }}</strong>
                    @if ($s)
                        <span>{{ $s->total }} stories · satisfaction {{ number_format($s->avg_satisfaction, 1) }}/5</span>
                        <span>difficulty {{ number_format($s->avg_difficulty, 1) }}/5 · {{ round($s->choose_again / max($s->total, 1) * 100) }}% would choose again</span>
                    @else
                        <span>No stories yet</span>
                    @endif
                </a>
            </div>
        @endforeach
    </div>

    <form method="GET" action="{{ route('experiences.index') }}" id="experience-filter" class="filter-panel mb-4">
        <div class="row g-3 align-items-end">
            <div class="col-lg-4"><label class="form-label fw-semibold" for="exp-q">Search stories</label>
                <div class="input-with-icon"><i class="bi bi-search"></i><input id="exp-q" name="q" type="search" class="form-control" value="{{ $filters['q'] ?? '' }}" placeholder="Try internship, ROS, Selenium..."></div></div>
            <div class="col-md-4 col-lg-3"><label class="form-label fw-semibold" for="exp-major">Major</label>
                <select id="exp-major" name="major" class="form-select"><option value="">All majors</option>@foreach ($majors as $major)<option value="{{ $major->slug }}" @selected(($filters['major'] ?? '') === $major->slug)>{{ $major->name }}</option>@endforeach</select></div>
            <div class="col-md-4 col-lg-2"><label class="form-label fw-semibold" for="exp-status">Student type</label>
                <select id="exp-status" name="status" class="form-select"><option value="">All</option><option value="current" @selected(($filters['status'] ?? '') === 'current')>Currently studying</option><option value="completed" @selected(($filters['status'] ?? '') === 'completed')>Completed</option></select></div>
            <div class="col-md-4 col-lg-2"><label class="form-label fw-semibold" for="exp-sort">Sort by</label>
                <select id="exp-sort" name="sort" class="form-select"><option value="latest" @selected(($filters['sort'] ?? 'latest') === 'latest')>Newest</option><option value="helpful" @selected(($filters['sort'] ?? '') === 'helpful')>Most helpful</option><option value="rating" @selected(($filters['sort'] ?? '') === 'rating')>Highest satisfaction</option></select></div>
            <div class="col-lg-1 d-grid"><a class="btn btn-outline-secondary" href="{{ route('experiences.index') }}" title="Reset filters"><i class="bi bi-arrow-counterclockwise"></i></a></div>
        </div>
    </form>

    <div class="row g-4">
        @forelse ($experiences as $story)
            <div class="col-md-6 col-xl-4">
                <article class="card exp-card h-100">
                    <div class="card-body d-flex flex-column">
                        <div class="d-flex justify-content-between align-items-center gap-2 mb-3">
                            <span class="major-label">{{ $story->major->name }}</span>
                            <span class="level-label">{{ $story->status === 'completed' ? 'Completed' : 'Studying' }} · {{ $story->stage_label }}</span>
                        </div>
                        <h2 class="h5"><a class="role-title-link" href="{{ route('experiences.show', $story) }}">{{ $story->headline }}</a></h2>
                        <p class="text-body-secondary">{{ \Illuminate\Support\Str::limit($story->story, 170) }}</p>
                        <div class="exp-person mt-auto">
                            <div class="avatar">{{ strtoupper(mb_substr($story->student_name, 0, 1)) }}</div>
                            <div><strong>{{ $story->student_name }}</strong><small class="d-block text-body-secondary">{{ $story->batch }}@if ($story->current_position) · {{ $story->current_position }}@endif</small></div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mt-3 pt-3 border-top small">
                            <span>@include('partials.rating', ['value' => $story->satisfaction]) <span class="text-body-secondary ms-1">satisfaction</span></span>
                            <span class="text-body-secondary"><i class="bi bi-hand-thumbs-up{{ in_array($story->id, $votedIds) ? '-fill text-primary' : '' }}"></i> {{ $story->helpful_count }}</span>
                        </div>
                        <a class="btn btn-primary mt-3" href="{{ route('experiences.show', $story) }}">Read full story</a>
                    </div>
                </article>
            </div>
        @empty
            <div class="col-12"><div class="empty-state"><i class="bi bi-chat-square-text"></i><h3>No stories match</h3><p>Try a different major or clear the search.</p></div></div>
        @endforelse
    </div>
    <div class="mt-4">{{ $experiences->links() }}</div>
    <p class="small text-body-secondary mt-4 mb-0"><i class="bi bi-info-circle me-1"></i>Stories in this demo are sample content prepared for the university project. Replace them with real student submissions through the admin panel before public use.</p>
</section>
@endsection

@push('scripts')
<script src="{{ asset('js/experiences.js') }}"></script>
@endpush
