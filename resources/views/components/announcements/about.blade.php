@props(['description'])

<section class="card beige about" id="about" aria-labelledby="about-title" data-about-section>
    <h2 id="about-title">{{ __('announcements.about', [], 'fr') }}</h2>
    <p class="about-copy" id="about-description" data-about-copy>{{ $description }}</p>
    <button
        class="btn dark sm"
        type="button"
        aria-expanded="false"
        aria-controls="about-description"
        data-about-toggle
        data-read-more="{{ __('announcements.read_more', [], 'fr') }}"
        data-read-less="{{ __('announcements.read_less', [], 'fr') }}"
        hidden
    >
        {{ __('announcements.read_more', [], 'fr') }}
    </button>
</section>
