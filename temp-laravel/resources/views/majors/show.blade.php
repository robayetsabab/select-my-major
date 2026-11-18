@extends('layouts.app')
@section('title',$major->name)
@section('content')
@php
    $majorAccent = ['cyber-security' => '#315cf5', 'robotics' => '#0f8b8d', 'software-testing' => '#7b61c8', 'data-science' => '#d17a24'][$major->slug] ?? '#315cf5';
    $bestFor = $major->best_for ?? match ($major->slug) {
        'cyber-security' => 'Students who enjoy investigating problems, protecting systems and thinking carefully about digital safety.',
        'robotics' => 'Students who like building things, experimenting with hardware and software, and solving practical engineering problems.',
        'software-testing' => 'Students who notice details, ask how things can fail and enjoy improving software quality.',
        'data-science' => 'Students who enjoy patterns, logical thinking, statistics and turning data into useful decisions.',
        default => $major->tagline,
    };
@endphp
<section class="detail-hero" style="--accent:{{ $majorAccent }}">
    <div class="container detail-hero-grid">
        <div class="detail-hero-copy">
            <a class="back-link" href="{{ route('majors.index') }}">← All majors</a>
            <span class="eyebrow d-block mt-4">MAJOR OVERVIEW</span>
            <h1>{{ $major->name }}</h1>
            <p class="detail-tagline">{{ $major->tagline }}</p>
            <div class="detail-actions"><a class="btn btn-primary" href="{{ route('certifications.index',['major'=>$major->slug]) }}">Find learning resources <span>↗</span></a><a class="btn btn-soft" href="{{ route('majors.index') }}#major-compare">Compare majors</a></div>
        </div>
        <div class="detail-art"><img src="{{ asset('images/majors/'.$major->slug.'.svg') }}" alt="{{ $major->name }} illustration"></div>
    </div>
</section>

<section class="section-block detail-section">
    <div class="container detail-content-grid">
        <div class="detail-main">
            <div class="detail-section-intro"><span class="eyebrow">GET TO KNOW THE SUBJECT</span><h2>A closer look at {{ $major->name }}</h2><p>Start with the overview, then explore the reasons and learning resources at your own pace.</p></div>
            <nav class="detail-tabs" aria-label="Major information" role="tablist">
                <button type="button" class="detail-tab active" data-detail-tab="overview" role="tab" aria-selected="true">Overview</button>
                <button type="button" class="detail-tab" data-detail-tab="reasons" role="tab" aria-selected="false">Why choose it</button>
                <button type="button" class="detail-tab" data-detail-tab="fit" role="tab" aria-selected="false">Is it a fit?</button>
                <button type="button" class="detail-tab" data-detail-tab="videos" role="tab" aria-selected="false">Watch & explore</button>
            </nav>
            <section class="content-card detail-panel" data-detail-panel="overview" role="tabpanel"><span class="eyebrow">THE BIG PICTURE</span><h2>What is {{ $major->name }}?</h2><p class="body-copy">{{ $major->overview }}</p><div class="detail-prompt"><strong>Explore at your pace</strong><span>Use these sections to understand the subject and consider whether its style of work interests you.</span></div></section>
            <section class="content-card detail-panel d-none" data-detail-panel="reasons" role="tabpanel"><span class="eyebrow">WHY THIS PATH</span><h2>Why choose {{ $major->name }}?</h2><div class="reason-grid">@foreach($major->reasons as $reason)<div class="reason-item"><span class="reason-number">0{{ $loop->iteration }}</span><p>{{ $reason }}</p></div>@endforeach</div></section>
            <section class="content-card detail-panel d-none" data-detail-panel="fit" role="tabpanel"><span class="eyebrow">A POSSIBLE FIT</span><h2>Could this be your kind of work?</h2><div class="fit-card"><span class="fit-mark">✓</span><p>{{ $bestFor }}</p></div><p class="fit-note">Use this as a reflection prompt. Your interests can change as you learn and try new things.</p></section>
            <section class="content-card video-card detail-panel d-none" data-detail-panel="videos" role="tabpanel"><div><span class="eyebrow">GO A LITTLE DEEPER</span><h2>Watch and explore</h2><p>Find introductory explainers and university lectures about {{ $major->name }}. This link opens a YouTube search so you can choose a video and channel that suit you.</p><a class="btn btn-primary" target="_blank" rel="noopener noreferrer" href="https://www.youtube.com/results?search_query={{ urlencode($major->name.' introduction for beginners university') }}">Explore videos on YouTube <span>↗</span></a></div><div class="video-art"><span class="play-circle">▶</span><span class="video-art-label">VIDEO EXPLORER</span></div></section>
        </div>
        <aside class="detail-aside">
            <div class="aside-card sticky-aside"><span class="eyebrow">YOUR NEXT STEP</span><h3>Keep learning</h3><p>Browse courses and certifications related to this major, with provider information and official links.</p><div class="aside-stat"><strong>{{ $counts['certifications'] }}</strong><span>learning resources listed</span></div><a class="btn btn-primary w-100" href="{{ route('certifications.index',['major'=>$major->slug]) }}">Browse resources <span>↗</span></a><a class="aside-link" href="{{ route('majors.index') }}">Back to all majors <span>→</span></a></div>
            <div class="aside-card"><span class="eyebrow">KEEP EXPLORING</span><h3>Other majors</h3>@foreach($others as $other)<a class="other-major" href="{{ route('majors.show',$other) }}"><span>{{ $other->name }}</span><span>↗</span></a>@endforeach</div>
        </aside>
    </div>
</section>
@endsection
