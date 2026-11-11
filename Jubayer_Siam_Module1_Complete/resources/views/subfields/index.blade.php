@extends('layouts.app')
@section('title', 'Explore subfields')

@section('content')
<section class="page-hero page-hero-compact">
    <div class="container py-5">
        <p class="eyebrow">MODULE 1 · FEATURE 02</p>
        <div class="row align-items-end g-4">
            <div class="col-lg-8">
                <h1 class="display-5 fw-bold mb-3">Explore the fields within each major.</h1>
                <p class="lead text-body-secondary mb-0">Understand what professionals actually do, the problems they solve, the tools they use and where each specialisation is applied.</p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <span class="hero-stat"><strong>16</strong><span>subfields to explore</span></span>
            </div>
        </div>
    </div>
</section>
<section class="container py-4 py-lg-5">
    <div class="filter-panel mb-4">
        <div class="row g-3 align-items-end">
            <div class="col-lg-5">
                <label for="subfield-search" class="form-label fw-semibold">Search subfields</label>
                <div class="input-with-icon"><i class="bi bi-search"></i><input id="subfield-search" class="form-control" type="search" value="{{ request('q') }}" placeholder="Try cloud security, ROS, automation..."></div>
            </div>
            <div class="col-md-6 col-lg-3">
                <label for="subfield-major" class="form-label fw-semibold">Related major</label>
                <select id="subfield-major" class="form-select">
                    <option value="">All four majors</option>
                    @foreach ($majors as $major)
                        <option value="{{ $major->slug }}" @selected(request('major') === $major->slug)>{{ $major->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6 col-lg-2">
                <label for="subfield-difficulty" class="form-label fw-semibold">Level</label>
                <select id="subfield-difficulty" class="form-select">
                    <option value="">Any level</option>
                    @foreach (['Beginner', 'Beginner to Intermediate', 'Intermediate', 'Intermediate to Advanced', 'Advanced'] as $level)
                        <option value="{{ $level }}" @selected(request('difficulty') === $level)>{{ $level }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-lg-2 d-grid"><button id="subfield-reset" class="btn btn-outline-secondary" type="button"><i class="bi bi-arrow-counterclockwise me-1"></i>Reset filters</button></div>
        </div>
        <div class="d-flex flex-wrap justify-content-between gap-2 mt-3 small text-body-secondary">
            <span id="subfield-result-count">Showing {{ $subfields->total() }} subfields</span>
            <span><i class="bi bi-lightning-charge me-1"></i>Results update as you search</span>
        </div>
    </div>

    <div id="subfield-results" class="row g-4">
        @forelse ($subfields as $subfield)
            <div class="col-md-6 col-xl-4 subfield-result-card">
                <article class="card exploration-card h-100">
                    <div class="exploration-image" style="background-image:url('{{ $subfield->image_url ?: $subfield->major->image_url }}')"></div>
                    <div class="card-body d-flex flex-column">
                        <div class="d-flex justify-content-between align-items-center gap-2 mb-3">
                            <span class="major-label">{{ $subfield->major->name }}</span>
                            <span class="level-label">{{ $subfield->difficulty }}</span>
                        </div>
                        <h2 class="h4">{{ $subfield->name }}</h2>
                        <p class="text-body-secondary">{{ $subfield->summary }}</p>
                        <div class="tool-preview mb-3">@foreach (array_slice($subfield->technologies ?? [], 0, 3) as $tool)<span>{{ $tool }}</span>@endforeach</div>
                        <div class="mt-auto d-flex flex-wrap gap-2">
                            <a class="btn btn-primary flex-grow-1" href="{{ route('subfields.show', $subfield) }}">Explore details <i class="bi bi-arrow-right ms-1"></i></a>
                            <button class="btn btn-outline-secondary preview-subfield" type="button" data-url="{{ url('/api/v1/subfields/'.$subfield->slug) }}" aria-label="Quick preview {{ $subfield->name }}"><i class="bi bi-eye"></i></button>
                        </div>
                    </div>
                </article>
            </div>
        @empty
            <div class="col-12"><div class="empty-state"><i class="bi bi-search"></i><h3>No subfields found</h3><p>Try removing a filter or using a broader search term.</p></div></div>
        @endforelse
    </div>
    <div id="subfield-pagination" class="mt-4">{{ $subfields->links() }}</div>
</section>

<div class="modal fade" id="subfieldPreviewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered"><div class="modal-content">
        <div class="modal-header"><div><span class="eyebrow">QUICK PREVIEW</span><h2 class="modal-title h4" id="preview-title">Subfield</h2></div><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div>
        <div class="modal-body" id="preview-body"><div class="text-center py-5"><div class="spinner-border" role="status"></div></div></div>
        <div class="modal-footer"><a id="preview-link" class="btn btn-primary" href="#">Open full details</a><button class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button></div>
    </div></div>
</div>
@endsection

@push('scripts')
<script>
window.SubfieldExplorerConfig = { api: @json(url('/api/v1/subfields')), detailBase: @json(url('/subfields')) };
</script>
<script src="{{ asset('js/subfields.js') }}"></script>
@endpush
