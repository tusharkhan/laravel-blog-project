<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => function () {
                return \App\Models\User::all()->random()->id;
            },
            'category_id' => function () {
                return \App\Models\Category::all()->random()->id;
            },
            'title' => fake()->sentence(),
            'slug' => fake()->slug(),
            'content' => fake()->paragraphs(3, true),
            'thumbnail' => fake()->imageUrl(600, 400, 'posts', true),
            'status' => true,
            'is_featured' => fake()->boolean(20),
            'enable_comment' => fake()->boolean(80),
        ];
    }
}
