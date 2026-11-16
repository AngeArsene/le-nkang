<?php

namespace Tests\Browser;

use App\Models\Announcement;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\Browser\Pages\AnnouncementPage;
use Tests\DuskTestCase;

class AnnouncementFavoritesBrowserTest extends DuskTestCase
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
     * Assert the label is singular before and after toggling from an initial count of one.
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
}
