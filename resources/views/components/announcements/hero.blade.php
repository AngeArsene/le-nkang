@props(['announcement'])

<header class="hero">
    <div class="avatar" aria-hidden="true">
        {{ mb_strtoupper(mb_substr($announcement->title, 0, 1)) }}
    </div>
    <div class="hero-copy">
        <h1>{{ $announcement->title }}</h1>
        @if ($announcement->created_at)
            <p class="hero-meta">
                {{ __('announcements.published', ['date' => $announcement->created_at->locale('fr')->diffForHumans()], 'fr') }}
            </p>
        @endif
        <div class="hero-actions">
            <button
                class="share-action"
                type="button"
                data-share
                data-share-title="{{ $announcement->title }}"
                data-share-success="{{ __('announcements.share_success', [], 'fr') }}"
                data-share-error="{{ __('announcements.share_error', [], 'fr') }}"
                hidden
            >
                <svg viewBox="0 0 24 24" aria-hidden="true">
                    <circle cx="18" cy="5" r="2.5"></circle>
                    <circle cx="6" cy="12" r="2.5"></circle>
                    <circle cx="18" cy="19" r="2.5"></circle>
                    <path d="m8.3 10.8 7.4-4.5m-7.4 7 7.4 4.5"></path>
                </svg>
                {{ __('announcements.share', [], 'fr') }}
            </button>
            <span class="visually-hidden" role="status" aria-live="polite" data-share-status></span>
        </div>
    </div>
</header>
