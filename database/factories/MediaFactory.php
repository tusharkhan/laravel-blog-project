<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Tusharkhan\BanglaFaker\Facade\BanglaFaker;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Media>
 */
class MediaFactory extends Factory
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
            'title_bn' => BanglaFaker::sentence(3),
            'description' => $this->faker->paragraph(),
            'description_bn' => BanglaFaker::paragraph(2),
            'location' => $this->faker->city(),
            'location_bn' => BanglaFaker::address(),
            'user_id' => function () {
                return \App\Models\User::all()->random()->id;
            }
        ];
    }
}
