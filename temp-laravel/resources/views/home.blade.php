@extends('layouts.app')
@section('title','Find your direction')
@section('content')
@php
    $majorAccents = ['cyber-security' => '#315cf5', 'robotics' => '#0f8b8d', 'software-testing' => '#7b61c8', 'data-science' => '#d17a24'];
@endphp
<section class="home-hero">
    <div class="container hero-grid">
        <div class="hero-copy">
            <span class="eyebrow"><span class="eyebrow-dot"></span> YOUR NEXT CHAPTER STARTS HERE</span>
            <h1>Find the major<br><span>that fits your mind.</span></h1>
            <p class="hero-lead">Explore four software engineering majors, understand the differences and find learning resources from official providers.</p>

            <form class="hero-search" method="GET" action="{{ route('majors.index') }}" role="search">
                <svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="11" cy="11" r="6.8"></circle><path d="m16 16 4.3 4.3"></path></svg>
                <input type="search" name="q" placeholder="Search Cyber Security, Robotics, Data Science…" aria-label="Search software engineering majors">
                <button type="submit" class="btn btn-primary">Search majors <span aria-hidden="true">↗</span></button>
            </form>
            <div class="hero-suggestions">
                <span>Popular:</span>
                <a href="{{ route('majors.index', ['q' => 'Cyber Security']) }}">Cyber Security</a>
                <a href="{{ route('majors.index', ['q' => 'Robotics']) }}">Robotics</a>
                <a href="{{ route('majors.index', ['q' => 'Data Science']) }}">Data Science</a>
            </div>
            <div class="hero-proof"><span class="proof-line"></span><span>Clear insights. Better decisions.</span></div>
        </div>

        <div class="hero-visual">
            <div class="hero-photo-wrap">
                <img class="hero-photo" src="https://images.unsplash.com/photo-1522071820081-009f0129c71c?auto=format&amp;fit=crop&amp;w=1400&amp;q=85" alt="Students collaborating around a laptop" fetchpriority="high">
                <div class="photo-overlay"></div>
                <div class="photo-caption"><span class="photo-caption-kicker">MAKE AN INFORMED CHOICE</span><strong>Your interests are a good place to start.</strong></div>
            </div>
            <div class="floating-note note-a"><span class="note-icon note-blue">04</span><div><strong>Four majors</strong><small>One place to explore</small></div></div>
            <div class="floating-note note-b"><span class="note-icon note-surface">✓</span><div><strong>Compare options</strong><small>Choose with clarity</small></div></div>
        </div>
    </div>
    <div class="hero-bottom-line"><div class="container"><span>START WITH THE OVERVIEW</span><span class="hero-bottom-rule"></span><span>THEN EXPLORE AT YOUR PACE</span></div></div>
</section>

<section class="section-block home-majors-section">
    <div class="container">
        <div class="section-heading">
            <div><span class="eyebrow">FOUR DIRECTIONS</span><h2>Explore your possibilities</h2><p>Start with the big picture, then open a major overview to understand the subject.</p></div>
            <a class="text-link" href="{{ route('majors.index') }}">View all majors <span>→</span></a>
        </div>
        <div class="major-grid home-major-grid">
            @foreach($majors as $major)
                <article class="major-tile" style="--accent:{{ $majorAccents[$major->slug] ?? '#315cf5' }}">
                    <div class="tile-art"><img src="{{ asset('images/majors/'.$major->slug.'.svg') }}" alt="{{ $major->name }} illustration" loading="lazy"></div>
                    <div class="tile-content">
                        <span class="tile-index">0{{ $loop->iteration }}</span>
                        <h3>{{ $major->name }}</h3>
                        <p>{{ $major->tagline }}</p>
                        <a class="tile-link" href="{{ route('majors.show',$major) }}">View major overview <span>↗</span></a>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>

<section class="decision-band">
    <div class="container decision-inner">
        <div><span class="eyebrow">NOT SURE WHERE TO START?</span><h2>Make your choice a little clearer.</h2><p>Use the major explorer to search, narrow down and compare the options side by side.</p></div>
        <a class="btn btn-light btn-lg" href="{{ route('majors.index') }}">Open major explorer <span>→</span></a>
    </div>
</section>

<section class="section-block resources-preview">
    <div class="container resource-cta">
        <div class="resource-visual" aria-hidden="true">
            <div class="resource-sheet sheet-back"></div>
            <div class="resource-sheet sheet-front"><span class="sheet-mini">LEARNING RESOURCE</span><span class="sheet-line"></span><span class="sheet-line short"></span><span class="sheet-pill">Free + Paid</span></div>
            <span class="resource-spark">✳</span>
        </div>
        <div><span class="eyebrow">LEARN BEYOND THE CLASSROOM</span><h2>Build your next step<br>with trusted resources.</h2><p>Search certifications and courses, check provider information and price notes, and visit the official learning page.</p><a class="btn btn-primary" href="{{ route('certifications.index') }}">Explore learning resources <span>↗</span></a></div>
    </div>
</section>
@endsection
