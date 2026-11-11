<!doctype html>
<html lang="en" data-bs-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Explore software engineering majors, compare your options and find official learning resources.">
    <meta name="theme-color" content="#f7f9fc">
    <title>@yield('title', 'Explore') · Select My Major</title>
    <script src="{{ asset('js/theme.js') }}"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Manrope:wght@500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/smm.css') }}" rel="stylesheet">
</head>
<body class="d-flex flex-column min-vh-100">
<nav class="navbar navbar-expand-lg sticky-top smm-nav" aria-label="Main navigation">
    <div class="container">
        <a class="navbar-brand brand-mark" href="{{ route('home') }}" aria-label="Select My Major home">
            <span class="brand-symbol">S</span>
            <span>Select<span class="brand-light">My</span>Major</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav" aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-1">
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Home</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('majors.*') ? 'active' : '' }}" href="{{ route('majors.index') }}">Explore majors</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('certifications.*') ? 'active' : '' }}" href="{{ route('certifications.index') }}">Learning resources</a></li>
                <li class="nav-item ms-lg-2">
                    <button type="button" id="theme-toggle" class="theme-toggle" aria-label="Switch to dark mode" aria-pressed="false" title="Switch theme">
                        <span class="theme-icon" aria-hidden="true">◐</span>
                    </button>
                </li>
            </ul>
        </div>
    </div>
</nav>

<main class="flex-grow-1">@yield('content')</main>

<footer class="smm-footer">
    <div class="container footer-main">
        <div class="footer-about">
            <a class="navbar-brand brand-mark footer-brand-mark" href="{{ route('home') }}">
                <span class="brand-symbol">S</span><span>Select<span class="brand-light">My</span>Major</span>
            </a>
            <p>A clear starting point for exploring software engineering majors and trusted learning resources.</p>
            <span class="footer-note">Explore with clarity. Choose with confidence.</span>
        </div>
        <div class="footer-column">
            <h2>Explore</h2>
            <a href="{{ route('majors.index') }}">All majors</a>
            <a href="{{ route('majors.show', 'cyber-security') }}">Cyber Security</a>
            <a href="{{ route('majors.show', 'robotics') }}">Robotics</a>
            <a href="{{ route('majors.show', 'software-testing') }}">Software Testing</a>
            <a href="{{ route('majors.show', 'data-science') }}">Data Science</a>
        </div>
        <div class="footer-column">
            <h2>Quick links</h2>
            <a href="{{ route('home') }}">Home</a>
            <a href="{{ route('majors.index') }}">Major explorer</a>
            <a href="{{ route('certifications.index') }}">Certifications & courses</a>
        </div>
        <div class="footer-column footer-connect">
            <h2>Connect</h2>
            <span class="footer-social-placeholder">Social profiles will be listed here.</span>
            <span class="footer-language">English interface</span>
        </div>
    </div>
    <div class="container footer-bottom">
        <span>© {{ date('Y') }} Select My Major</span>
        <span>Built to help students make informed choices.</span>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('js/smm.js') }}"></script>
@stack('scripts')
</body>
</html>
