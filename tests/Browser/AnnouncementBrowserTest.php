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
     * Clears browser cookies after each test and runs the parent teardown.
     */
    protected function tearDown(): void
    {
        foreach (static::$browsers as $browser) {
            $browser->driver->manage()->deleteAllCookies();
        }

        parent::tearDown();
    }

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

    /**
     * Confirms a guest viewing an announcement increases its displayed view count by one.
     */
    public function testGuestViewingAnAnnouncementIncrementsItsViewCountByOne(): void
    {
        $views_count = random_int(1, 10);
        $announcement = Announcement::factory()->create(compact('views_count'));

        $expected = trans_choice('announcements.views', $views_count + 1, [], 'fr');

        $this->browse(function (Browser $browser) use ($announcement, $expected) {
            $browser->visit(route('announcements.show', $announcement))
                ->assertSeeIn('.meta', $expected);
        });
    }

    /**
     * Confirms refreshing an announcement does not count the same visitor's view again.
     */
    public function testGuestRefreshingAnAlreadyViewedAnnouncementDoesNotChangeItsViewCount(): void
    {
        $views_count = random_int(1, 10);
        $announcement = Announcement::factory()->create(compact('views_count'));

        $expected = trans_choice('announcements.views', $views_count + 1, [], 'fr');

        $this->browse(function (Browser $browser) use ($announcement, $expected) {
            $browser->visit(route('announcements.show', $announcement))
                ->assertSeeIn('.meta', $expected);

            $browser->refresh()
                ->assertSeeIn('.meta', $expected);
        });
    }

    /**
     * Confirms a new browser visitor increments an announcement's view count again.
     */
    public function testGuestViewsAreCountedAgainForANewVisitor(): void
    {
        $views_count = random_int(1, 10);
        $announcement = Announcement::factory()->create(compact('views_count'));

        $this->browse(function (Browser $firstBrowser, Browser $secondBrowser) use ($announcement, $views_count) {
            $expectedFirstViewsCount = trans_choice('announcements.views', $views_count + 1, [], 'fr');
            $expectedSecondViewsCount = trans_choice('announcements.views', $views_count + 2, [], 'fr');

            $firstBrowser->visit(route('announcements.show', $announcement))
                ->assertSeeIn('.meta', $expectedFirstViewsCount);

            $secondBrowser->visit(route('announcements.show', $announcement))
                ->assertSeeIn('.meta', $expectedSecondViewsCount);
        });
    }

    /**
     * Confirms guest view counts are tracked independently for each announcement.
     */
    public function testGuestViewsAreTrackedPerAnnouncement(): void
    {
        $views_count_1 = random_int(1, 10);
        $views_count_2 = random_int(1, 10);

        $firstAnnouncement = Announcement::factory()->create(['views_count' => $views_count_1]);
        $secondAnnouncement = Announcement::factory()->create(['views_count' => $views_count_2]);

        $this->browse(function (Browser $browser) use ($firstAnnouncement, $secondAnnouncement, $views_count_1, $views_count_2) {
            $expectedFirstViewsCount = trans_choice('announcements.views', $views_count_1 + 1, [], 'fr');
            $expectedSecondViewsCount = trans_choice('announcements.views', $views_count_2 + 1, [], 'fr');

            $browser->visit(route('announcements.show', $firstAnnouncement))
                ->assertSeeIn('.meta', $expectedFirstViewsCount);

            $browser->visit(route('announcements.show', $secondAnnouncement))
                ->assertSeeIn('.meta', $expectedSecondViewsCount);

            $browser->visit(route('announcements.show', $firstAnnouncement))
                ->assertSeeIn('.meta', $expectedFirstViewsCount);
        });
    }
}
