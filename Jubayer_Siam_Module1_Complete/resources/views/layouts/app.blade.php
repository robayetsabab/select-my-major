<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Select My Major') | Select My Major</title>
    <script src="{{ asset('js/theme.js') }}"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="{{ asset('css/smm.css') }}" rel="stylesheet">
    @stack('styles')
</head>
<body class="d-flex flex-column min-vh-100">
@php
    $navLinks = [
        ['majors.index', 'Majors', 'majors.*'],
        ['subfields.index', 'Explore subfields', 'subfields.*'],
        ['careers.index', 'Career paths', 'careers.*'],
        ['certifications.index', 'Certifications', 'certifications.*'],
    ];
@endphp
<nav class="navbar navbar-expand-lg sticky-top smm-nav">
    <div class="container">
        <a class="navbar-brand fw-bold d-flex align-items-center gap-2" href="{{ route('home') }}">
            <span class="brand-mark">S</span><span>Select My Major</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav"
                aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav ms-auto me-lg-3 mb-2 mb-lg-0">
                @foreach ($navLinks as $link)
                    @if (Route::has($link[0]))
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs($link[2]) ? 'active fw-semibold' : '' }}"
                               href="{{ route($link[0]) }}">{{ $link[1] }}</a>
                        </li>
                    @endif
                @endforeach
            </ul>
            <button type="button" id="theme-toggle" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                <i class="bi bi-moon-stars me-1"></i><span>Dark mode</span>
            </button>
        </div>
    </div>
</nav>
<main class="flex-grow-1">@yield('content')</main>
<footer class="smm-footer py-4 mt-5">
    <div class="container d-flex flex-wrap justify-content-between gap-2 small text-body-secondary">
        <span>Select My Major — Know Before You Choose</span>
        <span>SE331 Lab B2, Group 05 · Module 1</span>
    </div>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('js/smm.js') }}"></script>
@stack('scripts')
</body>
</html>
