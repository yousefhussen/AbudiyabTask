<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class CarFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'type' => $this->faker->randomElement(['SUV', 'Sedan', 'Hatchback', 'Convertible', 'Coupe', 'Minivan', 'Pickup', 'Station Wagon', 'Sports Car', 'Luxury Car']),
            'price_per_day' => $this->faker->randomFloat(2, 30, 100),
            'availability_status' => $this->faker->boolean,
            'image' => $this->faker->imageUrl(640, 480, 'cars', true),
        ];
    }
}
