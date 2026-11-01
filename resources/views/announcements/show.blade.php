@extends('layouts.announcements')

@section('title', __('announcements.page_title', ['title' => $announcement->title], 'fr'))

@push('head')
    <meta name="description" content="{{ $metaDescription }}">
    <link rel="canonical" href="{{ route('announcements.show', $announcement) }}">
    <meta property="og:type" content="article">
    <meta property="og:title" content="{{ __('announcements.page_title', ['title' => $announcement->title], 'fr') }}">
    <meta property="og:description" content="{{ $metaDescription }}">
    <meta property="og:url" content="{{ route('announcements.show', $announcement) }}">
@endpush

@section('content')
    <div class="app">
        <aside class="side" aria-label="{{ __('announcements.primary_navigation', [], 'fr') }}">
            <a class="logo" href="#main-content" aria-label="{{ __('announcements.brand_home', [], 'fr') }}">
                <span class="mark" aria-hidden="true">N</span>
                <span>
                    {{ __('announcements.brand_prefix', [], 'fr') }}
                    <b>{{ __('announcements.brand_suffix', [], 'fr') }}</b>
                </span>
            </a>

            <nav class="side-nav" aria-label="{{ __('announcements.announcement_navigation', [], 'fr') }}">
                @if (filled($announcement->description))
                    <a href="#about">{{ __('announcements.about', [], 'fr') }}</a>
                @endif
                <a href="#safety">{{ __('announcements.safety_title', [], 'fr') }}</a>
                @if ($otherAnnouncements->isNotEmpty())
                    <a href="#other-announcements">{{ __('announcements.other_announcements', [], 'fr') }}</a>
                @endif
            </nav>
        </aside>

        <main class="main" id="main-content">
            <form class="search" method="GET" action="{{ route('announcements.show', $announcement) }}">
                <span class="search-mark" aria-hidden="true">
                    <svg viewBox="0 0 24 24"><circle cx="10.8" cy="10.8" r="6.5"></circle><path d="m16 16 4.2 4.2"></path></svg>
                </span>
                <label class="visually-hidden" for="announcement-search">
                    {{ __('announcements.search_label', [], 'fr') }}
                </label>
                <input
                    id="announcement-search"
                    type="search"
                    name="q"
                    value="{{ $search }}"
                    maxlength="100"
                    placeholder="{{ __('announcements.search_placeholder', [], 'fr') }}"
                >
                <button class="search-submit" type="submit" aria-label="{{ __('announcements.search_submit', [], 'fr') }}">
                    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="m9 5 7 7-7 7M16 12H3"></path></svg>
                </button>
            </form>

            <div class="topline">
                <a class="back" href="#main-content" aria-label="{{ __('announcements.back_to_top', [], 'fr') }}">
                    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 19V5m-6 6 6-6 6 6"></path></svg>
                </a>
                <nav aria-label="{{ __('announcements.breadcrumb', [], 'fr') }}">
                    <ol class="crumbs">
                        <li><a href="#main-content">{{ __('announcements.brand_name', [], 'fr') }}</a></li>
                        <li aria-current="page">{{ $announcement->title }}</li>
                    </ol>
                </nav>
            </div>

            <x-announcements.hero :announcement="$announcement" />
            <x-announcements.gallery />

            @if (filled($announcement->description))
                <x-announcements.about :description="$announcement->description" />
            @endif

            <x-announcements.safety />

            @if ($search !== '' && $otherAnnouncements->isEmpty())
                <p class="search-empty" role="status">
                    {{ __('announcements.search_empty', [], 'fr') }}
                </p>
            @endif

            <x-announcements.related-listings :announcements="$otherAnnouncements" />
        </main>

        <footer class="foot">
            <span>{{ __('announcements.copyright', ['year' => now()->year], 'fr') }}</span>
            <span>{{ __('announcements.adult_notice', [], 'fr') }}</span>
            <a href="#safety">{{ __('announcements.safety_title', [], 'fr') }}</a>
        </footer>
    </div>
@endsection
