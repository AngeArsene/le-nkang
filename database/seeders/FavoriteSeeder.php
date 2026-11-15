<?php

namespace Database\Seeders;

use App\Models\Announcement;
use App\Models\User;
use Illuminate\Database\Seeder;

class FavoriteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        Announcement::all()->each(function ($announcement) use ($users) {
            $count = random_int(0, $users->count());

            if ($count > 0) {
                $users->random($count)->each(function ($user) use ($announcement) {
                    $announcement->addToFavorites($user);
                });
            }
        });
    }
}
