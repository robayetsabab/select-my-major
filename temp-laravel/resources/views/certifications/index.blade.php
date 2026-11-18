@extends('layouts.app')
@section('title','Learning resources')
@section('content')
<section class="page-hero resource-page-hero"><div class="container"><span class="eyebrow">LEARNING RESOURCE LIBRARY</span><h1>Learn. Practice. <span>Get certified.</span></h1><p>Explore trusted courses and certifications, compare available details and go straight to the official provider.</p></div></section>

<section class="section-block resource-section">
    <div class="container">
        <div class="resource-toolbar">
            <div class="search-wrap resource-search"><svg class="search-icon" viewBox="0 0 24 24" aria-hidden="true"><circle cx="11" cy="11" r="6.8"></circle><path d="m16 16 4.3 4.3"></path></svg><input id="cert-search" type="search" class="form-control" placeholder="Search courses, certifications or providers…" aria-label="Search learning resources"></div>
            <div class="filter-wrap"><label for="cert-major">Major</label><select id="cert-major" class="form-select"><option value="all">All majors</option>@foreach($majors as $major)<option value="{{ $major->slug }}" {{ $selected===$major->slug?'selected':'' }}>{{ $major->name }}</option>@endforeach</select></div>
            <div class="filter-wrap"><label for="cert-cost">Cost</label><select id="cert-cost" class="form-select"><option value="all">Free & paid</option><option value="free">Free resource</option><option value="paid">Paid</option></select></div>
            <div class="filter-wrap"><label for="cert-level">Level</label><select id="cert-level" class="form-select"><option value="all">All levels</option><option value="beginner">Beginner / Entry</option><option value="intermediate">Intermediate</option><option value="advanced">Advanced</option></select></div>
            <div class="filter-wrap"><label for="cert-provider-filter">Provider</label><select id="cert-provider-filter" class="form-select"><option value="all">All providers</option>@foreach($certifications->flatten()->pluck('provider')->unique()->sort() as $provider)<option value="{{ strtolower($provider) }}">{{ $provider }}</option>@endforeach</select></div>
            <div class="filter-wrap"><label for="cert-sort">Sort by</label><select id="cert-sort" class="form-select"><option value="recommended">Recommended</option><option value="name">Name A–Z</option><option value="provider">Provider A–Z</option><option value="free-first">Free first</option></select></div>
            <button id="cert-reset" type="button" class="btn btn-outline-secondary">Reset</button>
        </div>
        <div class="library-meta"><span id="cert-result-count">{{ $certifications->flatten()->count() }} resources</span><span>Prices may change. Always confirm with the provider.</span></div>

        <div class="cert-grid" id="cert-grid">
            @foreach($majors as $major)
                @php $items=$certifications->get($major->id); @endphp
                @if($items)
                    @foreach($items as $cert)
                        @php $isFree = (bool) $cert->is_free; @endphp
                        <article class="cert-card" data-cert-card data-name="{{ strtolower($cert->name) }}" data-search="{{ strtolower($cert->name.' '.$cert->provider.' '.$cert->level.' '.$major->name.' '.$cert->price.' '.$cert->free_option) }}" data-major="{{ $major->slug }}" data-cost="{{ $isFree?'free':'paid' }}" data-level="{{ strtolower($cert->level) }}" data-provider="{{ strtolower($cert->provider) }}" data-id="{{ $cert->id }}">
                            <div class="cert-card-top"><span class="cert-provider-mark">{{ strtoupper(substr($cert->provider,0,1)) }}</span><div class="cert-provider"><strong>{{ $cert->provider }}</strong><span>{{ $major->name }}</span></div><button type="button" class="bookmark-btn" data-bookmark="{{ $cert->id }}" aria-label="Save {{ $cert->name }}" title="Save resource" aria-pressed="false">♡</button></div>
                            <div class="cert-card-body"><div class="cert-badges"><span class="level-badge">{{ $cert->level }}</span><span class="cost-badge {{ $isFree?'free':'paid' }}">{{ $isFree?'Free resource':'Paid resource' }}</span></div><h2>{{ $cert->name }}</h2><p class="cert-price-label">{{ $cert->price }}</p>@if($cert->free_option)<div class="free-option"><span class="free-dot"></span><p><strong>Free learning option:</strong> {{ $cert->free_option }}</p></div>@endif</div>
                            <div class="cert-card-footer"><a href="{{ $cert->official_url }}" target="_blank" rel="noopener noreferrer" class="btn btn-primary w-100">Open official resource <span>↗</span></a><label class="cert-compare"><input type="checkbox" data-compare-cert value="{{ $cert->id }}"><span>Compare resource</span></label></div>
                        </article>
                    @endforeach
                @endif
            @endforeach
        </div>
        <div id="cert-empty" class="empty-state d-none"><div class="empty-mark">⌕</div><h3>No resources found</h3><p>Try adjusting your filters or search terms.</p><button id="cert-empty-reset" type="button" class="btn btn-outline-secondary">Reset filters</button></div>

        <section class="compare-panel mt-5" id="cert-compare"><div class="compare-panel-head"><div><span class="eyebrow">RESOURCE SHORTLIST</span><h2>Compare learning options</h2><p>Select two or more resources to compare provider, level and cost.</p></div><button type="button" class="btn btn-sm btn-outline-secondary" id="clear-cert-compare">Clear selection</button></div><div id="cert-compare-output" class="compare-placeholder"><span class="compare-plus">＋</span><span>Your resource comparison will appear here.</span></div></section>
        <div class="price-note"><span aria-hidden="true">ⓘ</span><p>Fees, subscription rates and exam prices may change by country or date. Treat displayed amounts as estimates and verify the latest price on each official provider page.</p></div>
    </div>
</section>
@endsection
