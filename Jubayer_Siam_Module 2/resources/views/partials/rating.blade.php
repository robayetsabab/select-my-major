@php $value = (int) ($value ?? 0); @endphp
<span class="rating-stars" aria-label="{{ $value }} out of 5">@for ($i = 1; $i <= 5; $i++)<i class="bi {{ $i <= $value ? 'bi-star-fill' : 'bi-star' }}"></i>@endfor</span>
