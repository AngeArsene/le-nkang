@props(['announcements'])

@if ($announcements->isNotEmpty())
    <section class="others" id="other-announcements" aria-labelledby="other-announcements-title">
        <div class="others-head">
            <div>
                <h2 id="other-announcements-title">{{ __('announcements.other_announcements', [], 'fr') }}</h2>
                <p class="muted">
                    {{ trans_choice('announcements.other_count', $announcements->count(), [], 'fr') }}
                </p>
            </div>
        </div>

        <div class="grid">
            @forelse ($announcements as $otherAnnouncement)
                <x-announcements.listing-card :announcement="$otherAnnouncement" />
            @empty
                <p class="empty">{{ __('announcements.search_empty', [], 'fr') }}</p>
            @endforelse
        </div>
    </section>
@endif
