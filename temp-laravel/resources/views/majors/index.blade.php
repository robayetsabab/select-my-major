@extends('layouts.app')
@section('title', 'Explore Majors')

@section('content')
<div class="text-center mb-4">
    <h1 class="fw-bold">Know Before You Choose</h1>
    <p class="lead text-muted">Explore four majors for Software Engineering students and find the one that fits you.</p>
</div>

<div class="row g-4">
    @foreach ($majors as $major)
        <div class="col-md-6 col-lg-3">
            <div class="card h-100 shadow-sm">
                <div class="card-body d-flex flex-column">
                    <div class="fs-1 text-primary"><i class="bi {{ $major->icon }}"></i></div>
                    <h5 class="card-title mt-2">{{ $major->name }}</h5>
                    <p class="text-muted small">{{ $major->tagline }}</p>
                    <span class="badge bg-secondary align-self-start mb-3">Difficulty: {{ $major->difficulty }}</span>
                    <a href="{{ route('majors.show', $major) }}" class="btn btn-primary mt-auto">View Details</a>
                </div>
            </div>
        </div>
    @endforeach
</div>
@endsection
