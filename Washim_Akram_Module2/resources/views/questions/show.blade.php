@extends('layouts.app')
@section('title','Submission')
@section('content')
<div class="card p-4">
<div class="d-flex justify-content-between"><span class="tag">{{ ucfirst($question->type) }} · {{ str_replace('_',' ',ucfirst($question->category)) }}</span><span class="muted">{{ ucfirst($question->status) }}</span></div>
<h2 class="section-title mt-3">{{ $question->title }}</h2>
<p class="muted">By {{ $question->user->name }} · {{ $question->created_at->format('d M Y') }} @if($question->major) · {{ $question->major->name }} @endif</p>
<p style="white-space:pre-line">{{ $question->body }}</p>
@if($question->admin_reply)<div class="alert alert-info"><strong>Admin reply</strong><br>{{ $question->admin_reply }}</div>@endif
@if(auth()->user()->isAdmin())
<hr><h5>Moderate submission</h5>
<form method="POST" action="{{ route('questions.moderate',$question) }}">@csrf @method('PATCH')
<div class="row g-2"><div class="col-md-3"><select name="status" class="form-select"><option value="published">Publish</option><option value="rejected">Reject</option></select></div><div class="col-md-7"><input class="form-control" name="admin_reply" placeholder="Optional reply" value="{{ $question->admin_reply }}"></div><div class="col-md-2"><button class="btn btn-primary w-100">Update</button></div></div>
</form>
@endif
<a href="{{ route('questions.index') }}" class="btn btn-outline-secondary mt-3">Back to Community</a>
</div>
@endsection
