@extends('layouts.app')
@section('title', 'Sign up')
@section('content')
<section class="container py-5"><div class="row justify-content-center"><div class="col-md-7 col-lg-5">
    <div class="content-panel">
        <h1 class="h3 mb-1">Create a student account</h1>
        <p class="text-body-secondary">Registered students can take the quiz and keep their recommendation history.</p>
        <form method="POST" action="{{ route('register') }}" novalidate>@csrf
            <div class="mb-3"><label class="form-label" for="name">Full name</label><input id="name" name="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" required>@error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
            <div class="mb-3"><label class="form-label" for="email">Email</label><input id="email" name="email" type="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" required>@error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
            <div class="mb-3"><label class="form-label" for="password">Password (min. 8 characters)</label><input id="password" name="password" type="password" class="form-control @error('password') is-invalid @enderror" required>@error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
            <div class="mb-3"><label class="form-label" for="password_confirmation">Confirm password</label><input id="password_confirmation" name="password_confirmation" type="password" class="form-control" required></div>
            <button class="btn btn-primary w-100" type="submit">Create account</button>
        </form>
        <p class="small text-body-secondary mt-3 mb-0">Already registered? <a href="{{ route('login') }}">Log in</a>.</p>
    </div>
</div></div></section>
@endsection
