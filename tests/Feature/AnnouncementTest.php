<?php

namespace Tests\Feature;

use App\Models\Announcement;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class AnnouncementTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutVite();
    }

    public function test_announcement_url_uses_slug(): void
    {
        $announcement = Announcement::factory()->create(['slug' => 'skinny-delicieuse']);

        $route = route('announcements.show', $announcement, false);

        $this->assertSame('/announcements/skinny-delicieuse', $route);
    }

    public function test_guest_user_can_view_an_announcement(): void
    {
        $announcement = Announcement::factory()->create([
            'title' => 'Skinny Délicieuse',
            'description' => 'Envie de détente et de destresser je suis disponible pour réaliser vos envies et plaisirs sexuels.',
        ]);

        $route = route('announcements.show', $announcement);

        $this->get($route)
            ->assertOk()
            ->assertSee($announcement->title)
            ->assertSee($announcement->description);

        $this->assertGuest();
    }

    public function test_unknown_announcement_slug_returns_not_found(): void
    {
        $this->get('/announcements/not-a-real-announcement')->assertNotFound();
    }

    public function test_announcement_page_renders_supported_content_and_hides_unsupported_sections(): void
    {
        $announcement = Announcement::factory()->create([
            'title' => 'Annonce publique',
            'description' => 'Une description issue du stockage.',
        ]);

        $this->get(route('announcements.show', $announcement))
            ->assertOk()
            ->assertSee($announcement->title)
            ->assertSee($announcement->description)
            ->assertSee('Aucune photo')
            ->assertDontSee('Tarifs')
            ->assertDontSee('Avis')
            ->assertDontSee('FCFA')
            ->assertDontSee('wa.me')
            ->assertDontSee('tel:')
            ->assertDontSee('1 284');
    }

    public function test_announcement_content_is_escaped_in_the_rendered_page(): void
    {
        $announcement = Announcement::factory()->create([
            'title' => '<script>alert("title")</script>',
            'description' => '<img src=x onerror=alert(1)>',
        ]);

        $this->get(route('announcements.show', $announcement))
            ->assertOk()
            ->assertSee('&lt;script&gt;alert(&quot;title&quot;)&lt;/script&gt;', false)
            ->assertSee('&lt;img src=x onerror=alert(1)&gt;', false)
            ->assertDontSee('<script>alert("title")</script>', false)
            ->assertDontSee('<img src=x onerror=alert(1)>', false);
    }

    public function test_other_announcements_exclude_the_current_announcement(): void
    {
        $announcement = Announcement::factory()->create(['slug' => 'current-announcement']);
        $otherAnnouncement = Announcement::factory()->create([
            'slug' => 'another-announcement',
            'title' => 'Une autre annonce',
        ]);

        $response = $this->get(route('announcements.show', $announcement));

        $response->assertOk()
            ->assertSee($otherAnnouncement->title)
            ->assertSee('class="announcement-card" href="'.route('announcements.show', $otherAnnouncement).'"', false)
            ->assertDontSee('class="announcement-card" href="'.route('announcements.show', $announcement).'"', false);
    }

    public function test_search_filters_other_announcements_by_title_and_description(): void
    {
        $announcement = Announcement::factory()->create(['slug' => 'current-announcement']);
        $matchingAnnouncement = Announcement::factory()->create([
            'title' => 'Atelier lumineux',
            'description' => 'Un endroit clair et calme.',
        ]);
        Announcement::factory()->create([
            'title' => 'Maison tranquille',
            'description' => 'Une adresse discrète.',
        ]);

        $this->get(route('announcements.show', [
            'announcement' => $announcement,
            'q' => 'lumineux',
        ]))
            ->assertOk()
            ->assertSee($matchingAnnouncement->title)
            ->assertDontSee('Maison tranquille');
    }

    public function test_related_listings_are_loaded_without_lazy_loading_or_n_plus_one_queries(): void
    {
        $announcement = Announcement::factory()->create();
        Announcement::factory()->count(6)->create();
        $queries = [];

        DB::listen(function (QueryExecuted $query) use (&$queries): void {
            if (str_starts_with(strtolower($query->sql), 'select')) {
                $queries[] = $query->sql;
            }
        });

        Model::preventLazyLoading();

        try {
            $this->get(route('announcements.show', $announcement))->assertOk();
        } finally {
            Model::preventLazyLoading(false);
        }

        $this->assertCount(2, $queries);
    }
}
