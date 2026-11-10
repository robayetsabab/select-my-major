@extends('layouts.app')
@section('title', $major->name)

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('majors.index') }}">Majors</a></li>
        <li class="breadcrumb-item active">{{ $major->name }}</li>
    </ol>
</nav>

<div class="card shadow-sm mb-4">
    <div class="card-body">
        <h1 class="fw-bold"><i class="bi {{ $major->icon }} text-primary"></i> {{ $major->name }}</h1>
        <p class="text-muted">{{ $major->tagline }}</p>
        <span class="badge bg-secondary">Difficulty: {{ $major->difficulty }}</span>

        <h4 class="mt-4">Overview</h4>
        <p>{{ $major->overview }}</p>

        <h4>Why choose {{ $major->name }}?</h4>
        <ul class="list-group list-group-flush">
            @foreach ($major->reasons as $reason)
                <li class="list-group-item"><i class="bi bi-check-circle-fill text-success"></i> {{ $reason }}</li>
            @endforeach
        </ul>
    </div>
</div>

{{-- Teammates: add your sections here (subfields, roadmap, careers, salary) --}}

<div class="card shadow-sm mb-4">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="mb-0">Certifications &amp; Learning Resources</h4>
            <a href="{{ route('certifications.index', ['major' => $major->id]) }}" class="btn btn-sm btn-outline-primary">See all</a>
        </div>
        @include('certifications._table', ['certifications' => $major->certifications, 'showMajor' => false])
    </div>
</div>
@endsection
