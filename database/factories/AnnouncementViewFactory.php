<?php

namespace Database\Factories;

use App\Models\AnnouncementView;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<AnnouncementView>
 */
class AnnouncementViewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'visitor_id' => fake()->uuid,
            'viewed_on' => fake()->dateTimeBetween('-30 days', 'today'),
            // 'user_id' => null,
        ];
    }
}
