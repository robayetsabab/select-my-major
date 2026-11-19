@extends('layouts.app')
@section('title', $major->name)
@section('content')
<section class="detail-hero"><div class="container py-5">
    <nav aria-label="breadcrumb"><ol class="breadcrumb"><li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li><li class="breadcrumb-item"><a href="{{ route('majors.index') }}">Majors</a></li><li class="breadcrumb-item active">{{ $major->name }}</li></ol></nav>
    <div class="row align-items-center g-4">
        <div class="col-lg-7"><h1 class="display-5 fw-bold">{{ $major->name }}</h1><p class="lead text-body-secondary">{{ $major->tagline }}</p><span class="level-label">Best for: {{ $major->best_for }}</span></div>
        @if ($major->image_url)<div class="col-lg-5"><img class="detail-image" src="{{ $major->image_url }}" alt="{{ $major->name }} visual" loading="lazy"></div>@endif
    </div>
</div></section>
<section class="container py-5"><div class="row g-4">
    <div class="col-lg-8">
        <div class="content-panel"><h2 class="h3">Overview</h2><p>{{ $major->overview }}</p>
            <h3 class="h5 mt-4">Why students choose it</h3><ul class="feature-list">@foreach ($major->reasons ?? [] as $reason)<li>{{ $reason }}</li>@endforeach</ul></div>
        <div class="content-panel mt-4"><h2 class="h4">Subfields inside {{ $major->name }}</h2>
            <div class="related-list">@foreach ($major->subfields as $sub)<a href="{{ route('subfields.show', $sub) }}"><span>{{ $sub->name }}<small class="d-block text-body-secondary">{{ $sub->summary }}</small></span><i class="bi bi-arrow-up-right"></i></a>@endforeach</div></div>
    </div>
    <aside class="col-lg-4">
        <div class="content-panel"><h2 class="h5">Career roles</h2><div class="related-list">@foreach ($major->careers as $role)<a href="{{ route('careers.show', $role) }}"><span>{{ $role->title }}<small class="d-block text-body-secondary">{{ $role->level }} level</small></span><i class="bi bi-arrow-up-right"></i></a>@endforeach</div></div>
        @if ($experiences->isNotEmpty())
        <div class="content-panel mt-4"><h2 class="h5">Senior students say</h2><div class="related-list">@foreach ($experiences as $story)<a href="{{ route('experiences.show', $story) }}"><span>{{ $story->headline }}<small class="d-block text-body-secondary">{{ $story->student_name }} · {{ $story->stage_label }}</small></span><i class="bi bi-arrow-up-right"></i></a>@endforeach</div></div>
        @endif
        <a href="{{ route('quiz.show') }}" class="btn btn-primary w-100 mt-4">Is this major right for me?</a>
    </aside>
</div></section>
@endsection
