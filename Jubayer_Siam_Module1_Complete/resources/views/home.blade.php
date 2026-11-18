@extends('layouts.app')

@section('title', 'Home')

@section('content')
<section class="hero py-5">
    <div class="container py-4">
        <p class="eyebrow mb-2">Module 1 - Major Information and Career Exploration</p>
        <h1 class="display-5 fw-bold">Know before you choose.</h1>
        <p class="lead col-lg-8">
            Picking a major is a big decision, and most of us make it with only half the story. This guide lays out
            four paths in software engineering - Cyber Security, Robotics, Software Testing and Data Science - so you
            can compare them with real details instead of guesses.
        </p>
        <div class="d-flex flex-wrap gap-2 mt-4">
            @if (Route::has('majors.index'))
                <a class="btn btn-primary btn-lg" href="{{ route('majors.index') }}">Explore the majors</a>
            @endif
            @if (Route::has('certifications.index'))
                <a class="btn btn-outline-secondary btn-lg" href="{{ route('certifications.index') }}">See certifications</a>
            @endif
            @if (Route::has('careers.index'))
                <a class="btn btn-outline-secondary btn-lg" href="{{ route('careers.index') }}">Career paths</a>
            @endif
        </div>
    </div>
</section>

<section class="container py-5">
    <h2 class="h3 mb-4">The four majors</h2>
    <div class="row g-4">
        @forelse ($majors as $major)
            <div class="col-md-6 col-lg-3">
                <article class="card major-card h-100" style="--accent: {{ $major->accent }}">
                    <div class="card-body">
                        <h3 class="h5">{{ $major->name }}</h3>
                        <p class="text-body-secondary mb-0">{{ $major->tagline }}</p>
                    </div>
                    @if (Route::has('majors.show'))
                        <div class="card-footer bg-transparent border-0 pb-3">
                            <a class="btn btn-accent w-100" href="{{ route('majors.show', $major) }}">Learn more</a>
                        </div>
                    @endif
                </article>
            </div>
        @empty
            <p>No majors found yet. Please run <code>php artisan migrate:fresh --seed</code>.</p>
        @endforelse
    </div>
</section>

<section class="container pb-4">
    <div class="row g-4">
        <div class="col-md-4">
            <div class="card smm-card h-100"><div class="card-body">
                <h3 class="h5">1. Get the big picture</h3>
                <p class="mb-0 text-body-secondary">Read what each major is really about and why students pick it.</p>
            </div></div>
        </div>
        <div class="col-md-4">
            <div class="card smm-card h-100"><div class="card-body">
                <h3 class="h5">2. Look closer</h3>
                <p class="mb-0 text-body-secondary">Check the areas inside each major and the jobs they lead to.</p>
            </div></div>
        </div>
        <div class="col-md-4">
            <div class="card smm-card h-100"><div class="card-body">
                <h3 class="h5">3. Plan your next step</h3>
                <p class="mb-0 text-body-secondary">Find certifications with prices, free options and official links.</p>
            </div></div>
        </div>
    </div>
</section>
@endsection
