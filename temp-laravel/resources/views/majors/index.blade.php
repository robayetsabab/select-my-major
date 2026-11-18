@extends('layouts.app')
@section('title','Explore majors')
@section('content')
@php
    $majorAccents = ['cyber-security' => '#315cf5', 'robotics' => '#0f8b8d', 'software-testing' => '#7b61c8', 'data-science' => '#d17a24'];
@endphp
<section class="page-hero">
    <div class="container">
        <span class="eyebrow">MAJOR EXPLORER</span>
        <h1>Explore what fits <span>you.</span></h1>
        <p>Search the four majors, narrow your options by interest and compare a shortlist before you decide.</p>
    </div>
</section>

<section class="section-block explorer-section">
    <div class="container">
        <div class="explorer-layout">
            <aside class="filter-panel" aria-label="Major filters">
                <div class="filter-panel-heading"><div><span class="eyebrow">REFINE RESULTS</span><h2>Filters</h2></div><span class="filter-panel-mark">⌘</span></div>
                <div class="filter-wrap"><label for="major-focus">Focus area</label><select id="major-focus" class="form-select"><option value="all">All focus areas</option><option value="security">Security</option><option value="engineering">Engineering</option><option value="quality">Quality</option><option value="data">Data & analytics</option></select></div>
                <div class="filter-wrap"><label for="major-interest">Interest</label><select id="major-interest" class="form-select"><option value="all">Any interest</option><option value="protect">Protecting systems</option><option value="build">Building things</option><option value="quality">Finding issues</option><option value="analyze">Working with data</option></select></div>
                <div class="filter-wrap"><label for="major-style">Work style</label><select id="major-style" class="form-select"><option value="all">Any work style</option><option value="investigate">Investigative</option><option value="hands-on">Hands-on</option><option value="detail">Detail-oriented</option><option value="analytical">Analytical</option></select></div>
                <button type="button" id="clear-major-filters" class="btn btn-outline-secondary w-100">Reset filters</button>
                <p class="filter-help">Use any combination of filters. Your results update instantly.</p>
            </aside>

            <div class="explorer-main">
                <form class="explorer-searchbar" method="GET" action="{{ route('majors.index') }}" role="search">
                    <div class="search-wrap">
                        <svg class="search-icon" viewBox="0 0 24 24" aria-hidden="true"><circle cx="11" cy="11" r="6.8"></circle><path d="m16 16 4.3 4.3"></path></svg>
                        <input id="major-search" name="q" type="search" class="form-control" value="{{ request('q') }}" placeholder="Search majors or keywords…" aria-label="Search majors">
                        <kbd>Ctrl K</kbd>
                    </div>
                    <button type="submit" class="btn btn-primary">Search</button>
                </form>
                <div class="explorer-meta"><span id="major-result-count">{{ $majors->count() }} majors</span><span class="meta-hint">Select up to 4 to compare</span></div>

                <div class="major-grid explorer-grid" id="major-grid">
                    @foreach($majors as $major)
                        <article class="major-tile explorer-tile" data-major-card data-name="{{ strtolower($major->name) }}" data-search="{{ strtolower($major->name.' '.$major->tagline.' '.$major->overview.' '.implode(' ', $major->reasons)) }}" data-focus="{{ ['cyber-security'=>'security','robotics'=>'engineering','software-testing'=>'quality','data-science'=>'data'][$major->slug] ?? 'all' }}" data-interest="{{ ['cyber-security'=>'protect','robotics'=>'build','software-testing'=>'quality','data-science'=>'analyze'][$major->slug] ?? 'all' }}" data-style="{{ ['cyber-security'=>'investigate','robotics'=>'hands-on','software-testing'=>'detail','data-science'=>'analytical'][$major->slug] ?? 'all' }}" data-overview="{{ $major->overview }}" data-reasons="{{ implode(' • ', $major->reasons) }}" data-best-for="{{ $major->best_for ?? $major->tagline }}" style="--accent:{{ $majorAccents[$major->slug] ?? '#315cf5' }}">
                            <div class="tile-art">
                                <img src="{{ asset('images/majors/'.$major->slug.'.svg') }}" alt="{{ $major->name }} illustration" loading="lazy">
                                <label class="compare-check"><input type="checkbox" value="{{ $major->id }}" data-compare-major aria-label="Compare {{ $major->name }}"><span>Compare</span></label>
                            </div>
                            <div class="tile-content"><span class="tile-index">0{{ $loop->iteration }}</span><h2>{{ $major->name }}</h2><p>{{ $major->tagline }}</p><div class="tile-bottom"><a class="tile-link" href="{{ route('majors.show',$major) }}">View overview <span>↗</span></a><span class="tile-arrow" aria-hidden="true">↗</span></div></div>
                        </article>
                    @endforeach
                </div>
                <div id="major-empty" class="empty-state d-none"><div class="empty-mark">⌕</div><h3>No matching majors</h3><p>Try another keyword or reset your filters.</p><button type="button" class="btn btn-outline-secondary" id="empty-reset">Clear search</button></div>
            </div>
        </div>

        <section class="interest-finder mt-5" aria-labelledby="interest-finder-title">
            <div class="interest-finder-copy"><span class="eyebrow">A QUICK WAY TO EXPLORE</span><h2 id="interest-finder-title">What kind of problems do you enjoy?</h2><p>Choose the activity that sounds most interesting. This is a starting point for exploration, not a test or a final recommendation.</p></div>
            <div class="interest-finder-controls"><label for="interest-choice" class="form-label">I enjoy…</label><select id="interest-choice" class="form-select"><option value="">Choose an interest</option><option value="protect">Protecting systems and solving security puzzles</option><option value="build">Building physical things and experimenting with hardware</option><option value="quality">Checking details and finding software issues</option><option value="analyze">Finding patterns and explaining data</option></select><div id="interest-result" class="interest-result" aria-live="polite">Your suggested area will appear here.</div></div>
        </section>

        <section class="compare-panel mt-5" id="major-compare" aria-live="polite"><div class="compare-panel-head"><div><span class="eyebrow">YOUR SHORTLIST</span><h2>Compare majors</h2><p>Select at least two majors above to see a side-by-side view.</p></div><button type="button" class="btn btn-sm btn-outline-secondary" id="clear-compare">Clear selection</button></div><div id="compare-output" class="compare-placeholder"><span class="compare-plus">＋</span><span>Your comparison will appear here.</span></div></section>
    </div>
</section>
@endsection
