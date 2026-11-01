@props(['announcement'])

<a class="announcement-card" href="{{ route('announcements.show', $announcement) }}">
    <span class="listing-mark" aria-hidden="true">
        {{ mb_strtoupper(mb_substr($announcement->title, 0, 1)) }}
    </span>
    <span class="listing-copy">
        <span class="listing-title">{{ $announcement->title }}</span>
        @if ($announcement->created_at)
            <time datetime="{{ $announcement->created_at->toAtomString() }}">
                {{ __('announcements.published', ['date' => $announcement->created_at->locale('fr')->diffForHumans()], 'fr') }}
            </time>
        @endif
    </span>
    <svg class="listing-arrow" viewBox="0 0 24 24" aria-hidden="true">
        <path d="m9 5 7 7-7 7"></path>
    </svg>
</a>
