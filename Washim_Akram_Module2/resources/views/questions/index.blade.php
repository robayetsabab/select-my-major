@extends('layouts.app')
@section('title','Community')
@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-center mb-3"><div><h1 class="section-title">Student Community</h1><p class="muted mb-0">Questions and feedback about majors, resources and careers.</p></div><a class="btn btn-primary" href="{{ route('questions.create') }}">+ Submit Question / Feedback</a></div>
<div class="card p-3 mb-4">
<form method="GET" class="row g-2 align-items-end">
 <div class="col-md-3"><label class="form-label">Search</label><input class="form-control" name="q" value="{{ request('q') }}" placeholder="Search title or text"></div>
 <div class="col-md-2"><label class="form-label">Type</label><select class="form-select" name="type"><option value="">All</option><option value="question" @selected(request('type')==='question')>Question</option><option value="feedback" @selected(request('type')==='feedback')>Feedback</option></select></div>
 <div class="col-md-2"><label class="form-label">Category</label><select class="form-select" name="category"><option value="">All</option>@foreach(['major'=>'Major','learning_resource'=>'Learning Resource','career'=>'Career'] as $k=>$v)<option value="{{ $k }}" @selected(request('category')===$k)>{{ $v }}</option>@endforeach</select></div>
 <div class="col-md-3"><label class="form-label">Major</label><select class="form-select" name="major_id"><option value="">All majors</option>@foreach($majors as $major)<option value="{{ $major->id }}" @selected((string)request('major_id')===(string)$major->id)>{{ $major->name }}</option>@endforeach</select></div>
 @if(auth()->user()->isAdmin())<div class="col-md-2"><label class="form-label">Status</label><select class="form-select" name="status"><option value="">All</option>@foreach(['pending','published','rejected'] as $s)<option value="{{ $s }}" @selected(request('status')===$s)>{{ ucfirst($s) }}</option>@endforeach</select></div>@endif
 <div class="col-12 d-flex gap-2"><button class="btn btn-dark">Apply Filters</button><a href="{{ route('questions.index') }}" class="btn btn-outline-secondary">Reset</a></div>
</form></div>
<div class="row g-3">
@forelse($questions as $item)
 <div class="col-12"><div class="card p-4">
  <div class="d-flex justify-content-between flex-wrap gap-2"><div><span class="tag">{{ ucfirst($item->type) }}</span> <span class="tag">{{ str_replace('_',' ',ucfirst($item->category)) }}</span> @if($item->major)<span class="tag">{{ $item->major->name }}</span>@endif</div>
  <small class="muted">{{ $item->created_at->format('d M Y') }} · {{ ucfirst($item->status) }}</small></div>
  <h5 class="mt-3 mb-1"><a class="text-decoration-none" href="{{ route('questions.show',$item) }}">{{ $item->title }}</a></h5>
  <p class="muted mb-0">{{ \Illuminate\Support\Str::limit($item->body,220) }}</p>
  <small class="mt-2">By {{ $item->user->name }}</small>
 </div></div>
@empty<div class="col-12"><div class="card p-5 text-center muted">No submissions found. Try changing your filters.</div></div>@endforelse
</div>
<div class="mt-4">{{ $questions->links() }}</div>
@endsection
