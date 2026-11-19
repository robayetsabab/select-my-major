@extends('layouts.app')

@section('title', 'Home')

@section('content')
<section class="hero py-5">
    <div class="container py-4">
        <p class="eyebrow mb-2">Career guidance for Software Engineering students</p>
        <h1 class="display-5 fw-bold">Know before you choose.</h1>
        <p class="lead col-lg-8">
            Picking a major is a big decision, and most of us make it with only half the story. This guide lays out
            four paths in software engineering — Cyber Security, Robotics, Software Testing and Data Science — so you
            can compare them with real details, hear from seniors, and get a recommendation that fits you.
        </p>
        <div class="d-flex flex-wrap gap-2 mt-4">
            <a class="btn btn-primary btn-lg" href="{{ route('quiz.show') }}"><i class="bi bi-compass me-1"></i>Find my major</a>
            <a class="btn btn-outline-secondary btn-lg" href="{{ route('subfields.index') }}">Explore subfields</a>
            <a class="btn btn-outline-secondary btn-lg" href="{{ route('experiences.index') }}">Read senior stories</a>
        </div>
        <div class="d-flex flex-wrap gap-3 mt-4">
            <span class="hero-stat"><strong>{{ $majors->count() }}</strong><span>majors</span></span>
            <span class="hero-stat"><strong>{{ $stats['subfields'] }}</strong><span>subfields</span></span>
            <span class="hero-stat"><strong>{{ $stats['careers'] }}</strong><span>career roles</span></span>
            <span class="hero-stat"><strong>{{ $stats['stories'] }}</strong><span>senior stories</span></span>
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
                    <div class="card-footer bg-transparent border-0 pb-3">
                        <a class="btn btn-accent w-100" href="{{ route('majors.show', $major) }}">Learn more</a>
                    </div>
                </article>
            </div>
        @empty
            <p>No majors found yet. Please run <code>php artisan migrate:fresh --seed</code>.</p>
        @endforelse
    </div>
</section>

<section class="container pb-4">
    <div class="row g-4">
        <div class="col-md-4"><div class="card smm-card h-100"><div class="card-body">
            <h3 class="h5">1. Look closer</h3>
            <p class="mb-0 text-body-secondary">Check the areas inside each major, the tools used and the jobs they lead to.</p>
        </div></div></div>
        <div class="col-md-4"><div class="card smm-card h-100"><div class="card-body">
            <h3 class="h5">2. Hear from seniors</h3>
            <p class="mb-0 text-body-secondary">Read honest advice from students who are studying or have finished each major.</p>
        </div></div></div>
        <div class="col-md-4"><div class="card smm-card h-100"><div class="card-body">
            <h3 class="h5">3. Get a recommendation</h3>
            <p class="mb-0 text-body-secondary">Answer a short quiz and see which major matches your interests and strengths.</p>
        </div></div></div>
    </div>
</section>
@endsection
