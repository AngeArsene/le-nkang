<?php

namespace Database\Seeders;

use App\Models\Announcement;
use App\Models\AnnouncementView;
use App\Models\User;
use Illuminate\Database\Seeder;

class AnnouncementViewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Announcement::each(function (Announcement $announcement): void {
            $count = random_int(0, 1000);

            if ($count > 0) {
                if (fake()->boolean(50)) {
                    AnnouncementView::factory()
                        ->count($count)
                        ->for($announcement)
                        ->for(User::inRandomOrder()->first())
                        ->create();
                } else {
                    AnnouncementView::factory()
                        ->count($count)
                        ->for($announcement)
                        ->create();
                }

                $announcement->incrementViewsCount($count);
            }
        });
    }
}
