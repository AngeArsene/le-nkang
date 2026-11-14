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

        $this->browse(function (Browser $browser) use ($announcement, $views_count) {
            $browser->visit(route('announcements.show', $announcement))
                ->assertSee(($views_count + 1) . ' vues');
        });
    }

    /**
     * Confirms refreshing an announcement does not count the same visitor's view again.
     */
    public function testGuestRefreshingAnAlreadyViewedAnnouncementDoesNotChangeItsViewCount(): void
    {
        $views_count = random_int(1, 10);
        $announcement = Announcement::factory()->create(compact('views_count'));

        $this->browse(function (Browser $browser) use ($announcement, $views_count) {
            $expectedViewsCount = $views_count + 1;

            $browser->visit(route('announcements.show', $announcement))
                ->assertSee("$expectedViewsCount vues")
                ->refresh()
                ->assertSee("$expectedViewsCount vues");
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
            $expectedFirstViewsCount = $views_count + 1;
            $expectedSecondViewsCount = $views_count + 2;

            $firstBrowser->visit(route('announcements.show', $announcement))
                ->assertSee("$expectedFirstViewsCount vues");

            $secondBrowser->visit(route('announcements.show', $announcement))
                ->assertSee("$expectedSecondViewsCount vues");
        });
    }

    /**
     * Confirms guest view counts are tracked independently for each announcement.
     */
    public function testGuestViewsAreTrackedPerAnnouncement(): void
    {
        $first_announcement_views_count = random_int(1, 10);
        $second_announcement_views_count = random_int(1, 10);

        $firstAnnouncement = Announcement::factory()->create([
            'views_count' => $first_announcement_views_count
        ]);
        $secondAnnouncement = Announcement::factory()->create([
            'views_count' => $second_announcement_views_count
        ]);

        $this->browse(function (Browser $browser) use (
            $firstAnnouncement,
            $secondAnnouncement,
            $first_announcement_views_count,
            $second_announcement_views_count
        ) {
            $expectedFirstAnnouncementViewsCount = $first_announcement_views_count + 1;
            $expectedSecondAnnouncementViewsCount = $second_announcement_views_count + 1;

            $browser->visit(route('announcements.show', $firstAnnouncement))
                ->assertSee("$expectedFirstAnnouncementViewsCount vues");

            $browser->visit(route('announcements.show', $secondAnnouncement))
                ->assertSee("$expectedSecondAnnouncementViewsCount vues");

            $browser->visit(route('announcements.show', $firstAnnouncement))
                ->assertSee("$expectedFirstAnnouncementViewsCount vues");
        });
    }
}
