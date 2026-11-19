@extends('layouts.app')
@section('title', 'Your recommendation')

@section('content')
<section class="result-hero" style="--accent: {{ $top->accent }}">
    <div class="container py-5">
        <p class="eyebrow">MODULE 2 · FEATURE 11 · YOUR RECOMMENDATION</p>
        <div class="row align-items-center g-4">
            <div class="col-lg-8">
                @if ($attempt->is_tie && $runnerUp)
                    <h1 class="display-5 fw-bold">It’s a tie: {{ $top->name }} and {{ $runnerUp->name }}.</h1>
                    <p class="lead text-body-secondary">Your answers fit both equally well. Read both overviews and the senior stories below before you decide.</p>
                @else
                    <h1 class="display-5 fw-bold">Your best match: {{ $top->name }}</h1>
                    <p class="lead text-body-secondary">{{ $top->tagline }}</p>
                @endif
                <div class="d-flex flex-wrap gap-2">
                    <span class="level-label">{{ $attempt->confidence }}</span>
                    <span class="level-label">Taken {{ $attempt->created_at->format('d M Y, H:i') }}</span>
                </div>
            </div>
            <div class="col-lg-4 text-lg-end"><div class="score-ring" style="--pct: {{ $attempt->percentages[$top->slug] ?? 0 }}"><strong>{{ $attempt->percentages[$top->slug] ?? 0 }}%</strong><span>match</span></div></div>
        </div>
    </div>
</section>

<section class="container py-5"><div class="row g-4">
    <div class="col-lg-7">
        <div class="content-panel">
            <h2 class="h4">How every major scored</h2>
            <p class="small text-body-secondary">Match shows how closely your answers line up with each major. The percentages are not meant to add up to 100.</p>
            <div style="position:relative;height:260px"><canvas id="scoreChart" aria-label="Bar chart of your match with each major" role="img"></canvas></div>
            <div class="mt-4">
                @foreach ($ranking as $row)
                    <div class="score-row" style="--accent: {{ $row['major']->accent }}">
                        <div class="d-flex justify-content-between"><a href="{{ route('majors.show', $row['major']) }}" class="fw-semibold role-title-link">{{ $loop->iteration }}. {{ $row['major']->name }}</a><span>{{ $row['percent'] }}% <small class="text-body-secondary">({{ $row['score'] }} pts)</small></span></div>
                        <div class="progress" style="height:8px"><div class="progress-bar" style="width: {{ $row['percent'] }}%; background: {{ $row['major']->accent }}"></div></div>
                    </div>
                @endforeach
            </div>
        </div>

        @if (count($reasons))
        <div class="content-panel mt-4">
            <h2 class="h4">Why {{ $top->name }}?</h2>
            <p class="small text-body-secondary">These answers pushed {{ $top->name }} up the most.</p>
            <ul class="feature-list">@foreach ($reasons as $reason)<li><strong>{{ $reason['question'] }}</strong><br><span>You chose: “{{ $reason['answer'] }}”</span></li>@endforeach</ul>
        </div>
        @endif

        <div class="content-panel mt-4">
            <h2 class="h4">Inside {{ $top->name }}</h2>
            <div class="related-list">@foreach ($subfields as $sub)<a href="{{ route('subfields.show', $sub) }}"><span>{{ $sub->name }}<small class="d-block text-body-secondary">{{ $sub->summary }}</small></span><i class="bi bi-arrow-up-right"></i></a>@endforeach</div>
        </div>
    </div>

    <aside class="col-lg-5">
        <div class="content-panel">
            <h2 class="h5">Possible career path</h2>
            <div class="related-list">@foreach ($careers as $role)<a href="{{ route('careers.show', $role) }}"><span>{{ $role->title }}<small class="d-block text-body-secondary">{{ $role->level }} · {{ $role->experience_range }}</small></span><i class="bi bi-arrow-up-right"></i></a>@endforeach</div>
            <a class="btn btn-outline-primary w-100 mt-3" href="{{ route('careers.index', ['major' => $top->slug]) }}">See the full career map</a>
        </div>
        @if ($experiences->isNotEmpty())
        <div class="content-panel mt-4">
            <h2 class="h5">Seniors in {{ $top->name }}</h2>
            <div class="related-list">@foreach ($experiences as $story)<a href="{{ route('experiences.show', $story) }}"><span>{{ $story->headline }}<small class="d-block text-body-secondary">{{ $story->student_name }} · {{ $story->stage_label }}</small></span><i class="bi bi-arrow-up-right"></i></a>@endforeach</div>
        </div>
        @endif
        @if ($certifications->isNotEmpty())
        <div class="content-panel mt-4">
            <h2 class="h5">Good first certifications</h2>
            <div class="related-list">@foreach ($certifications as $cert)<a href="{{ $cert->official_url }}" target="_blank" rel="noopener noreferrer"><span>{{ $cert->name }}<small class="d-block text-body-secondary">{{ $cert->provider }} · {{ $cert->level }}</small></span><i class="bi bi-box-arrow-up-right"></i></a>@endforeach</div>
        </div>
        @endif
        @if ($runnerUp && !$attempt->is_tie)
        <div class="content-panel mt-4"><h2 class="h5">Runner-up</h2><p class="mb-2">{{ $runnerUp->name }} also fits you ({{ $attempt->percentages[$runnerUp->slug] ?? 0 }}%).</p><a class="btn btn-outline-secondary w-100" href="{{ route('majors.show', $runnerUp) }}">Read about {{ $runnerUp->name }}</a></div>
        @endif
        <div class="d-grid gap-2 mt-4"><a class="btn btn-primary" href="{{ route('quiz.show') }}"><i class="bi bi-arrow-repeat me-1"></i>Retake the quiz</a><a class="btn btn-outline-secondary" href="{{ route('recommendation.history') }}">My past results</a></div>
        @if ($previous && $previous->topMajor)
            <p class="small text-body-secondary mt-3">Last time you got <strong>{{ $previous->topMajor->name }}</strong> ({{ $previous->created_at->format('d M Y') }}).</p>
        @endif
    </aside>
</div></section>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>
<script>
(() => {
    const canvas = document.getElementById('scoreChart');
    if (!canvas || typeof Chart === 'undefined') return;
    const rows = @json($ranking->map(fn ($r) => ['name' => $r['major']->name, 'percent' => $r['percent'], 'color' => $r['major']->accent])->values());
    const dark = document.documentElement.getAttribute('data-bs-theme') === 'dark';
    const text = dark ? '#a6b4ca' : '#64748b';
    new Chart(canvas, {
        type: 'bar',
        data: { labels: rows.map(r => r.name), datasets: [{ data: rows.map(r => r.percent), backgroundColor: rows.map(r => r.color), borderRadius: 8 }] },
        options: {
            maintainAspectRatio: false, indexAxis: 'y',
            plugins: { legend: { display: false }, tooltip: { callbacks: { label: (c) => c.parsed.x + '% match' } } },
            scales: { x: { min: 0, max: 100, ticks: { color: text, callback: v => v + '%' }, grid: { color: dark ? '#29364a' : '#e5eaf1' } }, y: { ticks: { color: text }, grid: { display: false } } }
        }
    });
})();
</script>
@endpush
