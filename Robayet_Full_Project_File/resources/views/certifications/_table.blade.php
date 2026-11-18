@if ($certifications->isEmpty())
    <p class="text-muted mb-0">No certifications found.</p>
@else
<div class="table-responsive">
    <table class="table table-hover align-middle">
        <thead class="table-light">
            <tr>
                <th>Name</th>
                @if ($showMajor ?? true) <th>Major</th> @endif
                <th>Type</th>
                <th>Level</th>
                <th>Price</th>
                <th>Free option</th>
                <th>Official source</th>
            </tr>
        </thead>
        <tbody>
        @foreach ($certifications as $c)
            <tr>
                <td>
                    <strong>{{ $c->name }}</strong><br>
                    <small class="text-muted">{{ $c->provider }}</small>
                    @if ($c->description)<br><small>{{ $c->description }}</small>@endif
                </td>
                @if ($showMajor ?? true) <td>{{ $c->major->name }}</td> @endif
                <td><span class="badge {{ $c->type === 'certification' ? 'bg-primary' : 'bg-info text-dark' }}">{{ ucfirst($c->type) }}</span></td>
                <td>{{ $c->level }}</td>
                <td>
                    {{ $c->price_label }}
                    @if ($c->price_note)<br><small class="text-muted">{{ $c->price_note }}</small>@endif
                </td>
                <td>
                    @if ($c->has_free_option)
                        <span class="badge bg-success">Yes</span>
                    @else
                        <span class="badge bg-light text-dark border">No</span>
                    @endif
                </td>
                <td><a href="{{ $c->source_url }}" target="_blank" rel="noopener" class="btn btn-sm btn-outline-secondary">Visit <i class="bi bi-box-arrow-up-right"></i></a></td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endif
