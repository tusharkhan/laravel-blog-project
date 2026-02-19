<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Tusharkhan\BanglaFaker\Facade\BanglaFaker;

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
        $image = $this->faker->image('public/uploads/post', 640, 480, null, false);

        if(!$image) {
            $image = fake()->randomElement([1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11]) . '.jpg';
        }

        return [
            'user_id' => function () {
                return \App\Models\User::all()->random()->id;
            },
            'category_id' => function () {
                return \App\Models\Category::all()->random()->id;
            },
            'title' => fake()->sentence(),
            'title_bn' => BanglaFaker::sentence(),
            'slug' => fake()->slug(),
            'slug_bn' => str_replace(' ', '-', BanglaFaker::sentence()),
            'content' => fake()->paragraphs(3, true),
            'content_bn' => BanglaFaker::paragraph(50, true),
            'thumbnail' => $image,
            'publisher' => fake()->company(),
            'publisher_bn' => BanglaFaker::sentence(),
            'reporter' => fake()->name(),
            'reporter_bn' => BanglaFaker::maleName(),
            'location' => fake()->city(),
            'location_bn' => BanglaFaker::address(),
            'status' => true,
            'is_featured' => fake()->boolean(20),
            'enable_comment' => fake()->boolean(80),
            'views' => fake()->numberBetween(0, 5000),
        ];
    }
}
