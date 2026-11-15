<?php

namespace Tests\Browser\Pages;

use App\Models\Announcement;
use Laravel\Dusk\Browser;

/**
 * Represents the public announcement detail page in browser tests.
 */
class AnnouncementPage extends Page
{
    public function __construct(private readonly Announcement $announcement) {}

    /**
     * Get the URL for the announcement.
     */
    public function url(): string
    {
        return route('announcements.show', $this->announcement, false);
    }

    /**
     * Assert that the browser is showing this announcement.
     */
    public function assert(Browser $browser): void
    {
        $browser->assertPathIs($this->url());
    }

    /**
     * Get the element shortcuts for the page.
     *
     * @return array<string, string>
     */
    public function elements(): array
    {
        return [
            '@favorite' => '#fav',
            '@favoriteCount' => '#fav [data-likes]',
            '@metaFavoriteCount' => '.meta [data-likes]',
            '@favoritesCountLabel' => '[data-favorites-label]',
        ];
    }
}
