@extends('layouts.app')
@section('title', 'Certifications & Learning Resources')

@section('content')
<h1 class="fw-bold mb-3">Certifications &amp; Learning Resources</h1>

<form method="GET" action="{{ route('certifications.index') }}" class="card card-body shadow-sm mb-4">
    <div class="row g-3 align-items-end">
        <div class="col-md-3">
            <label class="form-label">Major</label>
            <select name="major" class="form-select">
                <option value="">All majors</option>
                @foreach ($majors as $m)
                    <option value="{{ $m->id }}" @selected(request('major') == $m->id)>{{ $m->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <label class="form-label">Type</label>
            <select name="type" class="form-select">
                <option value="">All</option>
                <option value="certification" @selected(request('type') === 'certification')>Certification</option>
                <option value="resource" @selected(request('type') === 'resource')>Learning resource</option>
            </select>
        </div>
        <div class="col-md-3">
            <label class="form-label">Search</label>
            <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="e.g. Security+">
        </div>
        <div class="col-md-2">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="free" value="1" id="free" @checked(request()->boolean('free'))>
                <label class="form-check-label" for="free">Free options only</label>
            </div>
        </div>
        <div class="col-md-1 d-grid">
            <button class="btn btn-primary">Filter</button>
        </div>
    </div>
</form>

<div class="card shadow-sm">
    <div class="card-body">
        @include('certifications._table', ['certifications' => $certifications, 'showMajor' => true])
    </div>
</div>
<p class="text-muted small mt-3">Prices are approximate and may change. Always confirm on the official source link.</p>
@endsection
