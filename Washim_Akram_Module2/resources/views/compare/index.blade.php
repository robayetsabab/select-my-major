@extends('layouts.app')
@section('title','Compare Majors')
@section('content')
<h1 class="section-title">Compare Majors</h1>
<p class="muted">Choose at least two and up to four majors. Compare the same criteria side by side.</p>
<div class="card p-4 mb-4">
<form method="GET" action="{{ route('compare.index') }}">
 <label class="form-label fw-semibold">Select majors</label>
 <div class="row g-2">@foreach($majors as $major)
  <div class="col-md-3 col-6"><div class="form-check border rounded p-3 ps-5"><input class="form-check-input" type="checkbox" name="majors[]" value="{{ $major->id }}" id="m{{ $major->id }}" @checked($selected->contains('id',$major->id))><label class="form-check-label fw-semibold" for="m{{ $major->id }}">{{ $major->name }}</label></div></div>
 @endforeach</div>
 <button class="btn btn-primary mt-3">Compare Selected</button>
 <a class="btn btn-outline-secondary mt-3" href="{{ route('compare.index') }}">Clear</a>
</form>
</div>
@if($selected->count())
@if($selected->count()<2)<div class="alert alert-warning">Select at least two majors to compare.</div>
@else
<div class="table-responsive card p-2"><table class="table table-bordered align-middle mb-0">
<thead class="table-dark"><tr><th style="min-width:180px">Criteria</th>@foreach($selected as $major)<th style="min-width:230px">{{ $major->name }}</th>@endforeach</tr></thead>
<tbody>
<tr><th>Description</th>@foreach($selected as $major)<td>{{ $major->short_description }}</td>@endforeach</tr>
<tr><th>Required Skills</th>@foreach($selected as $major)<td><ul class="mb-0">@foreach($major->required_skills as $v)<li>{{ $v }}</li>@endforeach</ul></td>@endforeach</tr>
<tr><th>Prerequisites</th>@foreach($selected as $major)<td><ul class="mb-0">@foreach($major->prerequisites as $v)<li>{{ $v }}</li>@endforeach</ul></td>@endforeach</tr>
<tr><th>Learning Difficulty</th>@foreach($selected as $major)<td><span class="badge text-bg-info">{{ $major->difficulty }}</span></td>@endforeach</tr>
<tr><th>Learning Roadmap</th>@foreach($selected as $major)<td><ol class="mb-0">@foreach($major->roadmap as $v)<li>{{ $v }}</li>@endforeach</ol></td>@endforeach</tr>
<tr><th>Certifications / Learning</th>@foreach($selected as $major)<td><ul class="mb-0">@foreach($major->certifications as $v)<li>{{ $v }}</li>@endforeach</ul></td>@endforeach</tr>
<tr><th>Career Opportunities</th>@foreach($selected as $major)<td><ul class="mb-0">@foreach($major->career_opportunities as $v)<li>{{ $v }}</li>@endforeach</ul></td>@endforeach</tr>
<tr><th>Bangladesh Job Market</th>@foreach($selected as $major)<td>{{ $major->job_market_bd }}</td>@endforeach</tr>
<tr><th>International Job Market</th>@foreach($selected as $major)<td>{{ $major->job_market_international }}</td>@endforeach</tr>
</tbody></table></div>
@endif
@else
<div class="card p-5 text-center muted">Select majors above to see a side-by-side comparison.</div>
@endif
@endsection
