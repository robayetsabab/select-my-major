@extends('layouts.app')
@section('title','Register')
@section('content')
<div class="row justify-content-center"><div class="col-md-7 col-lg-6"><div class="card p-4">
<h2 class="section-title">Create Student Account</h2>
<form method="POST" action="{{ route('register.store') }}">@csrf
<div class="mb-3"><label class="form-label">Full name</label><input class="form-control" name="name" value="{{ old('name') }}" required maxlength="100"></div>
<div class="mb-3"><label class="form-label">Email</label><input class="form-control" type="email" name="email" value="{{ old('email') }}" required></div>
<div class="mb-3"><label class="form-label">Password</label><input class="form-control" type="password" name="password" required minlength="8"></div>
<div class="mb-3"><label class="form-label">Confirm password</label><input class="form-control" type="password" name="password_confirmation" required></div>
<button class="btn btn-primary w-100">Register</button></form>
</div></div></div>
@endsection
