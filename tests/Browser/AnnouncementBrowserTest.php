<?php

namespace Tests\Browser;

use App\Models\Announcement;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\Browser\Pages\AnnouncementPage;
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
            $browser->visit(new AnnouncementPage($announcement))
                ->assertSeeIn('#fav [data-likes]', $numberOfFavorites)
                ->assertSeeIn('ul.meta li [data-likes]', $numberOfFavorites);

            $browser->click('@favorite')
                ->assertSeeIn('@favoriteCount', $numberOfFavorites + 1)
                ->assertSeeIn('ul.meta li [data-likes]', $numberOfFavorites + 1);
        });
    }

    /**
     * Provide the expected French labels for favorite totals.
     *
     * @return array<string, array{int, string}>
     */
    public static function favoritesLabelProvider(): array
    {
        return [
            '0 favori' => [0, 'favori'],
            '1 favori' => [1, 'favori'],
            '2 favoris' => [2, 'favoris'],
            '5 favoris' => [5, 'favoris'],
        ];
    }

    /**
     * Confirm the favorites label uses singular and plural forms correctly.
     */
    #[DataProvider('favoritesLabelProvider')]
    public function testFavoritesLabelIsSingularForZeroOrOneAndPluralOtherwise(int $numberOfFavorites, string $expectedLabel): void
    {
        $announcement = Announcement::factory()->create();

        User::factory()->count($numberOfFavorites)->create()
            ->each(fn(User $user) => $announcement->addToFavorites($user));

        $this->browse(function (Browser $browser) use ($announcement, $expectedLabel) {
            $browser->visit(new AnnouncementPage($announcement))
                ->assertSeeIn('@favoritesCountLabel', $expectedLabel);
        });
    }

    /**
     * Confirm a favorite toggle keeps the singular label when the count stays at one.
     */
    public function testClickingAddToFavoritesKeepsLabelSingularFromZeroToOne(): void
    {
        $announcement = Announcement::factory()->create();
        $user = User::factory()->create();

        $announcement->addToFavorites($user);

        $this->browse(function (Browser $browser) use ($announcement) {
            $browser->visit(new AnnouncementPage($announcement))
                ->assertSeeIn('@favoritesCountLabel', 'favori');

            $browser->click('@favorite')
                ->assertSeeIn('@favoritesCountLabel', 'favori');
        });
    }

    /**
     * Confirm the label changes to plural after the count goes above one.
     */
    public function testClickingAddToFavoritesChangesLabelToPluralFromOneToTwo(): void
    {
        $announcement = Announcement::factory()->create();
        $user = User::factory()->create();

        $announcement->addToFavorites($user);

        $this->browse(function (Browser $browser) use ($announcement) {
            $browser->visit(new AnnouncementPage($announcement))
                ->assertSeeIn('@favoritesCountLabel', 'favori');

            $browser->click('@favorite')
                ->assertSeeIn('@favoritesCountLabel', 'favoris');
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
            $browser->visit(new AnnouncementPage($announcement))
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
