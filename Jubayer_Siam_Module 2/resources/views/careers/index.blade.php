@extends('layouts.app')
@section('title', 'Career opportunities and paths')

@section('content')
<section class="page-hero page-hero-compact">
    <div class="container py-5">
        <p class="eyebrow">MODULE 1 · FEATURE 05</p>
        <div class="row align-items-end g-4">
            <div class="col-lg-8"><h1 class="display-5 fw-bold mb-3">Explore jobs. Understand the journey.</h1><p class="lead text-body-secondary mb-0">Compare real responsibilities, required skills and industries, then explore how an entry-level role can grow into an advanced career.</p></div>
            <div class="col-lg-4 text-lg-end"><span class="hero-stat"><strong>{{ $careers->count() }}</strong><span>career roles mapped</span></span></div>
        </div>
    </div>
</section>
<section class="container py-4 py-lg-5">
    <div class="filter-panel mb-4">
        <div class="row g-3 align-items-end">
            <div class="col-lg-4"><label for="career-search" class="form-label fw-semibold">Search job roles</label><div class="input-with-icon"><i class="bi bi-search"></i><input id="career-search" class="form-control" type="search" placeholder="Try SOC Analyst, robotics, dashboard..."></div></div>
            <div class="col-md-4 col-lg-3"><label for="career-major" class="form-label fw-semibold">Major</label><select id="career-major" class="form-select"><option value="">All four majors</option>@foreach ($majors as $major)<option value="{{ $major->slug }}" @selected(request('major') === $major->slug)>{{ $major->name }}</option>@endforeach</select></div>
            <div class="col-md-4 col-lg-2"><label for="career-level" class="form-label fw-semibold">Career level</label><select id="career-level" class="form-select"><option value="">All levels</option><option value="Entry">Entry</option><option value="Mid">Mid</option><option value="Senior">Senior</option></select></div>
            <div class="col-md-4 col-lg-2"><label for="career-industry" class="form-label fw-semibold">Industry</label><select id="career-industry" class="form-select"><option value="">All industries</option>@foreach ($industries as $industry)<option value="{{ $industry }}">{{ $industry }}</option>@endforeach</select></div>
            <div class="col-lg-1 d-grid"><button id="career-reset" class="btn btn-outline-secondary" type="button" title="Reset filters"><i class="bi bi-arrow-counterclockwise"></i></button></div>
        </div>
        <div class="d-flex flex-wrap justify-content-between gap-2 mt-3 small text-body-secondary"><span id="career-result-count">Loading career roles...</span><span><i class="bi bi-diagram-3 me-1"></i>Choose a role to trace its career path</span></div>
    </div>

    <div class="section-heading-row mb-3"><div><p class="eyebrow mb-1">CAREER PATH VISUALIZER</p><h2 class="h3 mb-0">From entry level to advanced</h2></div><span class="small text-body-secondary">Select a role card to highlight its connected path</span></div>
    <div id="career-path-board" class="career-path-board mb-5" aria-live="polite"><div class="text-center p-5"><div class="spinner-border" role="status"></div></div></div>

    <div class="section-heading-row mb-3"><div><p class="eyebrow mb-1">JOB ROLE EXPLORER</p><h2 class="h3 mb-0">Find your next role</h2></div><span class="small text-body-secondary">Compare up to three roles</span></div>
    <div id="career-role-grid" class="row g-4"><div class="col-12"><div class="text-center p-5"><div class="spinner-border" role="status"></div></div></div></div>

    <section id="career-compare" class="compare-panel mt-5 d-none">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-3"><div><p class="eyebrow mb-1">SIDE-BY-SIDE REVIEW</p><h2 class="h3 mb-0">Career path comparison</h2></div><button id="clear-comparison" class="btn btn-outline-secondary btn-sm">Clear comparison</button></div>
        <div id="career-compare-table" class="table-responsive"></div>
    </section>

    <section class="content-panel mt-5" id="career-video-panel">
        <div class="row g-4 align-items-center">
            <div class="col-lg-5"><p class="eyebrow">LEARNING RESOURCE</p><h2 class="h3">See the field in action</h2><p class="text-body-secondary mb-0">Watch an introductory video related to the selected major. Use it as a starting point, then explore the role requirements and learning resources.</p></div>
            <div class="col-lg-7"><div class="video-frame"><iframe id="career-major-video" src="{{ $majors->first()?->video_url }}" title="Major introduction video" loading="lazy" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe></div></div>
        </div>
    </section>
    <section class="related-suggestions mt-5"><p class="eyebrow mb-1">KEEP EXPLORING</p><h2 class="h3 mb-3">Related content</h2><div class="row g-3"><div class="col-md-6"><a href="{{ route('subfields.index') }}" class="suggestion-link"><span class="suggestion-icon"><i class="bi bi-grid-3x3-gap"></i></span><span><strong>Explore subfields</strong><small>Understand specialisations and technologies inside each major.</small></span><i class="bi bi-arrow-up-right ms-auto"></i></a></div><div class="col-md-6"><a href="{{ route('careers.index') }}" class="suggestion-link"><span class="suggestion-icon"><i class="bi bi-arrow-left-right"></i></span><span><strong>Compare career options</strong><small>Filter by major, seniority and industry to find relevant roles.</small></span><i class="bi bi-arrow-up-right ms-auto"></i></a></div></div></section>
</section>
@endsection

@push('scripts')
<script>
window.CareerExplorerConfig = {
    api: @json(url('/api/v1/careers')),
    detailBase: @json(url('/careers')),
    majors: @json($majors->map(fn($major) => ['slug'=>$major->slug, 'name'=>$major->name, 'video_url'=>$major->video_url, 'image_url'=>$major->image_url])->values())
};
</script>
<script src="{{ asset('js/careers.js') }}"></script>
@endpush
