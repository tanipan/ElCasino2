<?php

namespace Database\Factories;

use App\Models\Customer;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class CustomerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Customer::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "name" => $this->faker->name(),
            "lastname" => $this->faker->lastName(),
            "email" => $this->faker->email(),
            "birthday" => $this->faker->date(),
            "phone" => $this->faker->phoneNumber(),
            "password" => Str::random(10),
            "token" => Str::random(32),
            "observacions" => $this->faker->text(),
        ];
    }
}
