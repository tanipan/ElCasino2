<?php

namespace Database\Factories;

use App\Models\DishType;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class DishTypeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = DishType::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "name" => $this->faker->word(),
            "slug" => Str::random(10),
            "hidden" => rand(0, 1)
        ];
    }
}
