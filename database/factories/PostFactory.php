<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'website_id' => random_int(1, 10),
            'title' => $this->faker->name(),
            'description' => $this->faker->text()
        ];
    }
}
