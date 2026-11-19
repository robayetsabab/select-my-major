@extends('layouts.app')
@section('title', 'Log in')
@section('content')
<section class="container py-5"><div class="row justify-content-center"><div class="col-md-7 col-lg-5">
    <div class="content-panel">
        <h1 class="h3 mb-1">Welcome back</h1>
        <p class="text-body-secondary">Log in to take the quiz, save your recommendation and mark helpful stories.</p>
        <form method="POST" action="{{ route('login') }}" novalidate>@csrf
            <div class="mb-3"><label class="form-label" for="email">Email</label><input id="email" name="email" type="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" required autofocus>@error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
            <div class="mb-3"><label class="form-label" for="password">Password</label><input id="password" name="password" type="password" class="form-control" required></div>
            <div class="form-check mb-3"><input class="form-check-input" type="checkbox" name="remember" id="remember"><label class="form-check-label" for="remember">Remember me</label></div>
            <button class="btn btn-primary w-100" type="submit">Log in</button>
        </form>
        <p class="small text-body-secondary mt-3 mb-0">New here? <a href="{{ route('register') }}">Create a student account</a>.<br>Demo account after seeding: <code>student@example.com</code> / <code>password</code></p>
    </div>
</div></div></section>
@endsection
