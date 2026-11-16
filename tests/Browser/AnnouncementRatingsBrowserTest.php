<?php

namespace Tests\Browser;

use App\Models\Announcement;
use App\Models\Review;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\Browser\Pages\AnnouncementPage;
use Tests\DuskTestCase;

class AnnouncementRatingsBrowserTest extends DuskTestCase
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
     * Provides star distributions with the expected total.
     *
     * @return array<string, array{array<int, int>, int}>
     */
    public static function reviewSummaryProvider(): array
    {
        return [
            'mixed ratings' => [[5 => 27, 4 => 7, 3 => 1, 2 => 1], 36],
            'only excellent' => [[5 => 2], 2],
            'low ratings' => [[1 => 1, 2 => 1], 2],
            'single review' => [[3 => 1], 1],
        ];
    }

    /**
     * Confirms the displayed rating distribution matches the announcement's reviews.
     *
     * @param array<int, int> $distribution  An associative array where keys are review scores and values are their counts.
     * @param int $total  The total number of reviews.
     */
    #[DataProvider('reviewSummaryProvider')]
    public function testDisplayedRatingDistributionMatchesTheAnnouncementReviews(array $distribution, int $total): void
    {
        $announcement = Announcement::factory()->create();

        foreach ($distribution as $note => $count) {
            Review::factory()
                ->count($count)
                ->for($announcement)
                ->create(['note' => $note]);
        }

        $this->browse(function (Browser $browser) use ($announcement, $distribution, $total) {
            $browser->visit(new AnnouncementPage($announcement))
                ->scrollTo('h2#t-info');

            foreach ([5, 4, 3, 2, 1] as $index => $note) {
                $count = $distribution[$note] ?? 0;
                $row = 'ul.dist li:nth-child(' . ($index + 1) . ')';

                $browser->assertSeeIn("$row span", (string) $note)
                    ->assertSeeIn("$row b", (string) $count);

                $width = $browser->script(
                    "return document.querySelector('$row i').style.getPropertyValue('--w');"
                )[0];

                $this->assertSame(round(($count / $total) * 100) . '%', trim($width));
            }
        });
    }

    #[DataProvider('reviewSummaryProvider')]
    public function testAddingAReviewIncrementsTheTotalAndUpdatesTheRatingDistribution(array $distribution, int $total): void
    {
        $announcement = Announcement::factory()->create();

        foreach ($distribution as $note => $count) {
            Review::factory()
                ->count($count)
                ->for($announcement)
                ->create(['note' => $note]);
        }

        $distribution = array_combine(
            [5, 4, 3, 2, 1],
            array_map(fn (int $k) => $distribution[$k] ?? 0, [5, 4, 3, 2, 1])
        );

        $this->browse(function (Browser $browser) use ($announcement, $distribution, $total) {
            $browser->visit(new AnnouncementPage($announcement))
                ->scrollTo('h2#t-info');

            $randomNote = random_int(1, 5);

            $browser->click('@addReviewButton')
                ->waitFor('@addReviewForm')
                ->select('rating', (string) $randomNote)
                ->type('text', fake()->text(400))
                ->click('button[type="submit"]');

            $distribution[$randomNote] += 1;

            $browser->assertSeeIn('div#revSum p.sm', ($total+1)." avis")
                    ->assertSeeIn('span[data-total]', (string) $total + 1);

            foreach ([1 => 5, 4, 3, 2, 1] as $index => $note) {
                $browser->assertSeeIn("ul.dist li:nth-child($index) span", (string) $note)
                    ->assertSeeIn("ul.dist li:nth-child($index) b", (string) $distribution[$note]);
            }
        });
    }
}
