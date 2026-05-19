<?php

namespace Database\Factories;

use App\Models\Track;
use App\Models\RevenueEntry;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<RevenueEntry>
 */
class RevenueEntryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'track_id' => Track::factory(),
            'revenue_date' => fake()->date(),
            'amount' => fake()->randomFloat(2, 1000, 300000),
            'currency' => 'RUB',
            'source' => fake()->randomElement(['Streaming', 'Ads', 'Licensing']),
        ];
    }
}
