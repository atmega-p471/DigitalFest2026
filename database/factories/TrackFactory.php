<?php

namespace Database\Factories;

use App\Models\Track;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Track>
 */
class TrackFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(3),
            'isrc' => strtoupper(fake()->bothify('RU???26#####')),
            'release_date' => fake()->date(),
            'genre' => fake()->randomElement(['Pop', 'RNB', 'Hip-Hop', 'Dance']),
            'notes' => fake()->sentence(),
        ];
    }
}
