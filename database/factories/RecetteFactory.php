<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Recette>
 */
class RecetteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph(),
            'ingredients' => implode(', ', $this->faker->words(5)),
            'steps' => $this->faker->paragraphs(2, true),
            'preparation_time' => $this->faker->numberBetween(10, 90),
            'type' => $this->faker->randomElement(['petit-déjeuner', 'déjeuner', 'dîner']),
            'rating' => $this->faker->numberBetween(1, 5),
        ];
    }
}
