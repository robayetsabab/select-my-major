@extends('layouts.app')
@section('title','Submit')
@section('content')
<div class="row justify-content-center"><div class="col-lg-8"><div class="card p-4">
<h2 class="section-title">Submit a Question or Feedback</h2><p class="muted">Your submission will be pending until an admin reviews it.</p>
<form method="POST" action="{{ route('questions.store') }}">@csrf
<div class="row g-3">
<div class="col-md-6"><label class="form-label">Submission type</label><select class="form-select" name="type" required><option value="question">Question</option><option value="feedback">Feedback</option></select></div>
<div class="col-md-6"><label class="form-label">Related category</label><select class="form-select" name="category" required><option value="major">Major</option><option value="learning_resource">Learning Resource</option><option value="career">Career Opportunity</option></select></div>
<div class="col-12"><label class="form-label">Related major (optional)</label><select class="form-select" name="major_id"><option value="">Not specific</option>@foreach($majors as $major)<option value="{{ $major->id }}">{{ $major->name }}</option>@endforeach</select></div>
<div class="col-12"><label class="form-label">Title</label><input class="form-control" name="title" maxlength="150" value="{{ old('title') }}" required></div>
<div class="col-12"><label class="form-label">Details</label><textarea class="form-control" name="body" rows="6" minlength="10" maxlength="5000" required>{{ old('body') }}</textarea></div>
<div class="col-12"><button class="btn btn-primary">Submit for Review</button><a href="{{ route('questions.index') }}" class="btn btn-outline-secondary">Cancel</a></div>
</div></form></div></div></div>
@endsection
