@extends('layouts.app')
@section('title', 'The four majors')
@section('content')
<section class="page-hero page-hero-compact"><div class="container py-5">
    <p class="eyebrow">MAJOR OVERVIEW</p>
    <h1 class="display-5 fw-bold mb-3">Four majors. One honest overview.</h1>
    <p class="lead text-body-secondary mb-0">Read what each major is about, why students pick it and what it leads to.</p>
</div></section>
<section class="container py-5"><div class="row g-4">
@foreach ($majors as $major)
    <div class="col-md-6"><article class="card major-card h-100" style="--accent: {{ $major->accent }}"><div class="card-body p-4">
        <h2 class="h4">{{ $major->name }}</h2>
        <p class="text-body-secondary">{{ $major->tagline }}</p>
        <p class="small mb-3"><strong>Best for:</strong> {{ $major->best_for }}</p>
        <div class="tool-preview mb-3"><span>{{ $major->subfields_count }} subfields</span><span>{{ $major->careers_count }} careers</span><span>{{ $major->certifications_count }} certifications</span><span>{{ $major->experiences_count }} senior stories</span></div>
        <a class="btn btn-accent" href="{{ route('majors.show', $major) }}">Read the overview</a>
    </div></article></div>
@endforeach
</div></section>
@endsection
