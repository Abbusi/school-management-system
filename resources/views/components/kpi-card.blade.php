@props([
    'link',
    'count',
    'label',
    'delta' => null,
    'deltaType' => 'up'
])

<a class="stat-card" href="{{ $link }}">
    <div class="stat-label">{{ $label }}</div>
    <div class="stat-value">{{ $count }}</div>
    @if($delta)
        <div class="stat-delta {{ $deltaType }}">
            {{ $deltaType === 'up' ? '↑' : '↓' }} {{ $delta }}
        </div>
    @endif
</a>
