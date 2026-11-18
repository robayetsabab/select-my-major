@extends('layouts.app')
@section('title','Home')
@section('content')
<div class="hero p-4 p-md-5 mb-4">
 <span class="tag">STUDENT GUIDANCE & COMMUNITY</span>
 <h1 class="display-5 fw-bold mt-3">Know Before You Choose.</h1>
 <p class="lead col-lg-8">Ask questions, share feedback and compare academic majors before choosing your career direction.</p>
 @auth
  <a class="btn btn-light btn-lg me-2" href="{{ route('questions.index') }}">Explore Community</a>
  <a class="btn btn-outline-light btn-lg" href="{{ route('compare.index') }}">Compare Majors</a>
 @else
  <a class="btn btn-light btn-lg me-2" href="{{ route('register') }}">Get Started</a>
  <a class="btn btn-outline-light btn-lg" href="{{ route('login') }}">Login</a>
 @endauth
</div>
<div class="row g-4">
 <div class="col-md-6"><div class="card p-4 h-100"><h3 class="section-title">Questions & Feedback</h3><p class="muted">Ask about majors, learning resources and career opportunities. Submissions are reviewed before publication.</p><a href="{{ auth()->check() ? route('questions.index') : route('login') }}" class="btn btn-primary mt-auto">Open Community</a></div></div>
 <div class="col-md-6"><div class="card p-4 h-100"><h3 class="section-title">Compare Majors</h3><p class="muted">Compare Cyber Security, Robotics, Software Testing and Data Science side by side.</p><a href="{{ auth()->check() ? route('compare.index') : route('login') }}" class="btn btn-primary mt-auto">Compare Now</a></div></div>
</div>
@endsection
