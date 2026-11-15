<?php

namespace Database\Seeders;

use App\Models\Announcement;
use App\Models\Review;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Announcement::each(function (Announcement $announcement): void {
            $count = random_int(0, 100);

            if ($count > 0) {
                Review::factory()->count($count)->for($announcement)->create();
            }
        });
    }
}
