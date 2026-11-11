@extends('layouts.app')
@section('title', $subfield->name)

@section('content')
<section class="detail-hero">
    <div class="container py-5">
        <nav aria-label="breadcrumb"><ol class="breadcrumb"><li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li><li class="breadcrumb-item"><a href="{{ route('subfields.index') }}">Subfields</a></li><li class="breadcrumb-item active" aria-current="page">{{ $subfield->name }}</li></ol></nav>
        <span class="major-label mb-3">{{ $subfield->major->name }}</span>
        <div class="row align-items-center g-4">
            <div class="col-lg-7"><h1 class="display-5 fw-bold">{{ $subfield->name }}</h1><p class="lead text-body-secondary">{{ $subfield->summary }}</p><span class="level-label">Learning level: {{ $subfield->difficulty }}</span></div>
            <div class="col-lg-5"><img class="detail-image" src="{{ $subfield->image_url ?: $subfield->major->image_url }}" alt="{{ $subfield->name }} visual" loading="lazy"></div>
        </div>
    </div>
</section>
<section class="container py-5">
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="content-panel">
                <ul class="nav nav-pills detail-tabs mb-4" id="subfieldTabs" role="tablist">
                    <li class="nav-item"><button class="nav-link active" data-bs-toggle="pill" data-bs-target="#tab-overview" type="button">Overview</button></li>
                    <li class="nav-item"><button class="nav-link" data-bs-toggle="pill" data-bs-target="#tab-work" type="button">Daily work</button></li>
                    <li class="nav-item"><button class="nav-link" data-bs-toggle="pill" data-bs-target="#tab-focus" type="button">Focus & applications</button></li>
                    <li class="nav-item"><button class="nav-link" data-bs-toggle="pill" data-bs-target="#tab-tools" type="button">Tools</button></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="tab-overview"><h2 class="h3">What is this subfield?</h2><p>{{ $subfield->details }}</p><h3 class="h5 mt-4">Main focus</h3><p>{{ $subfield->main_focus }}</p></div>
                    <div class="tab-pane fade" id="tab-work"><h2 class="h3">What kind of work is done?</h2><ul class="feature-list">@foreach ($subfield->typical_tasks ?? [] as $task)<li>{{ $task }}</li>@endforeach</ul></div>
                    <div class="tab-pane fade" id="tab-focus"><h2 class="h3">Main applications</h2><ul class="feature-list">@foreach ($subfield->applications ?? [] as $application)<li>{{ $application }}</li>@endforeach</ul><div class="note-panel mt-4"><strong>Related major</strong><p class="mb-0">{{ $subfield->major->name }} — this subfield belongs to this major in the project’s major classification.</p></div></div>
                    <div class="tab-pane fade" id="tab-tools"><h2 class="h3">Technologies and tools</h2><div class="tool-cloud">@foreach ($subfield->technologies ?? [] as $technology)<span>{{ $technology }}</span>@endforeach</div><p class="small text-body-secondary mt-3">Tools are examples commonly associated with this area. The exact stack varies by organization and project.</p></div>
                </div>
            </div>
            <div class="content-panel mt-4"><span class="eyebrow">REAL-WORLD EXAMPLE</span><h2 class="h4 mt-2">Where this knowledge is used</h2><p class="mb-0">{{ $subfield->real_world_example }}</p></div>
            @if ($subfield->youtube_url)
                <div class="content-panel mt-4"><h2 class="h4 mb-3">Watch and learn</h2><div class="video-frame"><iframe src="{{ $subfield->youtube_url }}" title="{{ $subfield->name }} learning video" loading="lazy" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe></div><p class="small text-body-secondary mt-2 mb-0">External YouTube video. Availability and content are controlled by the publisher.</p></div>
            @endif
        </div>
        <aside class="col-lg-4">
            <div class="content-panel mb-4"><h2 class="h5">Related subfields</h2><div class="related-list">@forelse ($related as $item)<a href="{{ route('subfields.show', $item) }}"><span>{{ $item->name }}</span><i class="bi bi-arrow-up-right"></i></a>@empty<p class="text-body-secondary mb-0">No related subfields available yet.</p>@endforelse</div></div>
            <div class="content-panel"><h2 class="h5">Career opportunities in {{ $subfield->major->name }}</h2><div class="related-list">@foreach ($relatedCareers as $career)<a href="{{ route('careers.show', $career) }}"><span>{{ $career->title }}</span><i class="bi bi-arrow-up-right"></i></a>@endforeach</div><a href="{{ route('careers.index', ['major' => $subfield->major->slug]) }}" class="btn btn-outline-primary w-100 mt-3">Explore career paths</a></div>
        </aside>
    </div>
</section>
@endsection
