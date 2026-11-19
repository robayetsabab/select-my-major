@extends('layouts.app')
@section('title', 'Certifications')
@section('content')
<section class="page-hero page-hero-compact"><div class="container py-5">
    <p class="eyebrow">CERTIFICATIONS AND LEARNING RESOURCES</p>
    <h1 class="display-5 fw-bold mb-3">Recommended certifications.</h1>
    <p class="lead text-body-secondary mb-0">Prices change often — always confirm on the official page before paying.</p>
</div></section>
<section class="container py-5">
@foreach ($majors as $major)
    <h2 class="h4 mb-3 mt-4">{{ $major->name }}</h2>
    <div class="row g-3">
    @foreach ($major->certifications as $cert)
        <div class="col-md-6"><div class="content-panel h-100">
            <div class="d-flex justify-content-between gap-2 mb-2"><span class="major-label">{{ $cert->provider }}</span><span class="level-label">{{ $cert->level }}</span></div>
            <h3 class="h5">{{ $cert->name }}</h3>
            <p class="mb-1"><strong>Cost:</strong> {{ $cert->price }}</p>
            @if ($cert->free_option)<p class="small mb-2"><i class="bi bi-gift me-1"></i>{{ $cert->free_option }}</p>@endif
            <a href="{{ $cert->official_url }}" class="btn btn-outline-primary btn-sm" target="_blank" rel="noopener noreferrer">Official page <i class="bi bi-box-arrow-up-right ms-1"></i></a>
        </div></div>
    @endforeach
    </div>
@endforeach
</section>
@endsection
