<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Tusharkhan\BanglaFaker\Facade\BanglaFaker;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->word(),
            'title_bn' => BanglaFaker::sentence(),
            'slug' => fake()->slug(),
            'slug_bn' => fake()->slug(),
            'description' => fake()->paragraph(),
            'description_bn' => fake()->paragraph(),
            'status' => true,
        ];
    }
}
