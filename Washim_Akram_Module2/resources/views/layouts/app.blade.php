<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Select My Major') | Know Before You Choose</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body{background:#f5f7fb;color:#172033}.navbar{background:#101c3a}.navbar-brand,.nav-link{color:#fff!important}
        .hero{background:linear-gradient(120deg,#101c3a,#2456a6);color:white;border-radius:1.25rem}
        .card{border:0;border-radius:1rem;box-shadow:0 8px 24px rgba(20,40,80,.06)}
        .section-title{font-weight:800;color:#14264b}.muted{color:#68758d}
        .tag{background:#eaf0ff;color:#244b98;border-radius:2rem;padding:.3rem .65rem;font-size:.8rem}
        footer{color:#75809a}
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark">
 <div class="container"><a class="navbar-brand fw-bold" href="{{ route('home') }}">SELECT MY MAJOR</a>
  <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#nav"><span class="navbar-toggler-icon"></span></button>
  <div class="collapse navbar-collapse" id="nav"><div class="navbar-nav ms-auto">
   @auth
    <a class="nav-link" href="{{ route('questions.index') }}">Community</a><a class="nav-link" href="{{ route('compare.index') }}">Compare Majors</a>
    <span class="nav-link text-info">{{ auth()->user()->name }}</span>
    <form method="POST" action="{{ route('logout') }}">@csrf<button class="btn btn-sm btn-outline-light ms-lg-2">Logout</button></form>
   @else
    <a class="nav-link" href="{{ route('login') }}">Login</a><a class="btn btn-sm btn-light ms-lg-2" href="{{ route('register') }}">Create account</a>
   @endauth
  </div></div>
 </div>
</nav>
<main class="container py-4">
 @if(session('success'))<div class="alert alert-success alert-dismissible fade show">{{ session('success') }}<button class="btn-close" data-bs-dismiss="alert"></button></div>@endif
 @if($errors->any())<div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
 @yield('content')
</main>
<footer class="container py-4 text-center small">SELECT MY MAJOR · Know Before You Choose · SE331</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body></html>
