@extends('layouts.app')
@section('title','Login')
@section('content')
<div class="row justify-content-center"><div class="col-md-6 col-lg-5"><div class="card p-4">
<h2 class="section-title">Student Login</h2><p class="muted">Sign in to access community and comparison tools.</p>
<form method="POST" action="{{ route('login.store') }}">@csrf
<div class="mb-3"><label class="form-label">Email</label><input class="form-control" type="email" name="email" value="{{ old('email') }}" required></div>
<div class="mb-3"><label class="form-label">Password</label><input class="form-control" type="password" name="password" required></div>
<div class="form-check mb-3"><input class="form-check-input" type="checkbox" name="remember" value="1" id="remember"><label for="remember">Remember me</label></div>
<button class="btn btn-primary w-100">Login</button></form>
<p class="mt-3 mb-0">New student? <a href="{{ route('register') }}">Create account</a></p>
</div></div></div>
@endsection
