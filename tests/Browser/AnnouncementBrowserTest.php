<?php

namespace Tests\Browser;

use App\Models\Announcement;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

/**
 * Verifies announcement page behavior in a browser context.
 */
class AnnouncementBrowserTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * Confirms clicking the "add to favorites" button increments the favorites count by one.
     */
    public function testClickingAddToFavoritesButtonIncrementsFavoritesCountByOne(): void
    {
        $numberOfFavorites = random_int(1, 10);

        $users = User::factory()->count($numberOfFavorites)->create();
        $announcement = Announcement::factory()->create();

        $users->each(function (User $user) use ($announcement) {
            $announcement->addToFavorites($user);
        });

        $this->browse(function (Browser $browser) use ($announcement, $numberOfFavorites) {
            $browser->visit(route('announcements.show', $announcement))
                ->assertSeeIn('#fav [data-likes]', $numberOfFavorites)
                ->assertSeeIn('.meta [data-likes]', $numberOfFavorites);

            $browser->click('#fav')
                ->assertSeeIn('#fav [data-likes]', $numberOfFavorites + 1)
                ->assertSeeIn('.meta [data-likes]', $numberOfFavorites + 1);
        });
    }
}
