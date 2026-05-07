<?php

namespace Database\Factories;

use App\Models\address;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class AddressFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = address::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "address" => $this->faker->address(),
            "alias" => $this->faker->name(),
            "principal" => rand(0, 1),
            "observacions" => $this->faker->text(),
            "customer_id" => rand(1, 50),
        ];
    }
}
