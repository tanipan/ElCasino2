<?php

namespace Database\Factories;

use App\Models\dish;
use Illuminate\Database\Eloquent\Factories\Factory;

class DishFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = dish::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "name" => $this->faker->word(),
            "description" => $this->faker->sentence(),
            "price" => rand(0, 40),
            "minimum_units" => rand(0, 3),
            "img1" => $this->faker->imageUrl(),
            "hidden" => rand(0, 1),
            "restaurant_id" => rand(1, 10),
            "dish_type_id" => rand(1, 10),
        ];
    }
}
